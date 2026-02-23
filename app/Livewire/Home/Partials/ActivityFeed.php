<?php

namespace App\Livewire\Home\Partials;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

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
        if (! $this->hasMore) {
            return;
        }
        $this->page++;
    }

    #[On('post-created')]
    #[On('post-deleted')]
    #[On('activity-deleted')]
    #[On('refresh-feed')]
    public function refreshFeed(): void
    {
        $this->resetPage(); // If I had one, but here it's scroll based
    }

    public function render()
    {
        $user = auth()->user();

        // Posts Query
        $postsQuery = Post::query()->with(['user', 'likes', 'pollOptions', 'pollVotes']);

        // Activities Query
        $activitiesQuery = \App\Models\Activity::query()->with(['user', 'likes']);

        if ($this->feed === 'timeline' || $this->feed === 'network' || $this->feed === 'community') {
            $postsQuery->where('privacy', 'public');
            $activitiesQuery->where('privacy', 'public');
            
            if ($this->feed === 'community') {
                $postsQuery->orWhere('feed_type', 'community');
            }
        } elseif ($this->feed === 'personal') {
            $postsQuery->where('user_id', $user->id);
            $activitiesQuery->where('user_id', $user->id);
        }

        // Fetch enough to cover the current page + some buffer
        $limit = max(100, $this->perPage * $this->page + 20);
        $posts = $postsQuery->latest()->limit($limit)->get();
        $activities = $activitiesQuery->latest('start_time')->limit($limit)->get();

        // Merge and sort
        $items = collect([])
            ->merge($posts->map(fn($post) => [
                'type' => 'post',
                'item' => $post,
                'date' => $post->created_at?->toDateTimeString() ?? now()->toDateTimeString()
            ]))
            ->merge($activities->map(fn($activity) => [
                'type' => 'activity',
                'item' => $activity,
                'date' => $activity->start_time?->toDateTimeString() ?? ($activity->created_at?->toDateTimeString() ?? now()->toDateTimeString())
            ]))
            ->sortByDesc('date')
            ->values();

        $pagedItems = $items->take($this->perPage * $this->page);
        $this->hasMore = $items->count() > $pagedItems->count();

        return view('livewire.home.partials.activity-feed', [
            'items' => $pagedItems,
            'feed' => $this->feed,
        ]);
    }
}
