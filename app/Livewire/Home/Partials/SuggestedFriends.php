<?php

namespace App\Livewire\Home\Partials;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SuggestedFriends extends Component
{
    public $suggestions;
    public $maxSuggestions = 3;

    public function mount()
    {
        $this->loadSuggestions();
    }

    public function loadSuggestions()
    {
        $dismissed = Session::get('dismissed_suggestions', []);
        
        $user = Auth::user();

        // Get users who are NOT me, NOT already followed, and NOT dismissed
        $this->suggestions = User::query()
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', $dismissed)
            ->whereDoesntHave('followers', function ($query) use ($user) {
                $query->where('follower_id', $user->id);
            })
            // Ideally we prioritized users with same city or friends in common
            // For now, random is fine to start
            ->inRandomOrder()
            ->limit($this->maxSuggestions)
            ->get();
    }

    public function follow($userId)
    {
        $userToFollow = User::find($userId);

        if ($userToFollow) {
            Auth::user()->follow($userToFollow);
            
            // Reload suggestions to replace the followed user
            $this->loadSuggestions();
            
            // Dispatch event for other components (optional)
            $this->dispatch('friend-followed');
        }
    }

    public function dismiss($userId)
    {
        $dismissed = Session::get('dismissed_suggestions', []);
        $dismissed[] = $userId;
        Session::put('dismissed_suggestions', $dismissed);

        // Reload suggestions to replace the dismissed user
        $this->loadSuggestions();
    }

    public function render()
    {
        return view('livewire.home.partials.suggested-friends');
    }
}
