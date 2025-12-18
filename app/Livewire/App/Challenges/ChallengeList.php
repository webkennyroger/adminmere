<?php

namespace App\Livewire\App\Challenges;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ChallengeList extends Component
{
    public function render()
    {
        // Fetch active challenges ordered by start date
        // Also check if user has joined (we can use whereHas or simple collection check in view, 
        // but eager loading 'users' filtered by auth user is efficient for checking status)
        
        $challenges = Challenge::where('is_active', true) // Assuming is_active exists or we use date logic
            ->whereDate('end_date', '>=', now())
            ->with(['users' => function($query) {
                $query->where('user_id', auth()->id());
            }])
            ->orderBy('start_date')
            ->get();

        return view('livewire.app.challenges.challenge-list', [
            'challenges' => $challenges
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
