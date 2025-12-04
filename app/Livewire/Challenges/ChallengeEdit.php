<?php

namespace App\Livewire\Challenges;

use App\Models\Category;
use App\Models\Challenge;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ChallengeEdit extends Component
{
    use WithFileUploads;

    public Challenge $challenge;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $goal_km;
    public $category_id;
    public $image;
    public $existing_image;
    public $is_active;
    public $confirmingDeletion = false;
    public $confirmingImageRemoval = false;

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

    public function mount(Challenge $challenge)
    {
        $this->challenge = $challenge;
        $this->title = $challenge->title;
        $this->description = $challenge->description;
        $this->start_date = $challenge->start_date->format('Y-m-d');
        $this->end_date = $challenge->end_date->format('Y-m-d');
        $this->goal_km = $challenge->goal_km;
        $this->category_id = $challenge->category_id;
        $this->existing_image = $challenge->image;
        $this->is_active = $challenge->is_active;
    }

    /**
     * Confirma a remoção da imagem
     */
    public function confirmRemoveImage()
    {
        $this->confirmingImageRemoval = true;
    }

    /**
     * Cancela a remoção da imagem
     */
    public function cancelRemoveImage()
    {
        $this->confirmingImageRemoval = false;
    }

    /**
     * Remove a imagem atual do desafio
     */
    public function removeImage()
    {
        if ($this->existing_image) {
            // Deleta a imagem do storage
            Storage::disk('public')->delete($this->existing_image);
            
            // Atualiza o banco de dados
            $this->challenge->update(['image' => null]);
            
            // Limpa as variáveis locais
            $this->existing_image = null;
            $this->image = null;
            
            // Fecha o modal
            $this->confirmingImageRemoval = false;
            
            session()->flash('message', 'Imagem removida com sucesso!');
        }
    }

    /**
     * Confirma a exclusão do desafio
     */
    public function confirmDelete()
    {
        $this->confirmingDeletion = true;
    }

    /**
     * Cancela a exclusão
     */
    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
    }

    /**
     * Deleta o desafio
     */
    public function delete()
    {
        // Deleta a imagem se existir
        if ($this->challenge->image) {
            Storage::disk('public')->delete($this->challenge->image);
        }

        // Deleta o desafio
        $this->challenge->delete();

        session()->flash('message', 'Desafio excluído com sucesso!');
        
        return redirect()->route('challenges.index');
    }

    /**
     * Atualiza o desafio
     */
    public function update()
    {
        $this->validate();

        $imagePath = $this->existing_image;

        // Se uma nova imagem foi enviada
        if ($this->image) {
            // Deleta a imagem antiga se existir
            if ($this->existing_image) {
                Storage::disk('public')->delete($this->existing_image);
            }
            
            // Salva a nova imagem
            $imagePath = $this->image->store('challenges', 'public');
        }

        // Atualiza o desafio
        $this->challenge->update([
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'goal_km' => $this->goal_km,
            'category_id' => $this->category_id,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Desafio atualizado com sucesso!');
        
        return redirect()->route('challenges.index');
    }

    /**
     * Listener para quando a imagem for atualizada
     * Isso permite preview em tempo real
     */
    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048',
        ]);
    }

    public function render()
    {
        return view('livewire.challenges.challenge-edit', [
            'categories' => Category::where('is_active', true)->get()
        ]);
    }
}