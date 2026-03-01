<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

class UserProfileCard extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.home.partials.user-profile-card', [
            'user' => $user,
            'followingCount' => $user->following()->count(),
            'followersCount' => $user->followers()->count(),
            'activitiesCount' => $user->activities()->count(),
        ]);
    }
}
