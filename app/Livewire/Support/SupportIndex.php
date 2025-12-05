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
        $this->validate();

        Support::create([
            'user_id' => auth()->id(),
            'subject' => $this->subject,
            'priority' => $this->priority,
            'message' => $this->message,
            'status' => 'open',
        ]);

        $this->reset();
        session()->flash('status', 'Ticket criado com sucesso!');
        
        // Opcional: Redirecionar para a lista após criar
        // return $this->redirect(route('support.list'), navigate: true);
    }

    public function render()
    {
        return view('livewire.support.support-index', [
            'tickets' => Support::where('user_id', auth()->id())
                ->latest()
                ->limit(5)
                ->get(), // Mostra apenas os 5 últimos no dashboard de suporte
        ]);
    }
}
