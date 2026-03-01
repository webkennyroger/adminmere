<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatPreference extends Model
{
    protected $fillable = [
        'user_id',
        'peer_id',
        'is_muted',
        'is_archived',
    ];

    protected $casts = [
        'is_muted' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peer()
    {
        return $this->belongsTo(User::class, 'peer_id');
    }
}
