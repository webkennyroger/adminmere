<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

class RightSidebar extends Component
{
    public function render()
    {
        $user = auth()->user();

        // Challenges the user has joined (participating)
        $myChallenges = $user->challenges()
            ->withCount('users')
            ->orderBy('challenges.created_at', 'desc')
            ->take(4)
            ->get();

        return view('livewire.home.partials.right-sidebar', [
            'myChallenges' => $myChallenges,
            'isPremium' => $user->subscribed('default'), // Assuming Cashier
        ]);
    }
}
