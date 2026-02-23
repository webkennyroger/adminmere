<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait FormatsApiData
{
    /**
     * Format activity for API response.
     */
    protected function formatActivity($activity, $user)
    {
        $routePoints = $activity->polylines;

        if (is_array($routePoints) && isset($routePoints['points'])) {
            $routePoints = $routePoints['points'];
        }

        if (! is_array($routePoints)) {
            $routePoints = [];
        }

        return [
            'id' => 'activity_' . $activity->id,
            'app_id' => $activity->app_id,
            'user_id' => (string) $activity->user_id,
            'userId' => (string) $activity->user_id,
            'userName' => $activity->user->name,
            'userAvatarUrl' => $activity->user->image_url,
            'title' => $activity->title,
            'description' => $activity->description,
            'type' => 'activity',
            'activityTitle' => $activity->title,
            'sport' => $activity->sport_type,
            'createdAt' => ($activity->start_time ?? $activity->created_at ?? now())->toIso8601String(),
            'location' => ($activity->location && $activity->location !== 'Sua Cidade') ? $activity->location : null,
            'feedType' => $activity->feed_type,
            'distanceInMeters' => (float) $activity->distance,
            'durationInSeconds' => (int) $activity->duration,
            'routePoints' => $routePoints,
            'calories' => (float) $activity->calories,
            'likes' => $activity->likes->count(),
            'isLiked' => $user ? $activity->likes->where('user_id', $user->id)->isNotEmpty() : false,
            'isSaved' => $user ? $activity->savedItems->where('user_id', $user->id)->isNotEmpty() : false,
            'commentsList' => $activity->comments->map(function ($comment) use ($user) {
                return $this->formatComment($comment, $user?->id);
            })->toArray(),
            'shares' => 0,
            'likers' => $activity->likes->take(3)->map(function ($like) {
                return $like->user?->image_url;
            })->filter()->toArray(),
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
    protected function formatPost($post, $user)
    {
        $pollData = null;
        if ($post->type === 'poll') {
            $hasVoted = $user ? $post->pollVotes->where('user_id', $user->id)->isNotEmpty() : false;
            $totalVotes = $post->pollVotes->count();
            $meta = is_array($post->meta) ? $post->meta : [];

            $pollData = [
                'expiresAt' => $post->poll_expires_at ? $post->poll_expires_at->toIso8601String() : null,
                'isMandatory' => (bool)$post->is_mandatory,
                'isMultiple' => (bool)($meta['isMultiple'] ?? false),
                'isExpired' => $post->poll_expires_at && $post->poll_expires_at->isPast(),
                'hasVoted' => $hasVoted,
                'totalVotes' => $totalVotes,
                'options' => $post->pollOptions->map(function ($opt) use ($user, $post, $totalVotes) {
                    $isUserVote = $user ? $post->pollVotes->where('user_id', $user->id)->where('poll_option_id', $opt->id)->isNotEmpty() : false;

                    $voterAvatars = $post->pollVotes->where('poll_option_id', $opt->id)
                        ->take(3)
                        ->map(function ($vote) {
                            return $vote->user?->image_url;
                        })->filter()->values()->toArray();

                    return [
                        'id' => (int) $opt->id,
                        'text' => $opt->option_text,
                        'votes' => (int) $opt->votes_count,
                        'percentage' => $totalVotes > 0 ? round(($opt->votes_count / $totalVotes) * 100) : 0,
                        'isUserVote' => $isUserVote,
                        'voterAvatars' => $voterAvatars
                    ];
                })->values()
            ];
        }

        return [
            'id' => ($post->type === 'poll' ? 'poll_' : 'post_') . $post->id,
            'app_id' => null,
            'user_id' => (string) $post->user_id,
            'userId' => (string) $post->user_id,
            'userName' => $post->user->name,
            'userAvatarUrl' => $post->user->image_url,
            'activityTitle' => $post->title ?? ($post->type === 'poll' ? 'Enquete' : 'Publicação'),
            'sport' => $post->type === 'poll' ? 'Poll' : 'Post',
            'type' => $post->type,
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
            'isLiked' => $user ? $post->likes->where('user_id', $user->id)->isNotEmpty() : false,
            'isSaved' => $user ? $post->savedItems->where('user_id', $user->id)->isNotEmpty() : false,
            'commentsList' => $post->comments->map(function ($comment) use ($user) {
                return $this->formatComment($comment, $user?->id);
            })->toArray(),
            'shares' => 0,
            'likers' => $post->likes->take(3)->map(function ($like) {
                return $like->user?->image_url;
            })->filter()->toArray(),
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
     * Format comment for JSON string
     */
    protected function formatComment($comment, $userId)
    {
        if (!$comment->relationLoaded('likes') || !$comment->relationLoaded('user') || !$comment->relationLoaded('replies')) {
            $comment->load(['user', 'likes', 'replies.user', 'replies.likes']);
        }

        return [
            'id' => (string) $comment->id,
            'userId' => (string) $comment->user_id,
            'userName' => $comment->user->name,
            'userAvatarUrl' => $comment->user->image_url,
            'text' => $comment->body,
            'timestamp' => $comment->created_at->toIso8601String(),
            'parent_id' => (string) $comment->parent_id,
            'replies' => $comment->replies->map(function ($reply) use ($userId) {
                return $this->formatComment($reply, $userId);
            })->toArray(),
            'isArchived' => false,
            'likes' => $comment->likes->count(),
            'isLiked' => $userId ? $comment->likes->where('user_id', $userId)->isNotEmpty() : false,
        ];
    }
}
