<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PollOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    // Helper to calculate percentage
    public function getPercentageAttribute()
    {
        $totalVotes = $this->post->poll_votes_count ?? $this->post->total_votes;
        if ($totalVotes == 0) {
            return 0;
        }

        return round(($this->votes_count / $totalVotes) * 100);
    }
}
