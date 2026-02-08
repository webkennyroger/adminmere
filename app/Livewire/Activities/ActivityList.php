<?php

namespace App\Livewire\Activities;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Activity;
use Livewire\Attributes\Layout;

class ActivityList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    // Propriedades do Post
    public $title = ''; // NOVO: Título do Post
    public $content = '';
    public $photo;
    public $feedType = 'personal'; 
    public $location = '';

    #[Layout('layouts.app')] 
    public function render()
    {
        $activities = Activity::with('user', 'comments', 'likes')
            ->where(function($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->latest('start_time')
            ->paginate(10);

        return view('livewire.activities.activity-list', [
            'activities' => $activities,
        ]);
    }

    public function savePost()
    {
        $this->validate([
            'title' => 'nullable|string|max:100', // Título opcional mas recomendado
            'content' => 'required|min:3',
            'photo' => 'nullable|image|max:10240', 
        ]);

        $media = [];

        if ($this->photo) {
            $path = $this->photo->store('activities/' . auth()->id(), 'public');
            $media[] = asset('storage/' . $path);
        }

        Activity::create([
            'user_id' => auth()->id(),
            'title' => $this->title ?: 'Nova Publicação', // Usa o título ou um padrão
            'sport_type' => 'Social',
            'start_time' => now(),
            'distance' => 0,
            'duration' => 0,
            'feed_type' => $this->feedType,
            'location' => $this->location ?: (auth()->user()->profile->city ?? 'Brasil'),
            'description' => $this->content,
            'media' => $media,
            'privacy' => 'public',
        ]);

        $this->reset(['title', 'content', 'photo', 'location']); // Resetar título também
        session()->flash('message', 'Publicado com sucesso! 🎉');
    }
}
