<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResolvesActivityItems;

class ActivityController extends Controller
{
    use ResolvesActivityItems;
    /**
     * Get list of user activities and posts with feed filtering.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $feed = $request->query('feed', 'personal');
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 20);

        // Fetch Activities
        $activitiesQuery = Activity::with([
            'user',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->latest();
            },
            'comments.user',
            'comments.likes',
            'likes',
        ]);

        // Fetch Posts
        $postsQuery = \App\Models\Post::with([
            'user',
            'comments' => function ($q) {
                $q->whereNull('parent_id')->latest();
            },
            'comments.user',
            'comments.likes',
            'likes',
            'pollOptions',
            'pollVotes.user'
        ]);

        if ($feed === 'personal') {
            $activitiesQuery->where('user_id', $user->id);
            $postsQuery->where('user_id', $user->id);
        } elseif ($feed === 'timeline' || $feed === 'network') {
            $followingIds = $user->following()->pluck('users.id')->toArray();
            $followingIds[] = $user->id;
            $activitiesQuery->whereIn('user_id', $followingIds);
            $postsQuery->whereIn('user_id', $followingIds);
        }

        $activities = $activitiesQuery->latest('start_time')->get();
        $posts = $postsQuery->latest('created_at')->get();

        // Merge and sort
        $items = collect([])
            ->merge($activities->map(fn($item) => ['type' => 'activity', 'data' => $item, 'date' => $item->start_time]))
            ->merge($posts->map(fn($item) => ['type' => $item->type, 'data' => $item, 'date' => $item->created_at]))
            ->sortByDesc('date');

        // Manual pagination
        $total = $items->count();
        $paginatedItems = $items->forPage($page, $perPage);

        return response()->json([
            'success' => true,
            'data' => $paginatedItems->map(function ($item) use ($user) {
                if ($item['type'] === 'activity') {
                    return $this->formatActivity($item['data'], $user);
                } else {
                    return $this->formatPost($item['data'], $user);
                }
            })->values(),
            'pagination' => [
                'current_page' => $page,
                'last_page' => (int) ceil($total / $perPage),
                'per_page' => $perPage,
                'total' => $total,
            ],
        ]);
    }

    /**
     * Get user's activity history for challenges.
     * Filters only sport activities (no posts).
     */
    public function history(Request $request)
    {
        $user = $request->user();
        $perPage = (int) $request->get('per_page', 20);

        $activities = Activity::where('user_id', $user->id)
            ->whereNotNull('sport_type') // Ensure it's a sport activity
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
            'location' => 'nullable|string',
            'feedType' => 'nullable|string',
        ]);

        $user = $request->user();


        // Proceed to create Activity (Sport/Exercise)

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

        // Process polylines/route points
        $polylines = $request->routePoints ?? [];
        if (is_array($polylines) && ! empty($polylines)) {
            // Check if already encoded with summary
            if (! isset($polylines['summary_polyline'])) {
                // Store both raw points and encoded summary
                $summary = $this->encodePolyline($polylines);
                $polylines = [
                    'points' => $polylines,
                    'summary_polyline' => $summary,
                ];
            }
        } elseif (empty($polylines)) {
            // Ensure polylines is null if empty, not an empty array
            $polylines = null;
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
                'feed_type' => $request->feedType ?? 'personal', // Capture feed type from app
                'location' => $request->location, // Capture location from app
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
            'data' => $this->formatActivity($activity, $user),
        ], 201);
    }

    /**
     * Display the specified activity.
     */
    public function show(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        if ($item instanceof \App\Models\Activity) {
            return response()->json([
                'success' => true,
                'data' => $this->formatActivity($item->load(['user', 'likes', 'comments.user']), $user),
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $this->formatPost($item->load(['user', 'likes', 'comments.user']), $user),
            ]);
        }
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, $id)
    {
        $item = $this->resolveItem($id);

        // Check if user owns this item
        if ($item->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
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
            'location' => 'nullable|string',
            'feedType' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($item instanceof \App\Models\Activity) {
            $updateData = [];
            if ($request->has('activityTitle')) {
                $updateData['title'] = $request->activityTitle;
            }
            if ($request->has('sport')) {
                $updateData['sport_type'] = $request->sport;
            }
            if ($request->has('distanceInMeters')) {
                $updateData['distance'] = $request->distanceInMeters;
            }
            if ($request->has('durationInSeconds')) {
                $updateData['duration'] = $request->durationInSeconds;
            }
            if ($request->has('calories')) {
                $updateData['calories'] = $request->calories;
            }
            if ($request->has('privacy')) {
                $updateData['privacy'] = $request->privacy;
            }
            if ($request->has('notes')) {
                $updateData['description'] = $request->notes;
            }
            if ($request->has('mood')) {
                $updateData['mood'] = $request->mood;
            }
            if ($request->has('mediaPaths')) {
                $updateData['media'] = $request->mediaPaths;
            }
            if ($request->has('location')) {
                $updateData['location'] = $request->location;
            }
            if ($request->has('feedType')) {
                $updateData['feed_type'] = $request->feedType;
            }

            $item->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Activity updated successfully',
                'data' => $this->formatActivity($item, $request->user()),
            ]);
        } else {
            $updateData = [];
            if ($request->has('activityTitle')) {
                $updateData['title'] = $request->activityTitle;
            }
            if ($request->has('notes')) {
                $updateData['content'] = $request->notes;
            }
            if ($request->has('mediaPaths')) {
                $updateData['media'] = $request->mediaPaths;
            }
            if ($request->has('privacy')) {
                $updateData['privacy'] = $request->privacy;
            }
            if ($request->has('feedType')) {
                $updateData['feed_type'] = $request->feedType;
            }

            $item->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $this->formatPost($item, $request->user()),
            ]);
        }
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->resolveItem($id);

        // Check if user owns this item
        if ($item->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => ($item instanceof \App\Models\Activity ? 'Activity' : 'Post') . ' deleted successfully',
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $synced = [];
        $errors = [];

        foreach ($request->activities as $activityData) {
            try {
                if ($activityData['sport'] === 'Social' || $activityData['sport'] === 'Post') {
                    $item = \App\Models\Post::updateOrCreate(
                        [
                            'id' => str_replace('post_', '', $activityData['id']),
                            'user_id' => $request->user()->id,
                        ],
                        [
                            'title' => $activityData['activityTitle'],
                            'content' => $activityData['notes'] ?? '',
                            'media' => $activityData['mediaPaths'] ?? [],
                            'privacy' => $activityData['privacy'] ?? 'public',
                            'created_at' => Carbon::parse($activityData['createdAt']),
                        ]
                    );
                    $synced[] = 'post_' . $item->id;

                    continue;
                }

                $polylines = $activityData['routePoints'] ?? [];
                if (is_array($polylines) && ! empty($polylines) && ! isset($polylines['summary_polyline'])) {
                    $summary = $this->encodePolyline($polylines);
                    $polylines = [
                        'points' => $polylines,
                        'summary_polyline' => $summary,
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

                $synced[] = 'activity_' . $activity->id;
            } catch (\Exception $e) {
                $errors[] = [
                    'app_id' => $activityData['id'] ?? 'unknown',
                    'error' => $e->getMessage(),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'synced_count' => count($synced),
            'synced_ids' => $synced,
            'errors' => $errors,
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

        // Ensure routePoints is always an array, never null
        if (! is_array($routePoints)) {
            $routePoints = [];
        }

        return [
            'id' => 'activity_' . $activity->id,
            'app_id' => $activity->app_id,
            'user_id' => (string) $activity->user_id,
            'userName' => $activity->user->name,
            'userAvatarUrl' => $activity->user->image_url,
            'title' => $activity->title,
            'description' => $activity->description,
            'type' => 'activity',
            'activityTitle' => $activity->title,
            'sport' => $activity->sport_type,
            'createdAt' => $activity->start_time->toIso8601String(),
            'location' => ($activity->location && $activity->location !== 'Sua Cidade') ? $activity->location : null,
            'feedType' => $activity->feed_type,
            'distanceInMeters' => (float) $activity->distance,
            'durationInSeconds' => (int) $activity->duration,
            'routePoints' => $routePoints,
            'calories' => (float) $activity->calories,
            'likes' => $activity->likes->count(),
            'isLiked' => $activity->likes->contains('user_id', $user->id),
            'commentsList' => $activity->comments->map(function ($comment) use ($user) {
                return $this->formatComment($comment, $user->id);
            })->toArray(),
            'shares' => 0,
            'likers' => $activity->likes->take(3)->map(function ($like) {
                return $like->user->image_url;
            })->toArray(),
            'privacy' => $activity->privacy,
            'notes' => $activity->description,
            'taggedPartnerIds' => collect($activity->tagged_users ?? [])->pluck('id')->map(fn($id) => (string) $id)->toArray(),
            'mood' => $activity->mood,
            'mediaPaths' => $activity->media ?? [],
            'mapType' => 'normal',
            'points' => (int) ($activity->distance / 100),
        ];
    }

    /**
     * Format post for API response.
     */
    public function formatPost($post, $user)
    {
        $pollData = null;
        if ($post->type === 'poll') {
            $hasVoted = $post->pollVotes->where('user_id', $user->id)->isNotEmpty();
            $totalVotes = $post->total_votes;
            $meta = is_array($post->meta) ? $post->meta : [];

            $pollData = [
                'expiresAt' => $post->poll_expires_at ? $post->poll_expires_at->toIso8601String() : null,
                'isMandatory' => (bool)$post->is_mandatory,
                'isMultiple' => (bool)($meta['isMultiple'] ?? false),
                'isExpired' => $post->poll_expires_at && $post->poll_expires_at->isPast(),
                'hasVoted' => $hasVoted,
                'totalVotes' => $totalVotes,
                'options' => $post->pollOptions->map(function ($opt) use ($user, $post, $totalVotes) {
                    $isUserVote = $post->pollVotes->where('user_id', $user->id)->where('poll_option_id', $opt->id)->isNotEmpty();

                    // Get voter avatars (limit 3)
                    $voterAvatars = $post->pollVotes->where('poll_option_id', $opt->id)
                        ->take(3)
                        ->map(function ($vote) {
                            return $vote->user->image_url;
                        })->values()->toArray();

                    return [
                        'id' => $opt->id,
                        'text' => $opt->option_text,
                        'votes' => $opt->votes_count,
                        'percentage' => $totalVotes > 0 ? round(($opt->votes_count / $totalVotes) * 100) : 0,
                        'isUserVote' => $isUserVote,
                        'voterAvatars' => $voterAvatars
                    ];
                })->values()
            ];
        }

        return [
            'id' => 'post_' . $post->id,
            'app_id' => null,
            'user_id' => (string) $post->user_id,
            'userName' => $post->user->name,
            'userAvatarUrl' => $post->user->image_url,
            'activityTitle' => $post->title ?? 'Publicação',
            'sport' => 'Post',
            'type' => $post->type, // 'post' or 'poll'
            'pollData' => $pollData,
            'title' => $post->title,
            'description' => $post->content,
            'createdAt' => $post->created_at->toIso8601String(),
            'location' => ($post->type === 'poll') ? null : (($post->location && $post->location !== 'Sua Cidade') ? $post->location : null),
            'feedType' => $post->feed_type,
            'distanceInMeters' => 0.0,
            'durationInSeconds' => 0,
            'routePoints' => [],
            'calories' => 0.0,
            'likes' => $post->likes->count(),
            'isLiked' => $post->likes->contains('user_id', $user->id),
            'commentsList' => $post->comments->map(function ($comment) use ($user) {
                return $this->formatComment($comment, $user->id);
            })->toArray(),
            'shares' => 0,
            'likers' => $post->likes->take(3)->map(function ($like) {
                return $like->user->image_url;
            })->toArray(),
            'privacy' => $post->privacy,
            'notes' => $post->content,
            'taggedPartnerIds' => [],
            'mood' => null,
            'mediaPaths' => $post->media ?? [],
            'mapType' => 'none',
            'points' => 0,
        ];
    }



    /**
     * Format comment for JSON string (app requirement)
     */
    private function formatComment($comment, $userId)
    {
        // Ensure relations are loaded
        if (!$comment->relationLoaded('likes') || !$comment->relationLoaded('user')) {
            $comment->load(['user', 'likes']);
        }

        return [
            'id' => (string) $comment->id,
            'userId' => (string) $comment->user_id,
            'userName' => $comment->user->name,
            'userAvatarUrl' => $comment->user->image_url,
            'text' => $comment->body,
            'timestamp' => $comment->created_at->toIso8601String(),
            'replies' => [],
            'isArchived' => false,
            'likes' => $comment->likes->count(),
            'isLiked' => $comment->likes->contains('user_id', $userId),
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

            $d_lat = (int) $lat - (int) $last_lat;
            $d_lng = (int) $lng - (int) $last_lng;

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
            'data' => $paths,
        ]);
    }

    private function encodePart($v)
    {
        $v = $v < 0 ? ~($v << 1) : $v << 1;
        $res = '';
        while ($v >= 0x20) {
            $res .= chr((0x20 | ($v & 0x1F)) + 63);
            $v >>= 5;
        }
        $res .= chr($v + 63);

        return $res;
    }
}
