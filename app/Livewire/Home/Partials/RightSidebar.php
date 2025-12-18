<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

class RightSidebar extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Suggest challenges not joined yet
        $suggestedChallenges = \App\Models\Challenge::where('is_active', true)
            ->whereDate('end_date', '>=', now())
            ->whereDoesntHave('users', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->take(3)
            ->get();

        return view('livewire.home.partials.right-sidebar', [
            'suggestedChallenges' => $suggestedChallenges,
            'isPremium' => $user->subscribed('default') // Assuming Cashier
        ]);
    }
}
