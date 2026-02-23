<?php

namespace App\Livewire\Home\Partials;

use App\Models\Activity;
use Livewire\Component;

class ActivityItem extends Component
{
    use \App\Livewire\Traits\HasInteractions;
    use \Livewire\WithFileUploads;

    public Activity $activity;

    // Edit/Delete Activity
    public $editingActivity = false;

    public $editTitle = '';

    public $editContent = '';

    public $editPhotos = [];

    public $editVideos = [];

    public $mediaToRemove = [];

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
        $this->mediaToRemove = [];
    }

    public function cancelEditingActivity()
    {
        $this->editingActivity = false;
        $this->editTitle = $this->activity->title ?? '';
        $this->editContent = $this->activity->description ?? '';
    }

    public function removeExistingMedia($url)
    {
        if (! in_array($url, $this->mediaToRemove)) {
            $this->mediaToRemove[] = $url;
        }
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
            'editPhotos.*' => 'nullable|image|max:20480',
            'editVideos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400',
        ]);

        $media = collect($this->activity->media ?? [])
            ->reject(fn ($m) => in_array($m, $this->mediaToRemove))
            ->values()
            ->all();

        if ($this->editPhotos) {
            foreach ($this->editPhotos as $photo) {
                $path = $photo->store('activities/'.auth()->id().'/photos', 'public');
                $media[] = url('storage/'.$path);
            }
        }

        if ($this->editVideos) {
            foreach ($this->editVideos as $video) {
                $path = $video->store('activities/'.auth()->id().'/videos', 'public');
                $media[] = url('storage/'.$path);
            }
        }

        $action = new \App\Actions\Activities\UpdateActivity;
        $this->activity = $action->execute($this->activity, [
            'title' => $this->editTitle ?: 'Publicação',
            'description' => $this->editContent,
            'media' => $media,
        ]);

        $this->editPhotos = [];
        $this->editVideos = [];
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

        $action = new \App\Actions\Activities\DeleteActivity;
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
