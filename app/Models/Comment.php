<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'body', 'media_path', 'commentable_id', 'commentable_type', 'parent_id'];
    protected $appends = ['media_url'];

    public function getMediaUrlAttribute()
    {
        return $this->media_path ? url('storage/' . $this->media_path) : null;
    }

    protected static function booted()
    {
        static::deleting(function ($comment) {
            // Delete likes associated with this comment
            $comment->likes()->delete();
            // Delete replies (recursive)
            $comment->replies()->get()->each->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
