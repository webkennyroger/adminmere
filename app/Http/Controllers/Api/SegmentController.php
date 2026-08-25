<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Segment;
use App\Models\SegmentEffort;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SegmentController extends Controller
{
    /**
     * List segments near a given point, sorted by distance.
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius_km' => 'nullable|numeric|min:0.1|max:50',
            'sport_type' => 'nullable|string',
        ]);

        $lat = (float) $validated['lat'];
        $lng = (float) $validated['lng'];
        $radiusKm = (float) ($validated['radius_km'] ?? 5);
        $degreesPadding = $radiusKm / 111; // ~111km per degree of latitude

        $segments = Segment::query()
            ->when($validated['sport_type'] ?? null, fn ($query, $sport) => $query->where('sport_type', $sport))
            ->whereBetween('start_lat', [$lat - $degreesPadding, $lat + $degreesPadding])
            ->whereBetween('start_lng', [$lng - $degreesPadding, $lng + $degreesPadding])
            ->get()
            ->map(function (Segment $segment) use ($lat, $lng) {
                $segment->distance_km = round($this->haversineMeters($lat, $lng, $segment->start_lat, $segment->start_lng) / 1000, 2);

                return $segment;
            })
            ->filter(fn (Segment $segment) => $segment->distance_km <= $radiusKm)
            ->sortBy('distance_km')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $segments->map(fn (Segment $segment) => [
                'id' => $segment->id,
                'name' => $segment->name,
                'sport_type' => $segment->sport_type,
                'start_lat' => $segment->start_lat,
                'start_lng' => $segment->start_lng,
                'end_lat' => $segment->end_lat,
                'end_lng' => $segment->end_lng,
                'distance_km' => $segment->distance_km,
                'efforts_count' => $segment->efforts()->count(),
            ]),
        ]);
    }

    /**
     * Create a segment from two points, typically chosen from a saved activity's route.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sport_type' => 'nullable|string',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'end_lat' => 'required|numeric',
            'end_lng' => 'required|numeric',
            'radius_m' => 'nullable|integer|min:10|max:200',
        ]);

        $segment = Segment::create([
            ...$validated,
            'sport_type' => $validated['sport_type'] ?? 'running',
            'radius_m' => $validated['radius_m'] ?? 40,
            'created_by' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $segment->id,
                'name' => $segment->name,
            ],
        ], 201);
    }

    /**
     * Leaderboard for a segment: each user's best (fastest) effort, ranked ascending.
     */
    public function show(Segment $segment): JsonResponse
    {
        $bestEfforts = SegmentEffort::where('segment_id', $segment->id)
            ->selectRaw('user_id, MIN(duration_seconds) as best_seconds')
            ->groupBy('user_id')
            ->orderBy('best_seconds')
            ->get();

        $users = User::whereIn('id', $bestEfforts->pluck('user_id'))->get()->keyBy('id');

        $leaderboard = $bestEfforts->values()->map(function ($effort, $index) use ($users) {
            $user = $users->get($effort->user_id);

            return [
                'rank' => $index + 1,
                'user_id' => $effort->user_id,
                'user_name' => $user?->name,
                'user_avatar' => $user?->image_url,
                'best_seconds' => (int) $effort->best_seconds,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $segment->id,
                'name' => $segment->name,
                'sport_type' => $segment->sport_type,
                'leaderboard' => $leaderboard,
            ],
        ]);
    }

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
