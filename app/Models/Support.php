<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'subject',
        'message',
        'status',
        'priority',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ticket_id = strtoupper(uniqid('TICKET-'));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(SupportReply::class);
    }
}
