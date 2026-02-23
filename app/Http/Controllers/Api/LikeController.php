<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
class LikeController extends Controller
{
    protected function resolveItem($id)
    {
        if (str_starts_with($id, 'post_') || str_starts_with($id, 'poll_')) {
            $realId = str_replace(['post_', 'poll_'], '', $id);
            return \App\Models\Post::findOrFail($realId);
        }

        if (str_starts_with($id, 'activity_')) {
            $realId = str_replace('activity_', '', $id);
            return \App\Models\Activity::findOrFail($realId);
        }

        // Fallback
        return \App\Models\Post::find($id) ?? \App\Models\Activity::findOrFail($id);
    }

    /**
     * Toggle like on an item (post, poll, activity).
     */
    public function toggleItemLike(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        $existingLike = $item->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $isLiked = false;
        } else {
            $item->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $item->likes()->count(),
        ]);
    }

    /**
     * Toggle like on a comment.
     */
    public function toggleCommentLike(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $user = $request->user();

        $existingLike = $comment->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $isLiked = false;
        } else {
            $comment->likes()->create([
                'user_id' => $user->id,
            ]);
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $comment->likes()->count(),
        ]);
    }
}
