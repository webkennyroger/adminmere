<?php

namespace App\Livewire\Home\Partials;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

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
    #[On('echo:timeline,like.toggled')]
    #[On('echo:timeline,comment.posted')]
    #[On('echo:timeline,save.toggled')]
    public function refreshFeed(): void
    {
        $this->page = 1;
        $this->hasMore = true;
    }

    public function render()
    {
        $user = auth()->user();

        // Posts Query
        $postsQuery = Post::query()->with(['user', 'likes', 'comments', 'pollOptions', 'pollVotes', 'savedItems']);

        // Activities Query
        $activitiesQuery = \App\Models\Activity::query()->with(['user', 'likes', 'comments', 'savedItems']);

        if ($this->feed === 'timeline' || $this->feed === 'network' || $this->feed === 'community') {
            if ($this->feed === 'community') {
                $postsQuery->where(fn ($q) => $q->where('feed_type', 'community')->orWhere('privacy', 'public'));
                $activitiesQuery->where(fn ($q) => $q->where('feed_type', 'community')->where('privacy', 'public')->orWhere('user_id', $user->id));
            } else {
                $followingIds = $user->following()->pluck('following_id')->toArray();
                $followingIds[] = $user->id;

                $postsQuery->where(function ($q) use ($followingIds, $user) {
                    $q->whereIn('user_id', $followingIds)->where('privacy', 'public')
                        ->orWhere('user_id', $user->id);
                });

                $activitiesQuery->where(function ($q) use ($followingIds, $user) {
                    $q->whereIn('user_id', $followingIds)->where('privacy', 'public')
                        ->orWhere('user_id', $user->id);
                });
            }
        } elseif ($this->feed === 'personal') {
            $savedPostsIds = \App\Models\SavedItem::where('user_id', $user->id)
                ->where('saved_item_type', Post::class)
                ->pluck('saved_item_id');

            $savedActivitiesIds = \App\Models\SavedItem::where('user_id', $user->id)
                ->where('saved_item_type', \App\Models\Activity::class)
                ->pluck('saved_item_id');

            $postsQuery->where(function ($q) use ($user, $savedPostsIds) {
                $q->where('user_id', $user->id)->orWhereIn('id', $savedPostsIds);
            });
            $activitiesQuery->where(function ($q) use ($user, $savedActivitiesIds) {
                $q->where('user_id', $user->id)->orWhereIn('id', $savedActivitiesIds);
            });
        }

        // Fetch enough to cover the current page + some buffer
        $limit = max(100, $this->perPage * $this->page + 20);
        $posts = $postsQuery->latest()->limit($limit)->get();
        $activities = $activitiesQuery->latest('start_time')->limit($limit)->get();

        // Merge and sort
        $items = collect([])
            ->merge($posts->map(fn ($post) => [
                'type' => 'post',
                'item' => $post,
                'date' => $post->created_at?->toDateTimeString() ?? now()->toDateTimeString(),
            ]))
            ->merge($activities->map(fn ($activity) => [
                'type' => 'activity',
                'item' => $activity,
                'date' => $activity->start_time?->toDateTimeString() ?? ($activity->created_at?->toDateTimeString() ?? now()->toDateTimeString()),
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
