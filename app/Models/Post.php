<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type', // 'post' or 'poll'
        'poll_expires_at',
        'media',
        'feed_type',
        'location',
        'is_mandatory',
        'privacy',
    ];

    protected $casts = [
        'media' => 'array',
        'poll_expires_at' => 'datetime',
    ];

    protected $with = ['pollOptions']; // Eager load poll options usually

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->latest();
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // --- Poll Relations ---

    public function pollOptions(): HasMany
    {
        return $this->hasMany(PollOption::class);
    }

    public function pollVotes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    // --- Helpers ---

    public function getIsPollAttribute(): bool
    {
        return $this->type === 'poll';
    }

    public function hasVoted(User $user): bool
    {
        return $this->pollVotes()->where('user_id', $user->id)->exists();
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->pollVotes()->count();
    }
}
