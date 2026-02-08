<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;

use Livewire\Attributes\Reactive;
use Livewire\WithFileUploads;
use App\Models\Activity;

class ActivityFeed extends Component
{
    #[Reactive]
    public $feed = 'personal';

    use WithFileUploads; 

    // Propriedades do Novo Post
    public $title = '';
    public $content = '';
    public $photo;
    public $feedType = 'personal'; 
    public $location = '';

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

    public function savePost()
    {
        $this->validate([
            'title' => 'nullable|string|max:100',
            'content' => 'required|min:3',
            'photo' => 'nullable|image|max:20480', // 20MB
        ]);

        $media = [];

        if ($this->photo) {
            $path = $this->photo->store('activities/' . auth()->id(), 'public');
            $media[] = asset('storage/' . $path);
        }

        Activity::create([
            'user_id' => auth()->id(),
            'title' => $this->title ?: 'Nova Publicação',
            'sport_type' => 'Social',
            'start_time' => now(),
            'distance' => 0,
            'duration' => 0,
            'feed_type' => $this->feedType,
            'location' => $this->location ?: (auth()->user()->profile->city ?? 'Brasil'),
            'description' => $this->content,
            'media' => $media,
            'privacy' => 'public',
        ]);

        $this->reset(['title', 'content', 'photo', 'location']);
        session()->flash('message', 'Publicado com sucesso! 🎉');
        
        // Force refresh
        $this->js('window.location.reload()'); 
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
            $followingIds = $user->following()->pluck('following_id')->toArray();
            $followingIds[] = $user->id;
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
