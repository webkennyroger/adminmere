<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SegmentEffort extends Model
{
    use HasFactory;

    protected $fillable = [
        'segment_id',
        'activity_id',
        'user_id',
        'duration_seconds',
        'achieved_at',
    ];

    protected function casts(): array
    {
        return [
            'duration_seconds' => 'integer',
            'achieved_at' => 'datetime',
        ];
    }

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
