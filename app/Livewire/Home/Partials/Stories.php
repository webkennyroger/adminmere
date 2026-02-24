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
    }

    public function render()
    {
        return view('livewire.home.partials.stories');
    }
}
