<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string',
            'mediaPaths' => 'nullable|array',
            'privacy' => 'nullable|in:public,friends,private',
            'feedType' => 'nullable|string',
        ]);

        if ($validator->fails()) {
             return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => '',
            'content' => $request->content ?? '',
            'type' => 'post', // Explicitly set type to post
            'media' => $request->mediaPaths ?? [],
            'privacy' => $request->privacy ?? 'public',
            'feed_type' => $request->feedType ?? 'personal',
        ]);

        $post->load(['user', 'likes']);

        return response()->json([
            'success' => true,
            'message' => 'Post criado com sucesso',
            'data' => $this->formatPost($post, $user),
        ], 201);
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Request $request, $id)
    {
        $cleanId = str_replace(['post_', 'poll_'], '', $id);
        
        $post = Post::where('id', $cleanId)->where('type', 'post')->firstOrFail();

        if ($post->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post removido com sucesso',
        ]);
    }

    /**
     * Toggle like on post.
     */
    public function toggleLike(Request $request, $id)
    {
        $cleanId = str_replace(['post_', 'poll_'], '', $id);
        $post = Post::findOrFail($cleanId);
        $user = $request->user();

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $isLiked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $post->likes()->count(),
        ]);
    }

    private function formatPost($post, $user)
    {
        return [
            'id' => 'post_'.$post->id,
            'type' => 'post',
            'title' => $post->title,
            'user_id' => (string)$post->user_id,
            'userName' => $post->user->name,
            'userAvatarUrl' => $post->user->image_url,
            'createdAt' => $post->created_at->toIso8601String(),
            'description' => $post->content,
            'mediaPaths' => $post->media ?? [],
            'likes' => $post->likes->count(),
            'isLiked' => $post->likes->contains('user_id', $user->id),
            'commentsList' => [],
            'shares' => 0,
            'privacy' => $post->privacy,
        ];
    }
}
