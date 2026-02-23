<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    use \App\Traits\ResolvesActivityItems;

    public function index(Request $request)
    {
        $user = $request->user();
        $feed = $request->query('feed', 'personal');

        $query = Activity::with(['user.profile', 'likes', 'savedItems', 'comments' => function ($q) {
            $q->whereNull('parent_id')->latest();
        }]);

        if ($feed === 'timeline' || $feed === 'network' || $feed === 'community') {
            $query->where('privacy', 'public');
        } elseif ($feed === 'personal') {
            $query->where('user_id', $user->id);
        }

        $activities = $query->latest('start_time')->limit(50)->get();

        return response()->json([
            'success' => true,
            'data' => $activities->map(fn ($a) => $this->formatActivity($a, $user)),
        ]);
    }

    /**
     * Get activity history for the current user.
     */
    public function history(Request $request)
    {
        $user = $request->user();
        $perPage = (int) $request->get('per_page', 20);

        $activities = Activity::with(['user.profile', 'likes', 'savedItems'])
            ->where('user_id', $user->id)
            ->whereNotNull('sport_type')
            ->latest('start_time')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $activities->map(function ($activity) use ($user) {
                return $this->formatActivity($activity, $user);
            }),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
            ],
        ]);
    }

    /**
     * Store or update an activity from the mobile app.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|string',
            'activityTitle' => 'required|string',
            'sport' => 'required|string',
            'createdAt' => 'required|date',
            'distanceInMeters' => 'required|numeric',
            'durationInSeconds' => 'required|integer',
            'routePoints' => 'nullable|array',
            'calories' => 'nullable|numeric',
            'privacy' => 'nullable|string',
            'location' => 'nullable|string',
            'feedType' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        $taggedUsers = [];
        if ($request->has('taggedPartnerIds')) {
            $taggedIds = $request->taggedPartnerIds;
            if (is_array($taggedIds) && count($taggedIds) > 0) {
                $taggedUsers = \App\Models\User::whereIn('id', $taggedIds)
                    ->select('id', 'name', 'avatar')
                    ->get()
                    ->toArray();
            }
        }

        $polylines = $request->routePoints ?? [];
        if (is_array($polylines) && ! empty($polylines)) {
            if (! isset($polylines['summary_polyline'])) {
                $summary = $this->encodePolyline($polylines);
                $polylines = [
                    'points' => $polylines,
                    'summary_polyline' => $summary,
                ];
            }
        } elseif (empty($polylines)) {
            $polylines = null;
        }

        $activity = Activity::updateOrCreate(
            [
                'app_id' => $request->id ?? null,
                'user_id' => $user->id,
            ],
            [
                'title' => $request->activityTitle,
                'sport_type' => $request->sport,
                'start_time' => Carbon::parse($request->createdAt),
                'distance' => $request->distanceInMeters,
                'duration' => $request->durationInSeconds,
                'calories' => $request->calories ?? 0,
                'polylines' => $polylines,
                'privacy' => $request->privacy ?? 'public',
                'location' => $request->location ?? '',
                'feed_type' => $request->feedType ?? 'personal',
                'description' => $request->description ?? '',
                'mood' => $request->mood,
                'media' => $request->mediaPaths ?? [],
                'tagged_users' => $taggedUsers,
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $this->formatActivity($activity, $user),
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        if ($item->user_id != $user->id && ! $user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'activityTitle' => 'nullable|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'privacy' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $item->update([
            'title' => $request->activityTitle ?? $request->title ?? $item->title,
            'description' => $request->description ?? $request->content ?? ($item->description ?? $item->content),
            'content' => $request->content ?? $request->description ?? ($item->content ?? $item->description),
            'privacy' => $request->privacy ?? $item->privacy,
        ]);

        if ($item instanceof \App\Models\Activity) {
            $formatted = $this->formatActivity($item->refresh(), $user);
        } else {
            $formatted = $item->refresh();
        }

        return response()->json([
            'success' => true,
            'data' => $formatted,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        if ($item->user_id != $user->id && ! $user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json(['success' => true]);
    }

    public function formatActivity($activity, $user)
    {
        $routePoints = $activity->polylines;
        if (is_array($routePoints) && isset($routePoints['points'])) {
            $routePoints = $routePoints['points'];
        }

        return [
            'id' => 'activity_'.$activity->id,
            'user_id' => (string) $activity->user_id,
            'userName' => $activity->user->name,
            'userAvatarUrl' => $activity->user->image_url,
            'type' => 'activity',
            'activityTitle' => $activity->title,
            'sport' => $activity->sport_type,
            'createdAt' => ($activity->start_time ?? $activity->created_at)->toIso8601String(),
            'distanceInMeters' => (float) $activity->distance,
            'durationInSeconds' => (int) $activity->duration,
            'routePoints' => $routePoints ?? [],
            'likes' => $activity->likes->count(),
            'isLiked' => $user ? $activity->likes->where('user_id', $user->id)->isNotEmpty() : false,
            'isSaved' => $user ? $activity->savedItems->where('user_id', $user->id)->isNotEmpty() : false,
            'commentsList' => [], // Separate comments for performance if needed
        ];
    }

    /**
     * Google Polyline Algorithm Implementation
     */
    private function encodePolyline($points)
    {
        if (empty($points)) {
            return '';
        }
        $res = '';
        $last_lat = 0;
        $last_lng = 0;
        foreach ($points as $point) {
            $lat = round($point['lat'] * 1e5);
            $lng = round($point['lng'] * 1e5);
            $d_lat = $lat - $last_lat;
            $d_lng = $lng - $last_lng;
            $res .= $this->encodeSignedNumber($d_lat).$this->encodeSignedNumber($d_lng);
            $last_lat = $lat;
            $last_lng = $lng;
        }

        return $res;
    }

    private function encodeSignedNumber($n)
    {
        $sgn_num = $n << 1;
        if ($n < 0) {
            $sgn_num = ~($sgn_num);
        }

        return $this->encodeNumber($sgn_num);
    }

    private function encodeNumber($n)
    {
        $res = '';
        while ($n >= 0x20) {
            $res .= chr((0x20 | ($n & 0x1F)) + 63);
            $n >>= 5;
        }
        $res .= chr($n + 63);

        return $res;
    }
}
