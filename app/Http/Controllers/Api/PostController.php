<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use \App\Traits\ResolvesActivityItems;

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string',
            'title' => 'nullable|string',
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
            'title' => $request->title ?? '',
            'content' => $request->input('content') ?? '',
            'type' => 'post',
            'media' => $request->mediaPaths ?? [],
            'privacy' => $request->privacy ?? 'public',
            'feed_type' => $request->feedType ?? 'personal',
        ]);

        $post->load(['user', 'likes', 'comments.user']);

        return response()->json([
            'success' => true,
            'message' => 'Post criado com sucesso',
            'data' => $this->formatPost($post, $user),
        ], 201);
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        if ($item->user_id != $user->id && ! $user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string',
            'title' => 'nullable|string',
            'privacy' => 'nullable|in:public,friends,private',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $item->update([
            'title' => $request->title ?? $item->title,
            'content' => $request->input('content') ?? $item->content,
            'privacy' => $request->privacy ?? $item->privacy,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post atualizado com sucesso',
            'data' => $this->formatPost($item->refresh(), $user),
        ]);
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        if ($item->user_id != $user->id && ! $user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post removido com sucesso',
        ]);
    }

    private function formatPost($post, $user)
    {
        return [
            'id' => 'post_'.$post->id,
            'type' => 'post',
            'title' => $post->title,
            'user_id' => (string) $post->user_id,
            'userName' => $post->user->name,
            'userAvatarUrl' => $post->user->image_url,
            'createdAt' => $post->created_at->toIso8601String(),
            'description' => $post->content,
            'mediaPaths' => $post->media ?? [],
            'likes' => $post->likes->count(),
            'isLiked' => $post->likes->where('user_id', $user->id)->isNotEmpty(),
            'commentsList' => [], // Separate comments for performance
            'shares' => 0,
            'privacy' => $post->privacy,
        ];
    }
}
