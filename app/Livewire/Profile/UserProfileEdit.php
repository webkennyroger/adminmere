<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;

class UserProfileEdit extends Component
{
    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.profile.user-profile-edit');
    }
}
