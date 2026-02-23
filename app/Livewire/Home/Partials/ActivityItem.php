<?php

namespace App\Livewire\Home\Partials;

use App\Models\Activity;
use Livewire\Component;

class ActivityItem extends Component
{
    use \App\Livewire\Traits\HasInteractions;

    public Activity $activity;

    // Edit/Delete Activity
    public $editingActivity = false;

    public $editTitle = '';

    public $editContent = '';

    public $confirmingActivityDeletion = false;

    public function getInteractableModel()
    {
        return $this->activity;
    }

    public function mount(Activity $activity)
    {
        $this->activity = $activity;
        $this->editTitle = $activity->title ?? '';
        $this->editContent = $activity->description ?? '';
    }

    public function startEditingActivity()
    {
        $user = auth()->user();
        if ($this->activity->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para editar.');

            return;
        }
        $this->editTitle = $this->activity->title ?? '';
        $this->editContent = $this->activity->description ?? '';
        $this->editingActivity = true;
    }

    public function cancelEditingActivity()
    {
        $this->editingActivity = false;
        $this->editTitle = $this->activity->title ?? '';
        $this->editContent = $this->activity->description ?? '';
    }

    public function updateActivity()
    {
        $user = auth()->user();
        if ($this->activity->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para editar.');

            return;
        }

        $this->validate([
            'editTitle' => 'nullable|string|max:100',
            'editContent' => 'nullable|string',
        ]);

        $action = new \App\Actions\Activities\UpdateActivity();
        $this->activity = $action->execute($this->activity, [
            'title' => $this->editTitle ?: 'Publicação',
            'description' => $this->editContent,
        ]);

        $this->editingActivity = false;
        session()->flash('message', 'Atividade atualizada com sucesso!');
    }

    public function confirmDeleteActivity()
    {
        $user = auth()->user();
        if ($this->activity->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para excluir.');

            return;
        }
        $this->confirmingActivityDeletion = true;
    }

    public function cancelDeleteActivity()
    {
        $this->confirmingActivityDeletion = false;
    }

    public function deleteActivity()
    {
        $user = auth()->user();
        if ($this->activity->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para excluir.');

            return;
        }

        $action = new \App\Actions\Activities\DeleteActivity();
        $action->execute($this->activity);

        $this->confirmingActivityDeletion = false;
        $this->dispatch('activity-deleted');
        $this->dispatch('refresh-feed');
        session()->flash('message', 'Atividade deletada com sucesso!');
    }

    public function render()
    {
        return view('livewire.home.partials.activity-item');
    }
}
