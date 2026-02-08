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
    public $content = '';
    public $photo;
    public $feedType = 'personal'; // 'personal' = feed geral, 'community' = comunidade
    public $location = '';

    #[Layout('layouts.app')] 
    public function render()
    {
        $activities = Activity::with('user', 'comments', 'likes')
            ->where(function($q) {
                // Filtro básico de busca
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->latest('start_time') // Ordem cronológica decrescente
            ->paginate(10);

        return view('livewire.activities.activity-list', [
            'activities' => $activities,
        ]);
    }

    public function savePost()
    {
        $this->validate([
            'content' => 'required|min:3',
            'photo' => 'nullable|image|max:10240', // 10MB Máx
        ]);

        $media = [];

        // Upload de Mídia
        if ($this->photo) {
            $path = $this->photo->store('activities/' . auth()->id(), 'public');
            $media[] = asset('storage/' . $path);
        }

        // Criar Atividade no Banco
        Activity::create([
            'user_id' => auth()->id(),
            'title' => 'Publicação Web', // Título padrão
            'sport_type' => 'Social',    // Tipo padrão
            'start_time' => now(),
            'distance' => 0,
            'duration' => 0,
            'feed_type' => $this->feedType, // 'personal' ou 'community'
            'location' => $this->location ?: (auth()->user()->profile->city ?? 'Web'),
            'description' => $this->content,
            'media' => $media,
            'privacy' => 'public',
        ]);

        // Resetar campos e notificar sucesso
        $this->reset(['content', 'photo', 'location']);
        session()->flash('message', 'Publicado com sucesso! 🎉');
    }
}
