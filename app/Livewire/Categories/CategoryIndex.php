<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CategoryIndex extends Component
{
    use WithPagination;

    // Propriedades para o formulário de criação/edição
    public ?Category $editing = null;
    public string $name = '';
    public string $color = 'zinc';
    public string $description = '';

    // Controle dos modais
    public bool $showModal = false;
    public bool $confirmingDeletion = false;
    public ?Category $categoryToDelete = null;

    // Propriedades para busca e paginação
    public string $search = '';
    public int $perPage = 10;

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Propriedades para seleção
    public $selected = [];
    public bool $selectAll = false;

    // Cores disponíveis para seleção
    public array $availableColors = [
        'zinc' => 'Cinza',
        'red' => 'Vermelho',
        'orange' => 'Laranja',
        'amber' => 'Âmbar',
        'yellow' => 'Amarelo',
        'lime' => 'Lima',
        'green' => 'Verde',
        'emerald' => 'Esmeralda',
        'teal' => 'Verde-azulado',
        'cyan' => 'Ciano',
        'sky' => 'Céu',
        'blue' => 'Azul',
        'indigo' => 'Índigo',
        'violet' => 'Violeta',
        'purple' => 'Roxo',
        'fuchsia' => 'Fúcsia',
        'pink' => 'Rosa',
        'rose' => 'Rosé',
    ];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . ($this->editing ? $this->editing->id : 'NULL')],
            'color' => ['required', 'string', 'in:' . implode(',', array_keys($this->availableColors))],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected $messages = [
        'name.required' => 'O nome da categoria é obrigatório',
        'name.unique' => 'Já existe uma categoria com este nome',
        'color.required' => 'Selecione uma cor para a categoria',
    ];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $perPage = $this->perPage == -1 ? 100000 : $this->perPage;

            $this->selected = Category::where('name', 'like', '%' . $this->search . '%')
                ->latest()
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

        $visibleIds = Category::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($perPage)
            ->pluck('id')
            ->toArray();

        $this->selectAll = !empty($visibleIds) && count(array_intersect($visibleIds, $this->selected)) === count($visibleIds);
    }

    public function deleteSelected()
    {
        $categories = Category::withCount('challenges')->find($this->selected);

        $deletable = $categories->where('challenges_count', 0);
        $undeletableCount = $categories->count() - $deletable->count();

        if ($deletable->isNotEmpty()) {
            Category::whereIn('id', $deletable->pluck('id'))->delete();
            session()->flash('message', $deletable->count() . ' categorias foram excluídas com sucesso!');
        }

        if ($undeletableCount > 0) {
            session()->flash('error', $undeletableCount . ' categorias não puderam ser excluídas por terem desafios associados.');
        }

        $this->selected = [];
        $this->selectAll = false;
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(Category $category)
    {
        $this->resetErrorBag();
        $this->editing = $category;
        $this->name = $category->name;
        $this->color = $category->color;
        $this->description = $category->description ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'color' => $this->color,
            'description' => $this->description,
            'is_active' => true,
        ];

        if ($this->editing) {
            $this->editing->update($data);
            session()->flash('message', 'Categoria atualizada com sucesso!');
        } else {
            Category::create($data);
            session()->flash('message', 'Categoria criada com sucesso!');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete(Category $category)
    {
        $this->categoryToDelete = $category;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if ($this->categoryToDelete) {
            // Verificar se há desafios usando esta categoria
            if ($this->categoryToDelete->challenges()->count() > 0) {
                session()->flash('error', 'Não é possível excluir esta categoria pois existem desafios associados a ela.');
                $this->confirmingDeletion = false;
                return;
            }

            $this->categoryToDelete->delete();
            session()->flash('message', 'Categoria excluída com sucesso!');
        }
        
        $this->confirmingDeletion = false;
        $this->categoryToDelete = null;
    }

    private function resetForm()
    {
        $this->resetErrorBag();
        $this->editing = null;
        $this->name = '';
        $this->description = '';
        $this->color = 'zinc';
    }

    public function render()
    {
        $perPage = $this->perPage == -1 ? 100000 : $this->perPage;

        $query = Category::withCount('challenges');
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return view('livewire.categories.category-index', [
            'categories' => $query->latest()->paginate($perPage),
        ]);
    }
}