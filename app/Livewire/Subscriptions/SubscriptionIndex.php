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
    
    public $selected = [];
    public $selectAll = false;

    public $userId;
    public $name;
    public $email;
    public $plan;

    public $showEditModal = false;
    public $showDeleteModal = false;

    public function mount()
    {
        \Illuminate\Support\Facades\Gate::authorize('manage-subscriptions');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'plan' => 'required|in:monthly,annual,free',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }
    
    public function updatedPerPage()
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getSubscribersQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
    }

    public function deleteSelected()
    {
        User::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Usuários excluídos com sucesso!']);
    }

    public function edit(User $user)
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->plan = $user->profile?->plan;
        
        $this->showEditModal = true;
        $this->resetValidation();
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['userId', 'name', 'email', 'plan']);
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $user = User::with('profile')->findOrFail($this->userId);
        
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($user->profile) {
            $user->profile->update(['plan' => $this->plan]);
        } else {
            $user->profile()->create(['plan' => $this->plan]);
        }

        $this->showEditModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Assinante atualizado com sucesso!']);
        $this->reset(['userId', 'name', 'email', 'plan']);
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->reset(['userId']);
    }

    public function delete()
    {
        User::findOrFail($this->userId)->delete();
        $this->showDeleteModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Usuário excluído com sucesso!']);
        $this->reset(['userId']);
    }
    
    private function getSubscribersQuery()
    {
        return User::whereHas('profile', function ($q) {
                $q->where('plan', '!=', 'free');
            })
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with('profile');
    }

    public function render()
    {
        $subscribers = $this->getSubscribersQuery()
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.subscriptions.subscription-index', [
            'subscribers' => $subscribers
        ])->layout('components.layouts.app');
    }
}
