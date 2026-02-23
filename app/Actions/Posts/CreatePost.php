<?php

namespace App\Actions\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class CreatePost
{
    /**
     * @param array{
     *   user_id: int,
     *   title?: string|null,
     *   content: string,
     *   media?: array,
     *   type?: string,
     *   feed_type?: string,
     *   location?: string|null,
     *   privacy?: string,
     *   poll_options?: array,
     *   poll_expires_at?: string|null,
     *   meta?: array|null
     * } $data
     */
    public function execute(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            $post = Post::create([
                'user_id' => $data['user_id'],
                'title' => $data['title'] ?? null,
                'content' => $data['content'],
                'media' => $data['media'] ?? [],
                'type' => $data['type'] ?? 'post',
                'feed_type' => $data['feed_type'] ?? 'personal',
                'location' => $data['location'] ?? null,
                'privacy' => $data['privacy'] ?? 'public',
                'poll_expires_at' => $data['poll_expires_at'] ?? null,
                'meta' => $data['meta'] ?? null,
            ]);

            if ($post->type === 'poll' && ! empty($data['poll_options'])) {
                foreach ($data['poll_options'] as $optionText) {
                    if (trim($optionText)) {
                        $post->pollOptions()->create([
                            'option_text' => trim($optionText)
                        ]);
                    }
                }
            }

            return $post;
        });
    }
}
