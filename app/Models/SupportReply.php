<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportReply extends Model
{
    protected $fillable = [
        'support_id',
        'user_id',
        'message',
        'attachment',
    ];

    public function support()
    {
        return $this->belongsTo(Support::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
