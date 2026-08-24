<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingPlanWorkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_plan_id',
        'week_number',
        'day_number',
        'title',
        'steps',
    ];

    protected function casts(): array
    {
        return [
            'week_number' => 'integer',
            'day_number' => 'integer',
            'steps' => 'array',
        ];
    }

    public function trainingPlan(): BelongsTo
    {
        return $this->belongsTo(TrainingPlan::class);
    }
}
