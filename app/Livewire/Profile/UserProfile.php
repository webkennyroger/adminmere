<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    public $user;

    public $name;

    public $activeTab = 'overview';

    public function mount($nickname = null)
    {
        if ($nickname) {
            // Find user by nickname in profiles table
            $profile = \App\Models\Profile::where('nickname', $nickname)->firstOrFail();
            $this->user = $profile->user;
        } else {
            // Fallback for direct access if any, or auth user
            $this->user = auth()->user();
        }

        if (! $this->user) {
            abort(404);
        }
    }

    public function getActivitiesProperty()
    {
        $activities = $this->user->activities()
            ->with(['comments.user', 'likes', 'user'])
            ->latest('start_time')
            ->take(20)
            ->get();

        $posts = \App\Models\Post::where('user_id', $this->user->id)
            ->with(['comments.user', 'likes', 'user', 'pollOptions'])
            ->latest('created_at')
            ->take(20)
            ->get();

        return collect([])
            ->merge($activities->map(fn ($item) => ['type' => 'activity', 'item' => $item, 'date' => $item->start_time]))
            ->merge($posts->map(fn ($item) => ['type' => 'post', 'item' => $item, 'date' => $item->created_at]))
            ->sortByDesc('date')
            ->take(20)
            ->values();
    }

    public function toggleFollow()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }

        $currentUser = auth()->user();

        if ($currentUser->id === $this->user->id) {
            return;
        }

        if ($currentUser->isFollowing($this->user)) {
            $currentUser->unfollow($this->user);
        } else {
            $currentUser->follow($this->user);
        }

        // Notify other components to refresh the feed
        $this->dispatch('refresh-feed');
    }

    public function getStatsProperty()
    {
        // Calculate basic stats
        $activities = $this->user->activities;

        $totalActivities = $activities->count();
        $totalDistance = $activities->sum('distance'); // in meters
        $totalDuration = $activities->sum('duration'); // in seconds

        // Mode specific stats (Last 4 weeks)
        $last4Weeks = now()->subWeeks(4);
        $recentActivities = $activities->where('start_time', '>=', $last4Weeks);

        $runDistance = $recentActivities->where('sport_type', 'run')->sum('distance');
        $rideDistance = $recentActivities->where('sport_type', 'ride')->sum('distance');
        $swimDistance = $recentActivities->where('sport_type', 'swim')->sum('distance');
        $walkDistance = $recentActivities->where('sport_type', 'walk')->sum('distance');

        return [
            'total_activities_last_4_weeks' => $recentActivities->count(),
            'total_activities_all_time' => $totalActivities,
            'recent_run_km' => round($runDistance / 1000, 1),
            'recent_ride_km' => round($rideDistance / 1000, 1),
            'recent_swim_km' => round($swimDistance / 1000, 1),
            'recent_walk_km' => round($walkDistance / 1000, 1),
        ];
    }

    public function render()
    {
        return view('livewire.profile.user-profile', [
            'activities' => $this->activities,
            'stats' => $this->stats,
        ])->layout('components.layouts.app'); // Ensure it uses the main layout
    }
}
