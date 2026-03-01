<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SavedItem extends Model
{
    protected $fillable = [
        'user_id',
        'saved_item_id',
        'saved_item_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saved_item(): MorphTo
    {
        return $this->morphTo();
    }
}
