<?php

namespace App\Livewire\Challenges;

use App\Models\Category;
use App\Models\Challenge;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChallengeCreate extends Component
{
    use WithFileUploads;

    public $title;

    public $description;

    public $start_date;

    public $end_date;

    public $goal_km;

    public $category_id;

    public $image;

    public $is_active = true;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'goal_km' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'title.required' => 'O título é obrigatório',
        'description.required' => 'A descrição é obrigatória',
        'start_date.required' => 'A data de início é obrigatória',
        'end_date.required' => 'A data de fim é obrigatória',
        'end_date.after' => 'A data de fim deve ser posterior à data de início',
        'goal_km.required' => 'A meta em km é obrigatória',
        'goal_km.min' => 'A meta deve ser maior que zero',
        'category_id.required' => 'Selecione uma categoria',
        'image.image' => 'O arquivo deve ser uma imagem',
        'image.max' => 'A imagem não pode ter mais de 2MB',
    ];

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('challenges', 'public');
        }

        Challenge::create([
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'goal_km' => $this->goal_km,
            'category_id' => $this->category_id,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Desafio criado com sucesso!']);

        return redirect()->route('admin.challenges.index');
    }

    public function render()
    {
        return view('livewire.challenges.challenge-create', [
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }
}
