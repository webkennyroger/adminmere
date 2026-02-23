<?php

namespace App\Actions\Activities;

use App\Models\Activity;

class DeleteActivity
{
    public function execute(Activity $activity): bool
    {
        return $activity->delete();
    }
}
