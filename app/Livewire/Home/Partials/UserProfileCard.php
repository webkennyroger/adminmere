<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

class UserProfileCard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $challengesCount = $user->challenges()->count();
        // Simple gamification logic for demo
        $completedChallenges = $user->challenges()->wherePivot('status', 'completed')->count();
        $totalKm = $user->challenges()->sum('progress');
        
        return view('livewire.home.partials.user-profile-card', [
            'user' => $user,
            'challengesCount' => $challengesCount,
            'completedChallenges' => $completedChallenges,
            'totalKm' => $totalKm
        ]);
    }
}
