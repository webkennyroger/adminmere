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
    public $photos = [];
    public $feedType = 'personal';
    public $location = '';

    // Poll Properties
    public $isPoll = false;
    public $pollOptions = ['', '']; // Start with 2 empty options
    public $pollDuration = 7; // Days

    public $viewingUserProfile = null;
    public $showPostForm = true;
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

    // --- Poll Methods ---

    public function togglePoll()
    {
        $this->isPoll = !$this->isPoll;
        if ($this->isPoll && count($this->pollOptions) < 2) {
            $this->pollOptions = ['', ''];
        }
    }

    public function addPollOption()
    {
        if (count($this->pollOptions) < 5) {
            $this->pollOptions[] = '';
        }
    }

    public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            unset($this->photos[$index]);
            $this->photos = array_values($this->photos);
        }
    }

    public function removePollOption($index)
    {
        if (count($this->pollOptions) > 2) {
            unset($this->pollOptions[$index]);
            $this->pollOptions = array_values($this->pollOptions);
        }
    }

    public function savePost()
    {
        $rules = [
            'title' => 'nullable|string|max:100',
            'content' => 'required|min:3',
            'photos.*' => 'nullable|image|max:20480', // 20MB per photo
            'photos' => 'nullable|array|max:5', // Limit to 5 photos
        ];

        if ($this->isPoll) {
            $rules['pollOptions.*'] = 'required|string|max:255';
            $rules['pollOptions'] = 'array|min:2';
        }

        $this->validate($rules);

        $media = [];

        if ($this->photos) {
            foreach ($this->photos as $photo) {
                $path = $photo->store('posts/' . auth()->id(), 'public');
                $media[] = asset('storage/' . $path);
            }
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $this->title ?: null,
            'content' => $this->content,
            'media' => $media,
            'feed_type' => $this->feedType,
            'location' => $this->location ?: (auth()->user()->profile->city ?? null),
            'privacy' => 'public',
            'type' => $this->isPoll ? 'poll' : 'post',
            'poll_expires_at' => $this->isPoll ? now()->addDays((int)$this->pollDuration) : null,
        ]);

        if ($this->isPoll) {
            foreach ($this->pollOptions as $optionText) {
                if (trim($optionText)) {
                    $post->pollOptions()->create(['option_text' => trim($optionText)]);
                }
            }
        }

        $this->reset(['title', 'content', 'photos', 'location', 'isPoll', 'pollOptions']);
        // Re-init poll defaults
        $this->pollOptions = ['', ''];

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
        $postsQuery = Post::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes', 'pollOptions', 'pollVotes']);

        // Fetch Activities
        $activitiesQuery = \App\Models\Activity::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes']);

        if ($this->feed === 'personal') {
            $postsQuery->where('user_id', $user->id);
            $activitiesQuery->where('user_id', $user->id);
        } elseif ($this->feed === 'timeline' || $this->feed === 'network') {
            $followingIds = $user->following()->pluck('users.id')->toArray();
            $followingIds[] = $user->id;
            $postsQuery->whereIn('user_id', $followingIds);
            $activitiesQuery->whereIn('user_id', $followingIds);
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
            ->merge($posts->map(fn($post) => ['type' => 'post', 'item' => $post, 'date' => $post->created_at]))
            ->merge($activities->map(fn($activity) => ['type' => 'activity', 'item' => $activity, 'date' => $activity->start_time]))
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
