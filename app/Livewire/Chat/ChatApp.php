<?php

namespace App\Livewire\Chat;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ChatApp extends Component
{
    public function render()
    {
        return view('livewire.chat.chat-app');
    }
}
