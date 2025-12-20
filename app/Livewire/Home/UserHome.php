<?php

namespace App\Livewire\Home;

use Livewire\Component;

class UserHome extends Component
{
    public function render()
    {
        return view('livewire.home.user-home')
            ->layout('components.layouts.social');
    }
}
