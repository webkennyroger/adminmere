<?php

namespace App\Livewire\Subscriptions;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\User;

class SubscriptionIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $subscribers = User::where('plan', '!=', 'free')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.subscriptions.subscription-index', [
            'subscribers' => $subscribers
        ])->layout('components.layouts.app');
    }
}
