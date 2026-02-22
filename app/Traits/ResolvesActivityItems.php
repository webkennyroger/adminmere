<?php

namespace App\Traits;

use App\Models\Activity;
use App\Models\Post;

trait ResolvesActivityItems
{
    /**
     * Resolve item by prefixed ID.
     */
    protected function resolveItem($id)
    {
        if (is_string($id) && (str_starts_with($id, 'post_') || str_starts_with($id, 'poll_'))) {
            $realId = str_replace(['post_', 'poll_'], '', $id);
            return Post::findOrFail($realId);
        } elseif (is_string($id) && str_starts_with($id, 'activity_')) {
            $realId = str_replace('activity_', '', $id);
            return Activity::findOrFail($realId);
        }

        // Fallback for legacy numeric IDs (assume Activity)
        return Activity::findOrFail($id);
    }
}
