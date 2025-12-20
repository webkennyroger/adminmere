<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    public $user;
    public $name;
    
    public $activeTab = 'overview';

    public function mount($name = null)
    {
        if ($name) {
            $this->user = \App\Models\User::where('name', $name)->firstOrFail();
        } else {
            $this->user = auth()->user();
        }
    }

    public function getActivitiesProperty()
    {
        return $this->user->activities()
            ->with(['comments', 'likes']) // Eager load for feed
            ->latest('start_time')
            ->take(20)
            ->get();
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
            'stats' => $this->stats
        ])->layout('components.layouts.app'); // Ensure it uses the main layout
    }
}
