<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PersonalInfoCard extends Component
{
    use WithFileUploads;

    public $user;
    public string $name = '';
    public string $last_name = '';
    public string $nickname = '';
    public string $email = '';
    public string $phone = '';
    public $image;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->last_name = $this->user->profile?->last_name ?? '';
        $this->nickname = $this->user->profile?->nickname ?? '';
        $this->phone = $this->user->profile?->phone ?? '';
    }

    public function updateProfileInformation(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'last_name' => ['nullable', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'image' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ]);

        $this->user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($this->user->isDirty('email')) {
            $this->user->email_verified_at = null;
        }

        $this->user->save();

        if ($this->image) {
            $path = $this->image->store('profile-photos', 'public');
            $this->user->profile()->updateOrCreate(
                ['user_id' => $this->user->id],
                ['image' => $path]
            );
        }

        $this->user->profile()->updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'last_name' => $validated['last_name'],
                'nickname' => $validated['nickname'],
                'phone' => $validated['phone'],
            ]
        );

        $this->dispatch('profile-updated');
        $this->dispatch('close-profile-info-modal');
    }

    public function render()
    {
        return view('livewire.profile.personal-info-card');
    }
}
