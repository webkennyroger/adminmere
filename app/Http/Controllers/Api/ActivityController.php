<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResolvesActivityItems;
use App\Traits\FormatsApiData;

class ActivityController extends Controller
{
    use ResolvesActivityItems, FormatsApiData;

    /**
     * Get list of user activities and posts with feed filtering.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $feed = $request->query('feed', 'personal');

        // Fetch Activities
        $activitiesQuery = Activity::with(['user.profile', 'likes', 'savedItems', 'comments' => function ($q) {
            $q->whereNull('parent_id')->latest();
        }]);

        // Fetch Posts
        $postsQuery = Post::with(['user.profile', 'likes', 'savedItems', 'pollOptions', 'pollVotes', 'comments' => function ($q) {
            $q->whereNull('parent_id')->latest();
        }]);

        // Apply filters based on feed type
        if ($feed === 'timeline' || $feed === 'network') {
            $postsQuery->where('privacy', 'public');
            $activitiesQuery->where('privacy', 'public');
        } elseif ($feed === 'personal') {
            $postsQuery->where('user_id', $user->id);
            $activitiesQuery->where('user_id', $user->id);
        } elseif ($feed === 'community') {
            $postsQuery->where(function($q) {
                $q->where('feed_type', 'community')->orWhere('privacy', 'public');
            });
            $activitiesQuery->where('privacy', 'public');
        }

        // Limit results to improve performance
        $activities = $activitiesQuery->latest('start_time')->limit(50)->get();
        $posts = $postsQuery->latest('created_at')->limit(50)->get();

        // Merge and sort
        $items = collect([])
            ->merge($activities->map(fn($item) => ['type' => 'activity', 'data' => $item, 'date' => $item->start_time ?? $item->created_at]))
            ->merge($posts->map(fn($item) => ['type' => $item->type, 'data' => $item, 'date' => $item->created_at]))
            ->sortByDesc('date')
            ->take(50);

        $formatted = $items->map(function ($item) use ($user) {
            if ($item['type'] === 'activity') {
                return $this->formatActivity($item['data'], $user);
            }
            return $this->formatPost($item['data'], $user);
        })->values();

        return response()->json([
            'success' => true,
            'data' => $formatted,
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

    /**
     * Delete an activity.
     */
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

    /**
     * Google Polyline Algorithm Implementation
     */
    private function encodePolyline($points)
    {
        if (empty($points)) return '';
        $res = ''; $last_lat = 0; $last_lng = 0;
        foreach ($points as $point) {
            $lat = round($point['lat'] * 1e5); $lng = round($point['lng'] * 1e5);
            $d_lat = $lat - $last_lat; $d_lng = $lng - $last_lng;
            $res .= $this->encodeSignedNumber($d_lat) . $this->encodeSignedNumber($d_lng);
            $last_lat = $lat; $last_lng = $lng;
        }
        return $res;
    }

    private function encodeSignedNumber($n)
    {
        $sgn_num = $n << 1;
        if ($n < 0) $sgn_num = ~($sgn_num);
        return $this->encodeNumber($sgn_num);
    }

    private function encodeNumber($n)
    {
        $res = '';
        while ($n >= 0x20) {
            $res .= chr((0x20 | ($n & 0x1f)) + 63);
            $n >>= 5;
        }
        $res .= chr($n + 63);
        return $res;
    }
}
