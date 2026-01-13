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
    public $hasMore = true;

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
        if (!$this->hasMore) return;
        $this->page++;
    }


    public function render()
    {
        $user = auth()->user();
        
        // Users for Mentions
        $mentionableUsers = \App\Models\User::select('id', 'name', 'avatar')->take(50)->get();
        
        // Base Query
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
            $followingIds = $user->following()->pluck('users.id');
            $followingIds->push($user->id);
            $query->whereIn('user_id', $followingIds);
        }

        $totalCount = $query->count();
        $this->hasMore = ($this->perPage * $this->page) < $totalCount;

        $activities = $query->latest('start_time')
            ->take($this->perPage * $this->page)
            ->get();

        return view('livewire.home.partials.activity-feed', [
            'activities' => $activities,
            'mentionableUsers' => $mentionableUsers
        ]);
    }
}
