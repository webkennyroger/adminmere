<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ActivityController extends Controller
{
    /**
     * Get list of user activities with feed filtering.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $feed = $request->query('feed', 'personal');
        
        $query = Activity::with([
            'user', 
            'comments' => function($q) {
                $q->whereNull('parent_id')->latest();
            }, 
            'comments.user', 
            'comments.likes',
            'likes'
        ]);

        if ($feed === 'personal') {
            $query->where('user_id', $user->id);
        } elseif ($feed === 'timeline' || $feed === 'network') {
            $followingIds = $user->following()->pluck('users.id')->toArray();
            $followingIds[] = $user->id;
            $query->whereIn('user_id', $followingIds);
        }

        $activities = $query->latest('start_time')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $activities->map(function($activity) use ($user) {
                return $this->formatActivity($activity, $user);
            }),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
            ]
        ]);
    }

    /**
     * Store or update an activity from the mobile app.
     */
    public function store(Request $request)
    {
        // Validation matching app data
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|string', // Mobile App ID (UUID)
            'activityTitle' => 'required|string',
            'sport' => 'required|string',
            'createdAt' => 'required|date',
            'distanceInMeters' => 'required|numeric',
            'durationInSeconds' => 'required|integer',
            'routePoints' => 'nullable|array',
            'calories' => 'nullable|numeric',
            'privacy' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Resolve Tagged Users if provided
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
        if (is_array($polylines) && !empty($polylines) && !isset($polylines['summary_polyline'])) {
            $summary = $this->encodePolyline($polylines);
            $polylines = [
                'points' => $polylines,
                'summary_polyline' => $summary
            ];
        }

        // Create or Update based on 'app_id'
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
                'description' => $request->notes,
                'mood' => $request->mood,
                'media' => $request->mediaPaths ?? [],
                'tagged_users' => $taggedUsers,
            ]
        );

        $activity->load('user', 'likes', 'comments');

        return response()->json([
            'success' => true,
            'message' => 'Activity synced successfully',
            'data' => $this->formatActivity($activity, $user)
        ], 201);
    }

    /**
     * Display the specified activity.
     */
    public function show(Request $request, $id)
    {
        $activity = Activity::with(['user', 'likes', 'comments.user', 'comments.replies'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->formatActivity($activity, $request->user())
        ]);
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        // Check if user owns this activity
        if ($activity->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'activityTitle' => 'sometimes|string',
            'sport' => 'sometimes|string',
            'distanceInMeters' => 'sometimes|numeric',
            'durationInSeconds' => 'sometimes|integer',
            'calories' => 'sometimes|numeric',
            'privacy' => 'sometimes|in:public,friends,private',
            'notes' => 'nullable|string',
            'mood' => 'nullable|integer|min:1|max:5',
            'mediaPaths' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = [];
        if ($request->has('activityTitle')) $updateData['title'] = $request->activityTitle;
        if ($request->has('sport')) $updateData['sport_type'] = $request->sport;
        if ($request->has('distanceInMeters')) $updateData['distance'] = $request->distanceInMeters;
        if ($request->has('durationInSeconds')) $updateData['duration'] = $request->durationInSeconds;
        if ($request->has('calories')) $updateData['calories'] = $request->calories;
        if ($request->has('privacy')) $updateData['privacy'] = $request->privacy;
        if ($request->has('notes')) $updateData['description'] = $request->notes;
        if ($request->has('mood')) $updateData['mood'] = $request->mood;
        if ($request->has('mediaPaths')) $updateData['media'] = $request->mediaPaths;

        $activity->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Activity updated successfully',
            'data' => $this->formatActivity($activity, $request->user())
        ]);
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        // Check if user owns this activity
        if ($activity->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Activity deleted successfully'
        ]);
    }

    /**
     * Toggle like on activity.
     */
    public function toggleLike(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $user = $request->user();

        $existingLike = $activity->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $isLiked = false;
        } else {
            $activity->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }
        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $activity->likes()->count()
        ]);
    }

    /**
     * Store comment on activity.
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $activity = Activity::findOrFail($id);
        $user = $request->user();

        $comment = $activity->comments()->create([
            'user_id' => $user->id,
            'body' => $request->body,
            'parent_id' => $request->parent_id
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->formatComment($comment->load('user'))
        ]);
    }

    /**
     * Sync multiple activities from mobile app.
     */
    public function sync(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activities' => 'required|array',
            'activities.*.id' => 'required|string',
            'activities.*.activityTitle' => 'required|string',
            'activities.*.sport' => 'required|string',
            'activities.*.createdAt' => 'required|date',
            'activities.*.distanceInMeters' => 'required|numeric',
            'activities.*.durationInSeconds' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $synced = [];
        $errors = [];

        foreach ($request->activities as $activityData) {
            try {
                $polylines = $activityData['routePoints'] ?? [];
                if (is_array($polylines) && !empty($polylines) && !isset($polylines['summary_polyline'])) {
                    $summary = $this->encodePolyline($polylines);
                    $polylines = [
                        'points' => $polylines,
                        'summary_polyline' => $summary
                    ];
                }

                $activity = Activity::updateOrCreate(
                    [
                        'app_id' => $activityData['id'],
                        'user_id' => $request->user()->id,
                    ],
                    [
                        'title' => $activityData['activityTitle'],
                        'sport_type' => $activityData['sport'],
                        'start_time' => Carbon::parse($activityData['createdAt']),
                        'distance' => $activityData['distanceInMeters'],
                        'duration' => $activityData['durationInSeconds'],
                        'calories' => $activityData['calories'] ?? 0,
                        'polylines' => $polylines,
                        'privacy' => $activityData['privacy'] ?? 'public',
                        'description' => $activityData['notes'] ?? null,
                        'mood' => $activityData['mood'] ?? null,
                        'media' => $activityData['mediaPaths'] ?? [],
                    ]
                );

                $synced[] = $activity->id;
            } catch (\Exception $e) {
                $errors[] = [
                    'app_id' => $activityData['id'] ?? 'unknown',
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'success' => true,
            'synced_count' => count($synced),
            'synced_ids' => $synced,
            'errors' => $errors
        ]);
    }

    /**
     * Format activity for API response.
     */
    public function formatActivity($activity, $user)
    {
        $routePoints = $activity->polylines;
        // If we stored it as our new structure, return only the points to the app
        if (is_array($routePoints) && isset($routePoints['points'])) {
            $routePoints = $routePoints['points'];
        }

        return [
            'id' => (string)$activity->id,
            'app_id' => $activity->app_id,
            'user_id' => (string)$activity->user_id,
            'userName' => $activity->user->name,
            'userAvatarUrl' => $activity->user->image_url,
            'activityTitle' => $activity->title,
            'sport' => $activity->sport_type,
            'createdAt' => $activity->start_time->toIso8601String(),
            'location' => $activity->user->profile->city ?? 'Brasil',
            'distanceInMeters' => (double)$activity->distance,
            'durationInSeconds' => (int)$activity->duration,
            'routePoints' => $routePoints ?? [],
            'calories' => (double)$activity->calories,
            'likes' => $activity->likes->count(),
            'isLiked' => $activity->likes->contains('user_id', $user->id),
            'commentsList' => $activity->comments->map(function($comment) {
                return $this->formatComment($comment);
            })->toArray(),
            'shares' => 0,
            'likers' => $activity->likes->take(3)->map(function($like) {
                return $like->user->image_url;
            })->toArray(),
            'privacy' => $activity->privacy,
            'notes' => $activity->description,
            'taggedPartnerIds' => collect($activity->tagged_users ?? [])->pluck('id')->map(fn($id) => (string)$id)->toArray(),
            'mood' => $activity->mood,
            'mediaPaths' => $activity->media ?? [],
            'mapType' => 'normal',
            'points' => (int)($activity->distance / 100),
        ];
    }

    /**
     * Format comment for JSON string (app requirement)
     */
    private function formatComment($comment)
    {
        return json_encode([
            'id' => (string)$comment->id,
            'userId' => (string)$comment->user_id,
            'userName' => $comment->user->name,
            'userAvatarUrl' => $comment->user->image_url,
            'text' => $comment->body,
            'timestamp' => $comment->created_at->toIso8601String(),
            'replies' => [], // Flat list for feed
            'isArchived' => false,
        ]);
    }

    /**
     * Google Polyline Algorithm Implementation
     */
    private function encodePolyline($points)
    {
        $res = '';
        $last_lat = 0;
        $last_lng = 0;

        foreach ($points as $point) {
            $lat = round($point['lat'] * 1e5);
            $lng = round($point['lng'] * 1e5);

            $d_lat = (int)$lat - (int)$last_lat;
            $d_lng = (int)$lng - (int)$last_lng;

            $res .= $this->encodePart($d_lat);
            $res .= $this->encodePart($d_lng);

            $last_lat = $lat;
            $last_lng = $lng;
        }

        return $res;
    }

    /**
     * Upload media files.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        $paths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('activities/' . $request->user()->id, 'public');
                $paths[] = asset('storage/' . $path);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $paths
        ]);
    }

    private function encodePart($v)
    {
        $v = $v < 0 ? ~($v << 1) : $v << 1;
        $res = '';
        while ($v >= 0x20) {
            $res .= chr((0x20 | ($v & 0x1f)) + 63);
            $v >>= 5;
        }
        $res .= chr($v + 63);
        return $res;
    }
}
