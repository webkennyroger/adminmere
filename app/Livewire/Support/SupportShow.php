<?php

namespace App\Livewire\Support;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Support;

#[Layout('components.layouts.app', ['title' => 'Detalhes do Ticket'])]
class SupportShow extends Component
{
    public Support $support;
    public string $replyMessage = '';

    public function mount(Support $support)
    {
        $this->support = $support;
        
        // Ensure user owns the ticket
        if ($support->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function submitReply()
    {
        $this->validate([
            'replyMessage' => 'required|string|min:2',
        ]);

        $this->support->replies()->create([
            'user_id' => auth()->id(),
            'message' => $this->replyMessage,
        ]);

        $this->reset('replyMessage');
        
        // Refresh the support model to show new reply
        $this->support->refresh();
    }

    public function render()
    {
        return view('livewire.support.support-show');
    }
}
