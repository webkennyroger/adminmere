<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\Layout;

class UserProfileEdit extends Component
{
    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.profile.user-profile-edit');
    }
}
