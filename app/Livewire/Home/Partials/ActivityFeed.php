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

        // Users for Mentions
        $mentionableUsers = \App\Models\User::select('id', 'name', 'avatar')->take(50)->get();

        // Fetch Posts
        $postsQuery = Post::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes', 'pollOptions', 'pollVotes']);

        // Fetch Activities
        $activitiesQuery = \App\Models\Activity::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes']);

        if ($this->feed === 'timeline' || $this->feed === 'network') {
            // Show public posts and activities from everyone (Discovery mode)
            $postsQuery->where('privacy', 'public');
            $activitiesQuery->where('privacy', 'public');
        } elseif ($this->feed === 'personal') {
            $postsQuery->where('user_id', $user->id);
            $activitiesQuery->where('user_id', $user->id);
        } elseif ($this->feed === 'community') {
            // Community feed shows public posts from everyone
            $postsQuery->where('feed_type', 'community')->orWhere('privacy', 'public');
            // Activities are usually public
            $activitiesQuery->where('privacy', 'public');
        }

        // Get posts and activities
        $posts = $postsQuery->latest('created_at')->limit(50)->get();
        $activities = $activitiesQuery->latest('start_time')->limit(50)->get();

        // Merge and sort by date
        $items = collect([])
            ->merge($posts->map(fn($post) => [
                'type' => 'post',
                'item' => $post,
                'date' => $post->created_at ? $post->created_at->toDateTimeString() : now()->toDateTimeString()
            ]))
            ->merge($activities->map(fn($activity) => [
                'type' => 'activity',
                'item' => $activity,
                'date' => $activity->start_time ? $activity->start_time->toDateTimeString() : now()->toDateTimeString()
            ]))
            ->sortByDesc('date')
            ->take($this->perPage * $this->page)
            ->values();

        $totalCount = $posts->count() + $activities->count();
        $this->hasMore = ($this->perPage * $this->page) < $totalCount;

        return view('livewire.home.partials.activity-feed', [
            'items' => $items,
        ]);
    }
}
