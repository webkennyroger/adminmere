<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Traits\ResolvesActivityItems;

class CommentController extends Controller
{
    use ResolvesActivityItems;

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
            'parent_id' => $request->parent_id,
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
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }

    /**
     * Format comment for JSON string (app requirement)
     */
    protected function formatComment($comment, $userId)
    {
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
            'replies' => [], // In a full implementation, you could load replies here.
            'isArchived' => false,
            'likes' => $comment->likes->count(),
            'isLiked' => $comment->likes->contains('user_id', $userId),
        ];
    }
}
