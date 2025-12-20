<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

class ActivityFeed extends Component
{
    public $viewingUserProfile = null;

    public function viewUserProfile($name)
    {
        $name = trim($name);
        $this->viewingUserProfile = \App\Models\User::where('name', $name)->first();
    }

    public function closeProfileModal()
    {
        $this->viewingUserProfile = null;
    }

    public function render()
    {
        $user = auth()->user();
        
        // Users for Mentions (Simple all users fetch for demo, optimize later)
        $mentionableUsers = \App\Models\User::select('id', 'name', 'avatar')->take(50)->get();
        
        // Fetch Activities (Social Feed)
        // comments.replies.user to eager load 2 levels (Comment -> Replies -> User)
        // Also eager load 'likes' for comments and replies
        $activities = \App\Models\Activity::with([
            'user', 
            'comments' => function($q) {
                $q->whereNull('parent_id')->latest();
            }, 
            'comments.user', 
            'comments.likes',
            'comments.replies.user', 
            'comments.replies.likes',
            'likes'
        ])
            ->latest('start_time')
            ->take(20)
            ->get();

        return view('livewire.home.partials.activity-feed', [
            'activities' => $activities,
            'mentionableUsers' => $mentionableUsers
        ]);
    }
}
