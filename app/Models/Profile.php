<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'plan',
        'status',
        'phone',
        'last_name',
        'nickname',
        'city',
        'state',
        'address',
        'zip_code',
        'image',
        'cover_image',
        'bio',
        'gender',
        'birth_date',
        'height',
        'weight',
        'mere',
        'instagram',
        'x',
        'facebook',
        'youtube',
        'tiktok',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
