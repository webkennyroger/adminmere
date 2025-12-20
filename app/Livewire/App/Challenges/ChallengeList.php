<?php

namespace App\Livewire\App\Challenges;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ChallengeList extends Component
{
    public $selectedCategory = 'all';

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        $query = Challenge::query()
            ->whereDate('end_date', '>=', now())
            ->with(['users' => function($query) {
                $query->where('user_id', auth()->id());
            }, 'category']); // Eager load category

        if ($this->selectedCategory !== 'all') {
            $query->whereHas('category', function($q) {
                $q->where('slug', $this->selectedCategory);
            });
        }

        $challenges = $query->orderBy('start_date')->get();
        $categories = \App\Models\Category::all();

        return view('livewire.app.challenges.challenge-list', [
            'challenges' => $challenges,
            'categories' => $categories
        ]);
    }

    public function join($challengeId)
    {
        $challenge = Challenge::findOrFail($challengeId);

        // Check if already joined
        if (!$challenge->users()->where('user_id', auth()->id())->exists()) {
            $challenge->users()->attach(auth()->id(), [
                'status' => 'joined', 
                'progress' => 0
            ]);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Você ingressou no desafio com sucesso!',
                'title' => 'Desafio Aceito'
            ]);
        }
    }
}
