<?php

namespace App\Actions\Posts;

use App\Models\Post;

class UpdatePost
{
    /**
     * @param array{
     *   title?: string|null,
     *   content?: string,
     *   privacy?: string,
     *   poll_expires_at?: string|null
     * } $data
     */
    public function execute(Post $post, array $data): Post
    {
        $post->update([
            'title' => $data['title'] ?? $post->title,
            'content' => $data['content'] ?? $post->content,
            'privacy' => $data['privacy'] ?? $post->privacy,
            'poll_expires_at' => $data['poll_expires_at'] ?? $post->poll_expires_at,
            'media' => $data['media'] ?? $post->media,
        ]);

        return $post->refresh();
    }
}
