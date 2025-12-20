<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class UserRelationships extends Component
{
    use WithPagination;

    public User $user;
    public $activeTab = 'following'; // 'following' or 'followers'

    public function mount(User $user)
    {
        $this->user = $user;
        
        // Determine active tab based on route name
        if (request()->routeIs('users.followers')) {
            $this->activeTab = 'followers';
        } else {
            $this->activeTab = 'following';
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        
        // Update URL via browser history without full reload if possible, 
        // essentially acting navigating between the two routes.
        // For simplicity in Livewire we can just redirect or rely on the view state.
        // But to keep URL in sync with the route definitions:
        if ($tab === 'following') {
            return redirect()->route('users.following', $this->user);
        } else {
            return redirect()->route('users.followers', $this->user);
        }
    }
    
    // Helper to toggle follow (reusing logic from FindFriends/SuggestedFriends ideally)
    public function toggleFollow($userId)
    {
        $targetUser = User::find($userId);
        $currentUser = auth()->user();

        if (!$targetUser || $targetUser->id === $currentUser->id) return;

        if ($currentUser->isFollowing($targetUser)) {
            $currentUser->unfollow($targetUser);
        } else {
            $currentUser->follow($targetUser);
        }
    }

    public function render()
    {
        $users = match($this->activeTab) {
            'followers' => $this->user->followers()->paginate(20),
            'following' => $this->user->following()->paginate(20),
            default => $this->user->following()->paginate(20),
        };

        return view('livewire.users.user-relationships', [
            'users' => $users,
        ]);
    }
}
