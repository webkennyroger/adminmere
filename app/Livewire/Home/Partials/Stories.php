<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class Stories extends Component
{
    public $stories;

    public function placeholder()
    {
        return view('livewire.home.partials.stories-skeleton');
    }

    public function mount()
    {
        $user = auth()->user();

        $followingIds = $user->following()->pluck('following_id')->toArray();
        $followingIds[] = $user->id;

        $this->stories = \App\Models\User::whereIn('id', $followingIds)
            ->whereHas('stories', function ($query) {
                $query->where('expires_at', '>', now());
            })
            ->with(['latestStory', 'profile'])
            ->get()
            ->map(function ($u) use ($user) {
                return [
                    'user_id' => $u->id,
                    'name' => $u->id === $user->id ? 'Seu story' : $u->name,
                    'avatar' => $u->image_url,
                    'story_image' => $u->latestStory->image_url,
                    'is_own' => $u->id === $user->id,
                ];
            });

        if ($this->stories->isEmpty()) {
            $this->stories = collect([
                ['user_id' => 1, 'name' => 'Felix Deo', 'avatar' => 'https://i.pravatar.cc/150?u=1', 'story_image' => 'https://picsum.photos/400/400?random=1', 'is_own' => false],
                ['user_id' => 2, 'name' => 'Jenny Wilson', 'avatar' => 'https://i.pravatar.cc/150?u=2', 'story_image' => 'https://picsum.photos/400/400?random=2', 'is_own' => false],
                ['user_id' => 3, 'name' => 'Freya Davies', 'avatar' => 'https://i.pravatar.cc/150?u=3', 'story_image' => 'https://picsum.photos/400/400?random=3', 'is_own' => false],
                ['user_id' => 4, 'name' => 'Robert Fox', 'avatar' => 'https://i.pravatar.cc/150?u=4', 'story_image' => 'https://picsum.photos/400/400?random=4', 'is_own' => false],
                ['user_id' => 5, 'name' => 'Leslie Alexander', 'avatar' => 'https://i.pravatar.cc/150?u=5', 'story_image' => 'https://picsum.photos/400/400?random=5', 'is_own' => false],
                ['user_id' => 6, 'name' => 'Aaron Jones', 'avatar' => 'https://i.pravatar.cc/150?u=6', 'story_image' => 'https://picsum.photos/400/400?random=6', 'is_own' => false],
                ['user_id' => 7, 'name' => 'Jerry Williams', 'avatar' => 'https://i.pravatar.cc/150?u=7', 'story_image' => 'https://picsum.photos/400/400?random=7', 'is_own' => false],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.home.partials.stories');
    }
}
