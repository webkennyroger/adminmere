<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;

class ActivityController extends Controller
{
    use \App\Traits\ResolvesActivityItems;

    public function index(Request $request)
    {
        $user = $request->user();
        $feed = $request->query('feed', 'personal');

        // Activities Query
        $activitiesQuery = Activity::with(['user.profile', 'likes', 'savedItems', 'comments' => function ($q) {
            $q->whereNull('parent_id')->latest();
        }]);

        // Posts Query (Simple posts and polls)
        $postsQuery = Post::with(['user.profile', 'likes', 'savedItems', 'pollOptions', 'pollVotes.user', 'comments' => function ($q) {
            $q->whereNull('parent_id')->latest();
        }]);

        if ($feed === 'timeline' || $feed === 'network' || $feed === 'community') {
            $activitiesQuery->where('privacy', 'public');
            if ($feed === 'community') {
                $postsQuery->where(fn($q) => $q->where('feed_type', 'community')->orWhere('privacy', 'public'));
            } else {
                $postsQuery->where('privacy', 'public');
            }
        } elseif ($feed === 'personal') {
            $activitiesQuery->where('user_id', $user->id);
            $postsQuery->where('user_id', $user->id);
        }

        $activities = $activitiesQuery->latest('start_time')->limit(50)->get();
        $posts = $postsQuery->latest()->limit(50)->get();

        // Merge and sort
        $merged = collect([])
            ->merge($activities->map(fn($a) => [
                'type' => 'activity',
                'item' => $a,
                'date' => $a->start_time ?? $a->created_at,
            ]))
            ->merge($posts->map(fn($p) => [
                'type' => 'post',
                'item' => $p,
                'date' => $p->created_at,
            ]))
            ->sortByDesc('date')
            ->values();

        $formatted = $merged->map(function ($entry) use ($user) {
            if ($entry['type'] === 'activity') {
                return $this->formatActivity($entry['item'], $user);
            } else {
                $post = $entry['item'];
                if ($post->type === 'poll') {
                    return $this->formatPoll($post, $user);
                } else {
                    return $this->formatPost($post, $user);
                }
            }
        });

        return response()->json([
            'success' => true,
            'data' => $formatted,
        ]);
    }

    public function formatPost($post, $user)
    {
        return [
            'id' => 'post_' . $post->id,
            'type' => 'post',
            'title' => $post->title,
            'user_id' => (string) $post->user_id,
            'userName' => $post->user->name,
            'userAvatarUrl' => $post->user->image_url,
            'createdAt' => $post->created_at->toIso8601String(),
            'description' => $post->content,
            'mediaPaths' => $post->media ?? [],
            'likes' => $post->likes->count(),
            'isLiked' => $user ? $post->likes->where('user_id', $user->id)->isNotEmpty() : false,
            'isSaved' => $user ? $post->savedItems->where('user_id', $user->id)->isNotEmpty() : false,
            'isArchived' => (bool) ($post->is_archived ?? false),
            'commentsList' => $post->comments ? array_fill(0, $post->comments->count(), []) : [],
            'shares' => 0,
            'privacy' => $post->privacy,
        ];
    }

    public function formatPoll($post, $user)
    {
        $hasVoted = $user ? $post->pollVotes->where('user_id', $user->id)->isNotEmpty() : false;
        $totalVotes = $post->pollVotes->count();

        $meta = is_array($post->meta) ? $post->meta : [];
        $pollData = [
            'expiresAt' => $post->poll_expires_at ? $post->poll_expires_at->toIso8601String() : null,
            'isMandatory' => (bool) $post->is_mandatory,
            'isMultiple' => (bool) ($meta['isMultiple'] ?? false),
            'isExpired' => $post->poll_expires_at && $post->poll_expires_at->isPast(),
            'hasVoted' => $hasVoted,
            'totalVotes' => $totalVotes,
            'options' => $post->pollOptions->map(function ($opt) use ($user, $post, $totalVotes) {
                return [
                    'id' => (int) $opt->id,
                    'text' => $opt->option_text,
                    'votes' => (int) $opt->votes_count,
                    'percentage' => $totalVotes > 0 ? round(($opt->votes_count / $totalVotes) * 100) : 0,
                    'isUserVote' => $user ? $post->pollVotes->where('user_id', $user->id)->where('poll_option_id', $opt->id)->isNotEmpty() : false,
                ];
            })->values(),
        ];

        return [
            'id' => 'poll_' . $post->id,
            'type' => 'poll',
            'title' => $post->title,
            'description' => $post->content,
            'user_id' => (string) $post->user_id,
            'userName' => $post->user->name,
            'userAvatarUrl' => $post->user->image_url,
            'createdAt' => $post->created_at->toIso8601String(),
            'pollData' => $pollData,
            'likes' => $post->likes->count(),
            'isLiked' => $user ? $post->likes->where('user_id', $user->id)->isNotEmpty() : false,
            'isSaved' => $user ? $post->savedItems->where('user_id', $user->id)->isNotEmpty() : false,
            'isArchived' => (bool) ($post->is_archived ?? false),
            'commentsList' => $post->comments ? array_fill(0, $post->comments->count(), []) : [],
        ];
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

        if ($item instanceof \App\Models\Activity) {
            $action = new \App\Actions\Activities\UpdateActivity();
            $item = $action->execute($item, [
                'title' => $request->activityTitle ?? $request->title,
                'description' => $request->description ?? $request->content,
                'privacy' => $request->privacy,
            ]);
            $formatted = $this->formatActivity($item, $user);
        } else {
            $action = new \App\Actions\Posts\UpdatePost();
            $item = $action->execute($item, [
                'title' => $request->title ?? $request->activityTitle,
                'content' => $request->content ?? $request->description,
                'privacy' => $request->privacy,
            ]);
            $formatted = $this->formatPost($item, $user);
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

        if ($item instanceof \App\Models\Activity) {
            (new \App\Actions\Activities\DeleteActivity())->execute($item);
        } else {
            (new \App\Actions\Posts\DeletePost())->execute($item);
        }

        return response()->json(['success' => true]);
    }

    public function formatActivity($activity, $user)
    {
        $routePoints = $activity->polylines;
        if (is_array($routePoints) && isset($routePoints['points'])) {
            $routePoints = $routePoints['points'];
        }

        return [
            'id' => 'activity_' . $activity->id,
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
            'commentsList' => $activity->comments ? array_fill(0, $activity->comments->count(), []) : [],
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
            $res .= $this->encodeSignedNumber($d_lat) . $this->encodeSignedNumber($d_lng);
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
