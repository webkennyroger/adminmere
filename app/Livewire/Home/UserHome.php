<?php

namespace App\Livewire\Home;

use Livewire\Component;

use Livewire\Attributes\Url;

class UserHome extends Component
{
    #[Url]
    public $feed = 'timeline';

    public function mount()
    {
        $this->feed = request()->query('feed', 'timeline');
    }

    public function render()
    {
        return view('livewire.home.user-home', [
            'feed' => $this->feed
        ])->layout('components.layouts.social');
    }
}
