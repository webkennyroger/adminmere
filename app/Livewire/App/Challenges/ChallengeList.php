<?php

namespace App\Livewire\App\Challenges;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

class ChallengeList extends Component
{
    #[Url]
    public $selectedCategory = 'all';

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        $query = Challenge::query()
            ->whereDate('end_date', '>=', now())
            ->withCount('users')
            ->with(['users' => function($query) {
                $query->where('user_id', auth()->id());
            }, 'category']); // Eager load category

        if ($this->selectedCategory === 'my') {
            $query->whereHas('users', function($q) {
                $q->where('user_id', auth()->id());
            });
        } elseif ($this->selectedCategory !== 'all') {
            $query->whereHas('category', function($q) {
                $q->where('slug', $this->selectedCategory);
            });
        }

        $challenges = $query->orderBy('start_date')->get();
        $categories = \App\Models\Category::all();

        $featuredChallenge = Challenge::where('is_featured', true)
            ->whereDate('end_date', '>=', now())
            ->withCount('users')
            ->with(['users' => function($query) {
                $query->where('user_id', auth()->id());
            }, 'category'])
            ->first();

        return view('livewire.app.challenges.challenge-list', [
            'challenges' => $challenges,
            'categories' => $categories,
            'featuredChallenge' => $featuredChallenge
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

            // Create Feed Activity
            \App\Models\Activity::create([
                'user_id' => auth()->id(),
                'title' => 'Ingressou no Desafio: ' . $challenge->title,
                'description' => 'Aceitou o desafio ' . $challenge->title . '. Deseje boa sorte!',
                'sport_type' => 'challenge',
                'start_time' => now(),
                'distance' => 0,
                'duration' => 0,
                'calories' => 0,
            ]);

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Você ingressou no desafio com sucesso!',
                'title' => 'Desafio Aceito'
            ]);
        }
    }

    public $confirmingLeaveId = null;

    public function confirmLeave($challengeId)
    {
        $this->confirmingLeaveId = $challengeId;
    }

    public function leave()
    {
        if ($this->confirmingLeaveId) {
            $challenge = Challenge::find($this->confirmingLeaveId);
            if ($challenge) {
                $challenge->users()->detach(auth()->id());
                
                $this->dispatch('toast', [
                    'type' => 'info',
                    'message' => 'Você saiu do desafio.',
                    'title' => 'Desafio Cancelado'
                ]);
            }
            $this->confirmingLeaveId = null;
        }
    }
}
