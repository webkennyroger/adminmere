<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'description',
        'start_date',
        'end_date',
        'goal_km',
        'category_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'goal_km' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}