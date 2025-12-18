<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'stripe_plan_id',
        'price',
        'currency',
        'billing_period',
        'features',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Get price formatted
     */
    public function getFormattedPriceAttribute()
    {
        return 'R$ ' . number_format($this->price / 100, 2, ',', '.');
    }
}
