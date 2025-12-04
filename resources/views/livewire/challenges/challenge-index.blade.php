<div>
    <x-common.page-breadcrumb title="Desafios" />

    <div class="rounded-2xl border border-zinc-200 bg-white pt-4 dark:border-zinc-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="text-zinc-500 dark:text-zinc-400">Mostrar</span>
                <div class="relative z-20 bg-transparent">
                    <select wire:model.live="perPage" class="w-full py-2 pl-3 pr-8 text-sm text-zinc-800 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-zinc-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="-1">Todos</option>
                    </select>
                    <span class="absolute z-30 text-zinc-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-zinc-400">
                        <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <span class="text-zinc-500 dark:text-zinc-400">entradas</span>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form>
                    <div class="relative">
                        <span class="absolute -translate-y-1/2 pointer-events-none left-4 top-1/2">
                            <!-- Search Icon -->
                            <svg class="fill-zinc-500 dark:fill-zinc-400" width="20" height="20"
                                viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                                    fill="" />
                            </svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar..."
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-zinc-200 bg-transparent py-2.5 pl-12 pr-14 text-sm text-zinc-800 shadow-theme-xs placeholder:text-zinc-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-800 dark:bg-white/3 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[430px]" />
                        <button
                            class="absolute right-2.5 top-1/2 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-lg border border-zinc-200 bg-zinc-50 px-[7px] py-[4.5px] text-xs -tracking-[0.2px] text-zinc-500 dark:border-zinc-800 dark:bg-white/[0.03] dark:text-zinc-400">
                            <span> ⌘ </span>
                            <span> K </span>
                        </button>
                    </div>
                </form>

                @if ($selected)
                <button wire:click="deleteSelected" class="flex w-full items-center justify-center gap-2 rounded-lg border border-red-300 bg-red-200 px-4 py-[11px] text-sm font-medium text-red-700 shadow-theme-xs dark:border-red-700 dark:bg-red-800 dark:text-zinc-400 sm:w-auto">
                    Deletar Selecionados ({{ count($selected) }})
                </button>
                @endif

                <button wire:click="create"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Novo Desafio
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="max-w-full px-5 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-zinc-200 border-y dark:border-zinc-700">
                        <th scope="col" class="px-4 py-3">
                            <input type="checkbox" wire:model.live="selectAll" class="h-4 w-4 rounded border-zinc-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-zinc-400" />
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            Imagem
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            Título
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            Descrição
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            inicio
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            fim
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            Meta
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            Categorias
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($challenges as $challenge)
                        <tr wire:key="{{ $challenge->id }}">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <input type="checkbox" wire:model.live="selected" value="{{ $challenge->id }}" class="h-4 w-4 rounded border-zinc-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-zinc-400" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                            @if($challenge->image)
                                            <img src="{{ Storage::url($challenge->image) }}" 
                                            alt="{{ $challenge->title }}"
                                            class="h-12 w-12 rounded-lg object-cover">
                                        @else
                                            <div class="h-12 w-12 bg-zinc-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                                <span class="text-zinc-400 text-xs">Sem imagem</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $challenge->title }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ Str::limit($challenge->description, 50) }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $challenge->start_date->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $challenge->end_date->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ number_format($challenge->goal_km, 2, ',', '.') }} km
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if ($challenge->category)
                                    <x-category-badge :color="$challenge->category->color">
                                        {{ $challenge->category->name }}
                                    </x-category-badge>
                                @else
                                    <span class="text-xs text-zinc-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <button wire:click="view({{ $challenge->id }})" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-blue-500 bg-primary/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-eye w-5 h-5">
                                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </button>
                                    <button wire:click="edit({{ $challenge->id }})" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-green-600 bg-green-600/10">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-square-pen w-5 h-5">
                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path
                                                d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $challenge->id }})" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-red-500 bg-red-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trash2 lucide-trash-2 w-5 h-5">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                            <line x1="10" x2="10" y1="11" y2="17"></line>
                                            <line x1="14" x2="14" y1="11" y2="17"></line>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-zinc-500">
                                Nenhum desafio encontrado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="flex items-center flex-col sm:flex-row justify-between border-t border-zinc-200 px-5 py-4 dark:border-zinc-800">
            {{ $challenges->links() }}
        </div>
    </div>
    
    {{-- Create Modal --}}
    @if($showCreateModal)
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50" wire:click="closeCreateModal">
            <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Criar Novo Desafio</h3>
                    <button wire:click="closeCreateModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Título *</label>
                        <input wire:model="title" type="text" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Descrição *</label>
                        <textarea wire:model="description" rows="3" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Data de Início *</label>
                            <input wire:model="start_date" type="date" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Data de Fim *</label>
                            <input wire:model="end_date" type="date" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Meta (KM) *</label>
                            <input wire:model="goal_km" type="number" step="0.01" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                            @error('goal_km') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Categoria *</label>
                            <select wire:model="category_id" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Imagem</label>
                        @if($image)
                            <img src="{{ $image->temporaryUrl() }}" class="h-32 rounded-lg mb-2">
                        @endif
                        <input wire:model="image" type="file" accept="image/*" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="flex items-center">
                            <input wire:model="is_active" type="checkbox" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Desafio ativo</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeCreateModal" class="px-4 py-2 bg-zinc-200 text-zinc-800 rounded-lg hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- View Modal --}}
    @if($showViewModal && $selectedChallenge)
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50" wire:click="closeViewModal">
            <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Detalhes do Desafio</h3>
                    <button wire:click="closeViewModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                @if($selectedChallenge->image)
                    <img src="{{ Storage::url($selectedChallenge->image) }}" alt="{{ $selectedChallenge->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                @endif
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Título</label>
                        <p class="text-zinc-900 dark:text-zinc-100">{{ $selectedChallenge->title }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Descrição</label>
                        <p class="text-zinc-900 dark:text-zinc-100">{{ $selectedChallenge->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Data de Início</label>
                            <p class="text-zinc-900 dark:text-zinc-100">{{ $selectedChallenge->start_date->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Data de Fim</label>
                            <p class="text-zinc-900 dark:text-zinc-100">{{ $selectedChallenge->end_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Meta (KM)</label>
                        <p class="text-zinc-900 dark:text-zinc-100">{{ number_format($selectedChallenge->goal_km, 2, ',', '.') }} km</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Categoria</label>
                        <div class="mt-1">
                            @if($selectedChallenge->category)
                                <x-category-badge :color="$selectedChallenge->category->color">
                                    {{ $selectedChallenge->category->name }}
                                </x-category-badge>
                            @else
                                <span class="text-zinc-500">N/A</span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</label>
                        <p class="text-zinc-900 dark:text-zinc-100">{{ $selectedChallenge->is_active ? 'Ativo' : 'Inativo' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Edit Modal --}}
    @if($showEditModal)
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50" wire:click="closeEditModal">
            <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Editar Desafio</h3>
                    <button wire:click="closeEditModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form wire:submit="update" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Título *</label>
                        <input wire:model="title" type="text" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Descrição *</label>
                        <textarea wire:model="description" rows="3" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Data de Início *</label>
                            <input wire:model="start_date" type="date" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Data de Fim *</label>
                            <input wire:model="end_date" type="date" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Meta (KM) *</label>
                            <input wire:model="goal_km" type="number" step="0.01" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                            @error('goal_km') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Categoria *</label>
                            <select wire:model="category_id" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Imagem</label>
                        @if($image)
                            <img src="{{ $image->temporaryUrl() }}" class="h-32 rounded-lg mb-2">
                        @elseif($existing_image)
                            <img src="{{ Storage::url($existing_image) }}" class="h-32 rounded-lg mb-2">
                        @endif
                        <input wire:model="image" type="file" accept="image/*" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="flex items-center">
                            <input wire:model="is_active" type="checkbox" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Desafio ativo</span>
                        </label>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeEditModal" class="px-4 py-2 bg-zinc-200 text-zinc-800 rounded-lg hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($confirmingDeletion)
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50" wire:click="cancelDelete">
            <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 max-w-md w-full mx-4" wire:click.stop>
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Confirmar Exclusão</h3>
                <p class="text-zinc-500 dark:text-zinc-400 mb-6">Tem certeza que deseja excluir este desafio? Esta ação não pode ser desfeita.</p>
                <div class="flex justify-end gap-3">
                    <button wire:click="cancelDelete" class="px-4 py-2 bg-zinc-200 text-zinc-800 rounded-lg hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200">
                        Cancelar
                    </button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
