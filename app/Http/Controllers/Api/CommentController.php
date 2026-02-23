<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * List comments for an item (post, poll, activity).
     */
    public function index(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        $comments = $item->comments()
            ->with(['user', 'likes', 'replies.user', 'replies.likes'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $comments->map(fn ($c) => $this->formatComment($c, $user->id)),
        ]);
    }

    /**
     * Store comment on an item (post, poll, activity).
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $item = $this->resolveItem($id);
        $user = $request->user();

        $comment = $item->comments()->create([
            'user_id' => $user->id,
            'body' => $request->body,
            'parent_id' => ! empty($request->parent_id) ? $request->parent_id : null,
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->formatComment($comment->load('user'), $user->id),
        ]);
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
        ]);
    }

    protected function resolveItem($id)
    {
        if (str_starts_with($id, 'post_') || str_starts_with($id, 'poll_')) {
            $realId = str_replace(['post_', 'poll_'], '', $id);

            return Post::findOrFail($realId);
        }

        if (str_starts_with($id, 'activity_')) {
            $realId = str_replace('activity_', '', $id);

            return Activity::findOrFail($realId);
        }

        // Fallback for numeric IDs based on route
        if (request()->is('api/posts/*') || request()->is('api/polls/*')) {
            return Post::findOrFail($id);
        }

        return Activity::findOrFail($id);
    }

    protected function formatComment($comment, $userId)
    {
        if (! $comment->relationLoaded('likes') || ! $comment->relationLoaded('user') || ! $comment->relationLoaded('replies')) {
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
            'isLiked' => $comment->likes->where('user_id', $userId)->isNotEmpty(),
        ];
    }
}
