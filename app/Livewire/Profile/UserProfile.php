<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    use WithFileUploads;

    public $user;
    
    // Personal Info
    public $name = '';
    public $last_name = '';
    public $nickname = '';
    public $email = '';
    public $phone = '';
    public $image; // Uploaded image
    
    // Address
    public $address = '';
    public $city = '';
    public $state = '';
    public $zip_code = '';

    // Social Media
    public $instagram = '';
    public $facebook = '';
    public $x = '';
    public $youtube = '';
    public $tiktok = '';
    public $mere = '';

    public function mount($user = null)
    {
        $this->user = $user ?? Auth::user();
        $this->loadData();
    }

    public function loadData()
    {
        // Personal
        $this->name = $this->user->name ?? '';
        $this->last_name = $this->user->profile?->last_name ?? '';
        $this->nickname = $this->user->profile?->nickname ?? '';
        $this->email = $this->user->email ?? '';
        $this->phone = $this->user->profile?->phone ?? '';
        
        // Address
        $this->address = $this->user->profile?->address ?? '';
        $this->city = $this->user->profile?->city ?? '';
        $this->state = $this->user->profile?->state ?? '';
        $this->zip_code = $this->user->profile?->zip_code ?? '';

        // Social
        $this->instagram = $this->user->profile?->instagram ?? '';
        $this->facebook = $this->user->profile?->facebook ?? '';
        $this->x = $this->user->profile?->x ?? '';
        $this->youtube = $this->user->profile?->youtube ?? '';
        $this->tiktok = $this->user->profile?->tiktok ?? '';
        $this->mere = $this->user->profile?->mere ?? '';
    }

    public function updateProfileInformation()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user->id)
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        $this->user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($this->user->isDirty('email')) {
            $this->user->email_verified_at = null;
        }

        $this->user->save();
        
        $profileData = [
            'phone' => $validated['phone'],
            'last_name' => $validated['last_name'],
            'nickname' => $validated['nickname'],
        ];

        if ($this->image) {
            $profileData['image'] = $this->image->store('profile-photos', 'public');
        }

        $this->updateProfile($profileData);

        $this->dispatch('profile-updated', name: $this->user->name);
        $this->dispatch('close-profile-info-modal');
        $this->refreshUser();
        $this->image = null;
    }

    public function saveAddress()
    {
        $validated = $this->validate([
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:20'],
        ]);

        $this->updateProfile($validated);

        $this->dispatch('profile-updated');
        $this->dispatch('close-profile-address-modal');
        $this->refreshUser();
    }

    public function updateSocialMedia()
    {
        $validated = $this->validate([
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'x' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'mere' => ['nullable', 'string', 'max:255'],
        ]);

        $this->updateProfile($validated);

        $this->dispatch('profile-updated');
        $this->dispatch('close-profile-social-modal');
        $this->refreshUser();
    }

    protected function updateProfile(array $data)
    {
        if ($this->user->profile) {
            $this->user->profile->update($data);
        } else {
            $this->user->profile()->create($data);
        }
    }

    protected function refreshUser()
    {
        $this->user = $this->user->fresh('profile');
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.profile.user-profile');
    }
}
