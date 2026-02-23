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

        // Se for puramente numérico (comportamento do App), usamos o contexto da rota para decidir
        if (is_numeric($id) || (is_string($id) && ctype_digit($id))) {
            $path = request()->getPathInfo();

            if (str_contains($path, '/api/posts/') || str_contains($path, '/api/polls/')) {
                return Post::findOrFail($id);
            }

            if (str_contains($path, '/api/activities/')) {
                return Activity::findOrFail($id);
            }
        }

        // Fallback para IDs legados ou se não houver prefixo claro
        try {
            return Activity::findOrFail($id);
        } catch (\Exception $e) {
            return Post::findOrFail($id);
        }
    }
}
