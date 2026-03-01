<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'stripe_payment_id',
        'amount',
        'currency',
        'status',
        'invoice_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isSuccessful()
    {
        return $this->status === 'succeeded';
    }

    public function getFormattedAmountAttribute()
    {
        return 'R$ '.number_format($this->amount / 100, 2, ',', '.');
    }
}
