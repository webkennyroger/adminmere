<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'app_id',
        'title',
        'sport_type',
        'start_time',
        'distance',
        'duration',
        'calories',
        'polylines',
        'privacy',
        'description',
        'mood',
        'media',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'polylines' => 'array',
        'media' => 'array',
        'tagged_users' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
