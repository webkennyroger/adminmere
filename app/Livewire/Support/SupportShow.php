<?php

namespace App\Livewire\Support;

use App\Models\Support;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Detalhes do Ticket'])]
class SupportShow extends Component
{
    public Support $support;

    public string $replyMessage = '';

    public string $status;

    public function mount(Support $support)
    {
        $this->support = $support;
        $this->status = $support->status;

        // Ensure user owners the ticket or is admin
        if ($support->user_id !== auth()->id() && ! auth()->user()->is_admin) {
            abort(403);
        }
    }

    public function saveStatus()
    {
        if (! auth()->user()->is_admin) {
            return;
        }

        if (in_array($this->status, ['open', 'pending', 'resolved', 'closed'])) {
            $this->support->update(['status' => $this->status]);

            // Redirect to force page reload and show updated status
            return redirect()->route('support.show', $this->support->id)
                ->with('message', 'Status atualizado com sucesso!');
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

        // If admin replies, maybe set to pending (waiting for user answer)
        // If user replies, maybe set to open (waiting for admin answer)
        // For now, let's leave it as is or optional.
        if (auth()->user()->is_admin && $this->support->status === 'open') {
            // Optional: change to pending automatically?
            // user requested manual change, so I will stick to that.
        }

        $this->reset('replyMessage');

        // Refresh the support model to show new reply
        $this->support->refresh();
    }

    public function render()
    {
        return view('livewire.support.support-show');
    }
}
