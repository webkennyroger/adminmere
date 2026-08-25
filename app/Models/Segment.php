<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sport_type',
        'start_lat',
        'start_lng',
        'end_lat',
        'end_lng',
        'radius_m',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_lat' => 'float',
            'start_lng' => 'float',
            'end_lat' => 'float',
            'end_lng' => 'float',
            'radius_m' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function efforts(): HasMany
    {
        return $this->hasMany(SegmentEffort::class);
    }
}
