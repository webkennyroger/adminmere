<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public $showModal = false;
    public $isEditMode = false;
    public $userId;

    public $selected = [];
    public $selectAll = false;

    public $name = '';
    public $email = '';
    public $password = '';
    public $phone = '';
    public $city = '';
    public $state = '';
    public $image;
    public $currentImage;
    
    // Social Media
    public $mere = '';
    public $instagram = '';
    public $x = '';
    public $facebook = '';
    public $youtube = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->isEditMode ? 'nullable|min:6' : 'required|min:6',
            'phone' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'image' => 'nullable|image|max:1024', // 1MB Max
            'mere' => 'nullable|string',
            'instagram' => 'nullable|string',
            'x' => 'nullable|string',
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string',
        ];
    }

    public function deleteSelected()
    {
        User::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('message', 'Users deleted successfully.');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $perPage = $this->perPage == -1 ? 100000 : $this->perPage;

            $this->selected = User::where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->paginate($perPage)
                ->pluck('id')
                ->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedSelected()
    {
        $perPage = $this->perPage == -1 ? 100000 : $this->perPage;

        $visibleIds = User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate($perPage)
            ->pluck('id')
            ->toArray();

        $this->selectAll = !empty($visibleIds) && count(array_intersect($visibleIds, $this->selected)) === count($visibleIds);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'phone', 'city', 'state', 'image', 'currentImage', 'mere', 'instagram', 'x', 'facebook', 'youtube', 'userId']);
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->city = $user->city;
        $this->state = $user->state;
        $this->currentImage = $user->image ? \Storage::url($user->image) : null;
        
        $this->mere = $user->mere;
        $this->instagram = $user->instagram;
        $this->x = $user->x;
        $this->facebook = $user->facebook;
        $this->youtube = $user->youtube;

        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => \Hash::make($this->password),
            'phone' => $this->phone,
            'city' => $this->city,
            'state' => $this->state,
            'mere' => $this->mere,
            'instagram' => $this->instagram,
            'x' => $this->x,
            'facebook' => $this->facebook,
            'youtube' => $this->youtube,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('profile-photos', 'public');
        }

        User::create($data);

        $this->showModal = false;
        session()->flash('message', 'User created successfully.');
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'state' => $this->state,
            'mere' => $this->mere,
            'instagram' => $this->instagram,
            'x' => $this->x,
            'facebook' => $this->facebook,
            'youtube' => $this->youtube,
        ];

        if ($this->password) {
            $data['password'] = \Hash::make($this->password);
        }

        if ($this->image) {
            $data['image'] = $this->image->store('profile-photos', 'public');
        }

        $user->update($data);

        $this->showModal = false;
        session()->flash('message', 'User updated successfully.');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {

        $perPage = $this->perPage == -1 ? 100000 : $this->perPage;

        $users = User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate($perPage);

        return view('livewire.users.index', [
            'users' => $users,
        ])->title('Users');
    }
}
