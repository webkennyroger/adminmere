<?php

namespace App\Jobs;

use App\Models\Activity;
use App\Models\Segment;
use App\Models\SegmentEffort;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

/**
 * Detects whether a finished activity's GPS route crosses any known segment
 * and, if so, records the time it took to cover it (a "segment effort").
 *
 * Runs as a queued job (not synchronously in the activity save request) since
 * it may need to check the route against several nearby segments.
 */
class MatchSegmentsForActivity implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $activityId) {}

    public function handle(): void
    {
        $activity = Activity::find($this->activityId);
        if (! $activity) {
            return;
        }

        $points = $activity->polylines['points'] ?? [];
        if (empty($points) || ! $this->pointsHaveTimestamps($points)) {
            // Rota sem timestamp por ponto (atividade antiga ou sem GPS
            // suficiente) — não é possível calcular tempo em segmento.
            return;
        }

        $bounds = $this->routeBounds($points);
        if ($bounds === null) {
            return;
        }

        $nearbySegments = Segment::query()
            ->where('sport_type', $activity->sport_type)
            ->whereBetween('start_lat', [$bounds['min_lat'], $bounds['max_lat']])
            ->whereBetween('start_lng', [$bounds['min_lng'], $bounds['max_lng']])
            ->get();

        foreach ($nearbySegments as $segment) {
            $effort = $this->matchSegment($segment, $points);
            if ($effort === null) {
                continue;
            }

            SegmentEffort::updateOrCreate(
                [
                    'segment_id' => $segment->id,
                    'activity_id' => $activity->id,
                ],
                [
                    'user_id' => $activity->user_id,
                    'duration_seconds' => $effort['duration_seconds'],
                    'achieved_at' => $activity->start_time,
                ]
            );
        }
    }

    /**
     * Scans the route for the first point within radius of the segment's
     * start, then the first subsequent point within radius of its end.
     * Returns the elapsed time between them, or null if no match.
     *
     * @param  array<int, array{lat: float, lng: float, t: int}>  $points
     * @return array{duration_seconds: int}|null
     */
    private function matchSegment(Segment $segment, array $points): ?array
    {
        $startIndex = null;
        foreach ($points as $index => $point) {
            if ($this->haversineMeters($point['lat'], $point['lng'], $segment->start_lat, $segment->start_lng) <= $segment->radius_m) {
                $startIndex = $index;
                break;
            }
        }

        if ($startIndex === null) {
            return null;
        }

        for ($i = $startIndex + 1; $i < count($points); $i++) {
            $point = $points[$i];
            if ($this->haversineMeters($point['lat'], $point['lng'], $segment->end_lat, $segment->end_lng) <= $segment->radius_m) {
                $durationSeconds = (int) ($point['t'] - $points[$startIndex]['t']);
                if ($durationSeconds <= 0) {
                    return null;
                }

                return ['duration_seconds' => $durationSeconds];
            }
        }

        return null;
    }

    /**
     * @param  array<int, array<string, mixed>>  $points
     */
    private function pointsHaveTimestamps(array $points): bool
    {
        $sample = $points[0] ?? null;

        return is_array($sample) && isset($sample['t']);
    }

    /**
     * Bounding box of the route, padded so segments just outside the exact
     * route extents (GPS drift) still get considered.
     *
     * @param  array<int, array{lat: float, lng: float}>  $points
     * @return array{min_lat: float, max_lat: float, min_lng: float, max_lng: float}|null
     */
    private function routeBounds(array $points): ?array
    {
        if (empty($points)) {
            return null;
        }

        $lats = array_column($points, 'lat');
        $lngs = array_column($points, 'lng');

        $padding = 0.01; // ~1.1km, cobre a tolerância do raio do segmento

        return [
            'min_lat' => min($lats) - $padding,
            'max_lat' => max($lats) + $padding,
            'min_lng' => min($lngs) - $padding,
            'max_lng' => max($lngs) + $padding,
        ];
    }

    /**
     * Great-circle distance between two coordinates, in meters.
     */
    private function haversineMeters(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadiusMeters = 6371000;

        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lngDelta / 2) ** 2;

        return $earthRadiusMeters * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
