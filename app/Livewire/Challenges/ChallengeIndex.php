<?php

namespace App\Livewire\Challenges;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Category;

class ChallengeIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $selected = [];
    public $selectAll = false;

    // Modal states
    public $showViewModal = false;
    public $showEditModal = false;
    public $showCreateModal = false;
    public $confirmingDeletion = false;
    
    // Challenge data
    public $selectedChallenge = null;

    public $challengeId;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $goal_km;
    public $category_id;
    public $image;
    public $existing_image;
    public $is_active = true;

    protected $queryString = ['search'];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Challenge::when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->all();
        } else {
            $this->selected = [];
        }
    }

    public function deleteSelected()
    {
        Challenge::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('message', 'Desafios selecionados foram excluídos com sucesso!');
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'goal_km' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function view($id)
    {
        $this->selectedChallenge = Challenge::with('category')->findOrFail($id);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedChallenge = null;
    }

    public function edit($id)
    {
        $challenge = Challenge::findOrFail($id);
        
        $this->challengeId = $challenge->id;
        $this->title = $challenge->title;
        $this->description = $challenge->description;
        $this->start_date = $challenge->start_date->format('Y-m-d');
        $this->end_date = $challenge->end_date->format('Y-m-d');
        $this->goal_km = $challenge->goal_km;
        $this->category_id = $challenge->category_id;
        $this->existing_image = $challenge->image;
        $this->is_active = $challenge->is_active;
        
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate();

        $challenge = Challenge::findOrFail($this->challengeId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'goal_km' => $this->goal_km,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('challenges', 'public');
        }

        $challenge->update($data);

        $this->showEditModal = false;
        $this->reset(['challengeId', 'title', 'description', 'start_date', 'end_date', 'goal_km', 'category_id', 'image', 'existing_image', 'is_active']);
        
        session()->flash('message', 'Desafio atualizado com sucesso!');
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['challengeId', 'title', 'description', 'start_date', 'end_date', 'goal_km', 'category_id', 'image', 'existing_image', 'is_active']);
        $this->resetValidation();
    }

    public function confirmDelete($id)
    {
        $this->challengeId = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if ($this->challengeId) {
            Challenge::findOrFail($this->challengeId)->delete();
            $this->confirmingDeletion = false;
            $this->challengeId = null;
            session()->flash('message', 'Desafio excluído com sucesso!');
        }
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->challengeId = null;
    }

    public function create()
    {
        $this->reset(['challengeId', 'title', 'description', 'start_date', 'end_date', 'goal_km', 'category_id', 'image', 'existing_image', 'is_active']);
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'goal_km' => $this->goal_km,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('challenges', 'public');
        }

        Challenge::create($data);

        $this->showCreateModal = false;
        $this->reset(['challengeId', 'title', 'description', 'start_date', 'end_date', 'goal_km', 'category_id', 'image', 'existing_image', 'is_active']);
        
        session()->flash('message', 'Desafio criado com sucesso!');
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function render()
    {
        $challenges = Challenge::with('category')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        $categories = Category::orderBy('name')->get();

        return view('livewire.challenges.challenge-index', [
            'challenges' => $challenges,
            'categories' => $categories,
        ]);
    }
}