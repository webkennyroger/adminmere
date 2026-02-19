<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function latestStory()
    {
        return $this->hasOne(Story::class)->latestOfMany()->where('expires_at', '>', now());
    }

    /**
     * Get the user's profile image path.
     */
    public function getImageAttribute()
    {
        return $this->profile?->image;
    }

    /**
     * Get the user's profile image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->profile?->image) {
            return asset('storage/' . $this->profile->image);
        }

        return $this->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the user's cover image URL.
     */
    public function getCoverUrlAttribute()
    {
        if ($this->profile?->cover_image) {
            return asset('storage/' . $this->profile->cover_image);
        }

        return 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80';
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function isAdmin(): bool
    {
        return $this->profile?->role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->email === 'webkennyroger@gmail.com';
    }

    public function isManager(): bool
    {
        return $this->profile?->role === 'manager';
    }

    public function hasRole(string $role): bool
    {
        return $this->profile?->role === $role;
    }

    // Legacy support
    public function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class)->withPivot('progress', 'status')->withTimestamps();
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    // Social Relationships
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')->withTimestamps();
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id')->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function follow(User $user)
    {
        $this->following()->syncWithoutDetaching($user);
    }

    public function unfollow(User $user)
    {
        $this->following()->detach($user);
    }

    /**
     * Get the route key for the model.
     * This makes Laravel use nickname instead of ID in routes.
     */
    public function getRouteKeyName()
    {
        // Check if we're on a profile route
        if (request()->route() && request()->route()->getName() === 'profile.view') {
            return 'profile.nickname';
        }
        return 'id';
    }

    /**
     * Get the user's profile URL with @nickname
     */
    public function getProfileUrlAttribute()
    {
        $nickname = $this->profile?->nickname ?? $this->id;
        return url('/@' . $nickname);
    }

    /**
     * Get the user's nickname or fallback to ID
     */
    public function getNicknameAttribute()
    {
        return $this->profile?->nickname ?? $this->id;
    }
}
