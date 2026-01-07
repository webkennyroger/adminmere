<?php

namespace App\Livewire\App\Challenges;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ChallengeDetail extends Component
{
    public Challenge $challenge;

    public function mount(Challenge $challenge)
    {
        $this->challenge = $challenge->load(['category', 'users' => function($query) {
            $query->where('user_id', auth()->id());
        }]);
    }

    public $showLeaveModal = false;

    public function confirmLeave()
    {
        $this->showLeaveModal = true;
    }

    public function join()
    {
        if (!$this->challenge->users()->where('user_id', auth()->id())->exists()) {
            $this->challenge->users()->attach(auth()->id(), [
                'status' => 'joined', 
                'progress' => 0
            ]);

            // Create Feed Activity
            \App\Models\Activity::create([
                'user_id' => auth()->id(),
                'title' => 'Ingressou no Desafio: ' . $this->challenge->title,
                'description' => 'Aceitou o desafio ' . $this->challenge->title . '. Deseje boa sorte!',
                'sport_type' => 'challenge',
                'start_time' => now(),
                'distance' => 0,
                'duration' => 0,
                'calories' => 0,
            ]);

            $this->challenge->refresh();
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Você ingressou no desafio com sucesso!',
                'title' => 'Desafio Aceito'
            ]);
        }
    }

    public function leave()
    {
        $this->challenge->users()->detach(auth()->id());
        $this->showLeaveModal = false;
        $this->challenge->refresh();

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => 'Você saiu do desafio.',
            'title' => 'Desafio Cancelado'
        ]);
    }

    public function render()
    { // ... existing render
        $userChallenge = $this->challenge->users->where('id', auth()->id())->first();
        $isJoined = $userChallenge !== null;
        $progress = $isJoined ? ($userChallenge->pivot->progress ?? 0) : 0;
        
        // Calculate percentage
        $percent = $this->challenge->goal_km > 0 
            ? min(100, ($progress / $this->challenge->goal_km) * 100) 
            : 0;

        $leaderboard = $this->challenge->users()
            ->withPivot('progress')
            ->orderByPivot('progress', 'desc')
            ->take(10)
            ->get();

        return view('livewire.app.challenges.challenge-detail', [
            'isJoined' => $isJoined,
            'progress' => $progress,
            'percent' => $percent,
            'userChallenge' => $userChallenge,
            'leaderboard' => $leaderboard
        ]);
    }
}
