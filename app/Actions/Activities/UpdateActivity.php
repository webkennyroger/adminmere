<?php

namespace App\Actions\Activities;

use App\Models\Activity;

class UpdateActivity
{
    /**
     * @param Activity $activity
     * @param array{
     *   title?: string,
     *   description?: string|null,
     *   privacy?: string
     * } $data
     */
    public function execute(Activity $activity, array $data): Activity
    {
        $activity->update([
            'title' => $data['title'] ?? $activity->title,
            'description' => $data['description'] ?? $activity->description,
            'privacy' => $data['privacy'] ?? $activity->privacy,
        ]);

        return $activity->refresh();
    }
}
