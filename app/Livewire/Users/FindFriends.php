<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class FindFriends extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $city = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCity()
    {
        $this->resetPage();
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->where('id', '!=', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->when($this->city, function ($query) {
                $query->whereHas('profile', function ($q) {
                    $q->where('city', 'like', '%'.$this->city.'%');
                });
            })
            ->with(['profile'])
            ->paginate(12);
    }

    public function follow($userId)
    {
        $userToFollow = User::find($userId);

        if ($userToFollow) {
            Auth::user()->follow($userToFollow);
            $userToFollow->notify(new \App\Notifications\NewFollower(Auth::user()));
            // $this->dispatch('friend-followed'); // Optional feedback
        }
    }

    public function unfollow($userId)
    {
        $userToFollow = User::find($userId);

        if ($userToFollow) {
            Auth::user()->unfollow($userToFollow);
        }
    }

    public function render()
    {
        return view('livewire.users.find-friends');
    }
}
