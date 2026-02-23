<?php

namespace App\Actions\Posts;

use App\Models\Post;

class DeletePost
{
    public function execute(Post $post): bool
    {
        // Deletion logic is handled by model booted events (booted method in Post model)
        // so we just call delete() here.
        return $post->delete();
    }
}
