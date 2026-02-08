<?php

namespace App\Livewire\Home\Partials;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;

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
        if (! $this->hasMore) {
            return;
        }
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
            $path = $this->photo->store('posts/'.auth()->id(), 'public');
            $media[] = asset('storage/'.$path);
        }

        Post::create([
            'user_id' => auth()->id(),
            'title' => $this->title ?: null,
            'content' => $this->content,
            'media' => $media,
            'feed_type' => $this->feedType,
            'location' => $this->location ?: (auth()->user()->profile->city ?? null),
            'privacy' => 'public',
        ]);

        $this->reset(['title', 'content', 'photo', 'location']);
        session()->flash('message', 'Publicado com sucesso! 🎉');

        // Force refresh
        $this->js('window.location.reload()');
    }

    #[On('post-deleted')]
    #[On('activity-deleted')]
    public function refreshFeed(): void
    {
        // This will trigger a re-render of the component
    }

    public function render()
    {
        $user = auth()->user();

        // Users for Mentions
        $mentionableUsers = \App\Models\User::select('id', 'name', 'avatar')->take(50)->get();

        // Fetch Posts
        $postsQuery = Post::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes']);

        // Fetch Activities
        $activitiesQuery = \App\Models\Activity::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes']);

        if ($this->feed === 'personal') {
            $postsQuery->where('user_id', $user->id);
            $activitiesQuery->where('user_id', $user->id);
        } elseif ($this->feed === 'timeline' || $this->feed === 'network') {
            $followingIds = $user->following()->pluck('following_id')->toArray();
            $followingIds[] = $user->id;
            $postsQuery->whereIn('user_id', $followingIds);
            $activitiesQuery->whereIn('user_id', $followingIds);
        }

        // Get posts and activities
        $posts = $postsQuery->latest('created_at')->get();
        $activities = $activitiesQuery->latest('start_time')->get();

        // Merge and sort by date
        $items = collect([])
            ->merge($posts->map(fn ($post) => ['type' => 'post', 'item' => $post, 'date' => $post->created_at]))
            ->merge($activities->map(fn ($activity) => ['type' => 'activity', 'item' => $activity, 'date' => $activity->start_time]))
            ->sortByDesc('date')
            ->take($this->perPage * $this->page)
            ->values();

        $totalCount = $posts->count() + $activities->count();
        $this->hasMore = ($this->perPage * $this->page) < $totalCount;

        return view('livewire.home.partials.activity-feed', [
            'items' => $items,
            'mentionableUsers' => $mentionableUsers,
        ]);
    }
}
