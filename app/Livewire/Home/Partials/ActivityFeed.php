<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

use Livewire\Attributes\Reactive;

class ActivityFeed extends Component
{
    #[Reactive]
    public $feed = 'personal';

    public $viewingUserProfile = null;

    public $page = 1;
    public $perPage = 10;

    public function viewUserProfile($name)
    {
        $name = trim($name);
        $this->viewingUserProfile = \App\Models\User::where('name', $name)->first();
    }

    public function closeProfileModal()
    {
        $this->viewingUserProfile = null;
    }

    public function loadMore()
    {
        $this->page++;
    }


    public function render()
    {
        $user = auth()->user();
        
        // Users for Mentions (Simple all users fetch for demo, optimize later)
        $mentionableUsers = \App\Models\User::select('id', 'name', 'avatar')->take(50)->get();
        
        // Fetch Activities (Social Feed)
        // comments.replies.user to eager load 2 levels (Comment -> Replies -> User)
        // Also eager load 'likes' for comments and replies
        $query = \App\Models\Activity::with([
            'user', 
            'comments' => function($q) {
                $q->whereNull('parent_id')->latest();
            }, 
            'comments.user', 
            'comments.likes',
            'comments.replies.user', 
            'comments.replies.likes',
            'likes'
        ]);

        if ($this->feed === 'personal') {
            $query->where('user_id', $user->id);
        } elseif ($this->feed === 'timeline' || $this->feed === 'network') { 
            // 'network' kept for legacy or if url param persists, mapped to timeline logic (me + following)
            // or strictly strictly network only? User said "dos meus seguidores e meus posts".
            // So timeline = me + following.
            
            $followingIds = $user->following()->pluck('users.id');
            $followingIds->push($user->id);
            
            $query->whereIn('user_id', $followingIds);
        }

        $activities = $query->latest('start_time')
            ->take($this->perPage * $this->page)
            ->get();

        return view('livewire.home.partials.activity-feed', [
            'activities' => $activities,
            'mentionableUsers' => $mentionableUsers
        ]);
    }
}
