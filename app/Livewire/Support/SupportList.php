<?php

namespace App\Livewire\Support;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use App\Models\Support;

#[Layout('components.layouts.app', ['title' => 'Lista de Tickets'])]
class SupportList extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $status = 'all';

    #[Url]
    public $sortBy = 'created_at';

    #[Url]
    public $sortAsc = false;

    public function setFilter($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function setSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortBy = $field;
            $this->sortAsc = true;
        }
    }

    public function render()
    {
        $query = Support::where('user_id', auth()->id());

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%' . $this->search . '%')
                  ->orWhere('ticket_id', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        $query->orderBy($this->sortBy, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.support.support-list', [
            'tickets' => $query->paginate(10),
            'totalTickets' => Support::where('user_id', auth()->id())->count(),
            'pendingTickets' => Support::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'solvedTickets' => Support::where('user_id', auth()->id())->where('status', 'solved')->count(),
        ]);
    }
}
