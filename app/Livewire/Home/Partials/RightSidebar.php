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
            ->where('is_active', true)
            ->whereDate('end_date', '>=', now())
            ->take(4)
            ->get();

        return view('livewire.home.partials.right-sidebar', [
            'myChallenges' => $myChallenges,
            'isPremium' => $user->subscribed('default') // Assuming Cashier
        ]);
    }
}
