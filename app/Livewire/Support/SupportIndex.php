<?php

namespace App\Livewire\Support;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Support;

#[Layout('components.layouts.app', ['title' => 'Suporte e Ajuda'])]
class SupportIndex extends Component
{
    public $subject;
    public $priority = 'low';
    public $message;

    protected $rules = [
        'subject' => 'required|min:5|max:100',
        'priority' => 'required|in:low,medium,high',
        'message' => 'required|min:10',
    ];

    public function submitSupportForm()
    {
        \Illuminate\Support\Facades\Log::info('Support form submission started', [
            'user' => auth()->id(),
            'data' => [
                'subject' => $this->subject,
                'priority' => $this->priority,
                'message' => $this->message
            ]
        ]);

        $this->validate();

        Support::create([
            'user_id' => auth()->id(),
            'subject' => $this->subject,
            'priority' => $this->priority,
            'message' => $this->message,
            'status' => 'pending',
        ]);

        $this->reset();
        
        // Redirecionar para a lista após criar para confirmar visualização
        return redirect()->route('support.list')->with('status', 'Ticket criado com sucesso!');
    }

    public function render()
    {
        return view('livewire.support.support-index', [
            'tickets' => Support::where('user_id', auth()->id())
                ->latest()
                ->get(),
        ]);
    }
}
