<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

class ActivityFeed extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Fetch recent challenge activities
        $activities = $user->challenges()
            ->withPivot('status', 'progress', 'updated_at', 'created_at')
            ->orderByPivot('updated_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($challenge) {
                return (object) [
                    'type' => $challenge->pivot->status == 'completed' ? 'challenge_completed' : 'challenge_joined',
                    'user' => auth()->user(),
                    'challenge' => $challenge,
                    'created_at' => $challenge->pivot->updated_at,
                ];
            });

        return view('livewire.home.partials.activity-feed', [
            'activities' => $activities
        ]);
    }
}
