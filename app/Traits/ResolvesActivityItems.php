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
        // Se o ID tem prefixo, usamos o prefixo
        if (is_string($id)) {
            if (str_starts_with($id, 'post_') || str_starts_with($id, 'poll_')) {
                $realId = str_replace(['post_', 'poll_'], '', $id);
                return Post::findOrFail($realId);
            } elseif (str_starts_with($id, 'activity_')) {
                $realId = str_replace('activity_', '', $id);
                return Activity::findOrFail($realId);
            }
        }

        // Se for puramente numérico (comportamento do App), usamos o contexto da rota
        if (is_numeric($id) || (is_string($id) && ctype_digit($id))) {
            if (request()->is('api/posts/*') || request()->is('api/polls/*') || request()->is('api/post-comments/*')) {
                return Post::findOrFail($id);
            }
            
            if (request()->is('api/activities/*')) {
                return Activity::findOrFail($id);
            }
        }

        // Fallback para IDs legados (assume Activity se não souber o que é)
        return Activity::findOrFail($id);
    }
}
