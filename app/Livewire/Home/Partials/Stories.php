<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;
use Livewire\Attributes\Lazy;

use Livewire\Attributes\On;
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
        $user = auth()->user();
        


        // 1. Get IDs of users being followed
        $followingIds = $user->following()->pluck('following_id')->toArray();
        $baseUserIds = array_merge($followingIds, [$user->id]);
        
        // 2. Fetch users
        $users = \App\Models\User::whereIn('id', $baseUserIds)
            ->with(['latestStory', 'profile'])
            ->get();

        // 3. Fallback: if very few users, suggest some random ones to make it look full and lively
        if ($users->count() < 6) {
            $suggestedUsers = \App\Models\User::whereNotIn('id', $baseUserIds)
                ->with(['latestStory', 'profile'])
                ->inRandomOrder()
                ->limit(6 - $users->count())
                ->get();
            
            $users = $users->concat($suggestedUsers);
        }

        // 3. Map to stories array
        $this->stories = $users->map(function ($u) use ($user) {
            $hasActiveStory = $u->latestStory && $u->latestStory->expires_at->isFuture();
            
            return [
                'user_id' => $u->id,
                'name' => $u->id === $user->id ? 'Meu Story' : ($u->profile->nickname ?? $u->name),
                'avatar' => $u->image_url,
                'story_image' => $hasActiveStory 
                    ? $u->latestStory->image_url 
                    : ($u->profile?->cover_image ? asset('storage/'.$u->profile->cover_image) : 'https://images.unsplash.com/photo-1506744626753-dba37c25a1f1?w=300&h=400&fit=crop'),
                'is_own' => $u->id === $user->id,
                'has_story' => $hasActiveStory,
                'profile_url' => $u->profile_url,
            ];
        })->sortByDesc('has_story')->values();
    }


    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:10240', // 10MB
        ]);

        $path = $this->photo->store('stories', 'public');

        auth()->user()->stories()->create([
            'image_url' => asset('storage/' . $path),
            'expires_at' => now()->addHours(24),
        ]);

        $this->photo = null;
        $this->refreshStories();
        
        $this->dispatch('toast', type: 'success', message: 'Story postado com sucesso!');
        
        broadcast(new \App\Events\StoryPosted(auth()->id()))->toOthers();
    }

    public function render()
    {
        return view('livewire.home.partials.stories');
    }
}

