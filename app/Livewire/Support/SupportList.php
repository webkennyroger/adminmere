<?php

namespace App\Livewire\Support;

use App\Models\Support;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
    public $sortAsc = false; // false = descending (newest first)

    public $perPage = 10;

    public $selected = [];

    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getTicketsQuery()->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedSelected()
    {
        $totalTickets = $this->getTicketsQuery()->count();
        $this->selectAll = count($this->selected) === $totalTickets && $totalTickets > 0;
    }

    public function setFilter($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function setSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortBy = $field;
            $this->sortAsc = true;
        }
    }

    public $confirmingDeletion = false;

    public $ticketToDelete;

    public function confirmDelete($id)
    {
        $this->ticketToDelete = Support::findOrFail($id);
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if ($this->ticketToDelete) {
            // Only admin or ticket owner can delete
            if (! auth()->user()->is_admin && $this->ticketToDelete->user_id !== auth()->id()) {
                abort(403);
            }

            $this->ticketToDelete->delete();

            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'O ticket foi excluído do sistema!',
                'title' => 'Ticket Deletado',
            ]);
        }

        $this->confirmingDeletion = false;
        $this->ticketToDelete = null;
    }

    public function deleteSelected()
    {
        $tickets = Support::whereIn('id', $this->selected)->get();

        foreach ($tickets as $ticket) {
            // Only admin or ticket owner can delete
            if (auth()->user()->is_admin || $ticket->user_id === auth()->id()) {
                $ticket->delete();
            }
        }

        $this->selected = [];
        $this->selectAll = false;

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Tickets deletados com sucesso!']);
    }

    protected function getTicketsQuery()
    {
        $user = auth()->user();
        $query = Support::query();

        // Filter by user if not admin
        if (! $user->is_admin) {
            $query->where('user_id', $user->id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%'.$this->search.'%')
                    ->orWhere('ticket_id', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->status !== 'all') {
            if ($this->status === 'pending') {
                $query->whereIn('status', ['pending', 'open']);
            } elseif ($this->status === 'solved') {
                $query->whereIn('status', ['resolved', 'closed', 'solved']);
            } else {
                $query->where('status', $this->status);
            }
        }

        return $query;
    }

    public function render()
    {
        $query = $this->getTicketsQuery();
        $query->orderBy($this->sortBy, $this->sortAsc ? 'asc' : 'desc');

        $perPage = $this->perPage == -1 ? $query->count() : $this->perPage;

        // Counts
        $user = auth()->user();
        $countQuery = Support::query();
        if (! $user->is_admin) {
            $countQuery->where('user_id', $user->id);
        }

        return view('livewire.support.support-list', [
            'tickets' => $query->paginate($perPage),
            'totalTickets' => (clone $countQuery)->count(),
            'pendingTickets' => (clone $countQuery)->whereIn('status', ['pending', 'open'])->count(),
            'solvedTickets' => (clone $countQuery)->whereIn('status', ['solved', 'resolved', 'closed'])->count(),
        ]);
    }
}
