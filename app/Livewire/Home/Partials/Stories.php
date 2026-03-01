<?php

namespace App\Livewire\Home\Partials;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Lazy]
class Stories extends Component
{
    use WithFileUploads;

    public $stories;

    public $photo;

    public function placeholder()
    {
        return view('livewire.home.partials.stories-skeleton');
    }

    public function mount()
    {
        $this->refreshStories();
    }

    #[On('echo:timeline,story.posted')]
    public function refreshStories()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // 1. Get IDs of users being followed
        $followingIds = $user->following()->pluck('following_id')->toArray();

        // 2. Fetch users with active stories
        $users = \App\Models\User::whereIn('id', $followingIds)
            ->whereHas('stories', function ($query) {
                $query->where('expires_at', '>', now());
            })
            ->with(['latestStory', 'profile'])
            ->get();

        // 3. Map to stories array
        $this->stories = $users->map(function ($u) {
            $latestStoryUrl = $u->latestStory ? $u->latestStory->image_url : null;

            return [
                'user_id' => $u->id,
                'name' => $u->profile->nickname ?? $u->name,
                'avatar' => $u->image_url,
                'story_image' => $latestStoryUrl,
                'is_own' => false,
                'has_story' => true,
                'profile_url' => $u->profile_url,
            ];
        })->values();
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,webm|max:20480', // 20MB
        ]);

        $path = $this->photo->store('stories', 'public');

        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        $user->stories()->create([
            'image_url' => asset('storage/'.$path),
            'expires_at' => now()->addHours(24),
        ]);

        $this->photo = null;
        $this->refreshStories();

        $this->dispatch('toast', type: 'success', message: 'Story postado com sucesso!');

        broadcast(new \App\Events\StoryPosted(\Illuminate\Support\Facades\Auth::id()))->toOthers();
    }

    public function render()
    {
        return view('livewire.home.partials.stories');
    }
}
