<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ChatGroup;
use App\Models\User;

class GroupMessage extends Model
{
    protected $fillable = ['chat_group_id', 'user_id', 'content', 'attachments'];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function group()
    {
        return $this->belongsTo(ChatGroup::class, 'chat_group_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
