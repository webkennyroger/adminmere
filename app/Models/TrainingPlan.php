<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'sport_type',
        'weeks',
        'level',
    ];

    protected function casts(): array
    {
        return [
            'weeks' => 'integer',
        ];
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(TrainingPlanWorkout::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('started_at', 'current_week', 'current_day', 'status')
            ->withTimestamps();
    }
}
