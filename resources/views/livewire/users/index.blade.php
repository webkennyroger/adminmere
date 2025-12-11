<div>
    <x-common.page-breadcrumb title="Usuários" />

    <div class="rounded-2xl border border-zinc-200 bg-white pt-4 dark:border-zinc-800 dark:bg-white/3">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="text-zinc-500 dark:text-zinc-400">Mostrar</span>
                <div class="relative z-20 bg-transparent">
                    <select wire:model.live="perPage"
                        class="w-full py-2 pl-3 pr-8 text-sm text-zinc-800 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-zinc-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="-1">Todos</option>
                    </select>
                    <span
                        class="absolute z-30 text-zinc-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-zinc-400">
                        <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke="" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <span class="text-zinc-500 dark:text-zinc-400">entradas</span>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative">
                    <button class="absolute text-zinc-500 -translate-y-1/2 left-4 top-1/2 dark:text-zinc-400">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z"
                                fill=""></path>
                        </svg>
                    </button>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search..."
                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-zinc-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-zinc-800 shadow-theme-xs placeholder:text-zinc-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                </div>

                @if (count($selected) > 0)
                    <button wire:click="deleteSelected"
                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-red-300 bg-red-200 px-4 py-[11px] text-sm font-medium text-red-700 shadow-theme-xs dark:border-red-700 dark:bg-red-800 dark:text-zinc-400 sm:w-auto">
                        Deletar Selecionados ({{ count($selected) }})
                    </button>
                @endif

                <button wire:click="create"
                    class="bg-green-600 hover:bg-green-500 text-white rounded-lg h-9 px-4 py-2 text-sm font-medium transition-colors">
                    Nova Usuário
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden">
            <div class="max-w-full px-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-zinc-200 border-y dark:border-zinc-700">
                            <th scope="col" class="w-12 px-4 py-3">
                                <x-form.checkbox wire:model.live="selectAll" />
                            </th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Nome
                            </th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Plano
                            </th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Email
                            </th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Telefone
                            </th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Cidade
                            </th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Status
                            </th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Ação
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">

                        @foreach ($users as $user)
                            <tr wire:key="{{ $user->id }}">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <x-form.checkbox wire:model.live="selected" value="{{ $user->id }}" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $user->profile?->image ? Storage::url($user->profile->image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                                alt="{{ $user->name }}" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($user->profile?->plan ?? 'free') === 'free' ? 'bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                        {{ ($user->profile?->plan ?? 'free') === 'free' ? 'Gratuito' : 'Assinante' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $user->profile?->phone ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        @if($user->profile?->city)
                                            {{ $user->profile->city }}{{ $user->profile->state ? ' / ' . $user->profile->state : '' }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <button wire:click="toggleStatus({{ $user->id }})"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 {{ ($user->profile?->status ?? 'active') === 'active' ? 'bg-brand-600' : 'bg-zinc-200 dark:bg-zinc-700' }}"
                                        role="switch"
                                        aria-checked="{{ ($user->profile?->status ?? 'active') === 'active' ? 'true' : 'false' }}">
                                        <span class="sr-only">Use setting</span>
                                        <span
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ ($user->profile?->status ?? 'active') === 'active' ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('users.show', $user->id) }}"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-blue-500 bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-eye w-5 h-5">
                                                <path
                                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                                </path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                        <button wire:click="edit({{ $user->id }})"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-green-600 bg-green-600/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-square-pen w-5 h-5">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path
                                                    d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $user->id }})"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-red-500 bg-red-500/10">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            {{ $users->links('components.pagination.custom') }}
        </div>
    </div>
    {{-- Create / Edit Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50"
            wire:click="closeModal" x-transition>
            <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto"
                wire:click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ $isEditMode ? 'Editar Usuário' : 'Novo Usuário' }}
                    </h3>
                    <button wire:click="closeModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form wire:submit="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-6">

                    <!-- Tabs or Sections -->
                    <div class="space-y-4">
                        <h4
                            class="font-medium text-lg text-zinc-800 dark:text-zinc-200 border-b pb-2 border-zinc-200 dark:border-zinc-700">
                            Informações Pessoais</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Nome
                                    *</label>
                                <input wire:model="name" type="text"
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Email
                                    *</label>
                                <input wire:model="email" type="email"
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    {{ $isEditMode ? 'Senha (deixe em branco para manter)' : 'Senha *' }}
                                </label>
                                <input wire:model="password" type="password"
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Telefone</label>
                                <input wire:model="phone" type="text"
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Cidade</label>
                                <input wire:model="city" type="text"
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- State -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Estado</label>
                                <input wire:model="state" type="text"
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            @if(auth()->user()->isSuperAdmin())
                                <!-- Role -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Função
                                        (Role)</label>
                                    <select wire:model="role"
                                        class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                        <option value="user">Usuário</option>
                                        <option value="manager">Gerenciador</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                    @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Plan -->
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Plano
                                        (Assinatura)</label>
                                    <select wire:model="plan"
                                        class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                        <option value="free">Gratuito</option>
                                        <option value="monthly">Mensal</option>
                                        <option value="annual">Anual</option>
                                    </select>
                                    @error('plan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Foto de
                                Perfil</label>
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover mb-2">
                            @elseif ($currentImage)
                                <img src="{{ $currentImage }}" class="w-20 h-20 rounded-full object-cover mb-2">
                            @endif
                            <x-form.file-input wire:model="image" id="user_profile_image" accept="image/*" />
                            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <h4
                            class="font-medium text-lg text-zinc-800 dark:text-zinc-200 border-b pb-2 border-zinc-200 dark:border-zinc-700 pt-4">
                            Redes Sociais</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Instagram -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Instagram</label>
                                <input wire:model="instagram" type="text" placeholder="https://instagram.com/..."
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('instagram') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Facebook -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Facebook</label>
                                <input wire:model="facebook" type="text" placeholder="https://facebook.com/..."
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('facebook') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- X -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">X
                                    (Twitter)</label>
                                <input wire:model="x" type="text" placeholder="https://x.com/..."
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('x') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Youtube -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Youtube</label>
                                <input wire:model="youtube" type="text" placeholder="https://youtube.com/..."
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('youtube') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Mere -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Mere (Link
                                    Extra)</label>
                                <input wire:model="mere" type="text"
                                    class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                                @error('mere') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-zinc-200 text-zinc-800 rounded-lg hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            {{ $isEditMode ? 'Salvar Alterações' : 'Criar Usuário' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal de Confirmação de Exclusão --}}
    @if($confirmingDeletion)
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50"
            wire:click="$set('confirmingDeletion', false)">
            <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 max-w-md w-full mx-4" wire:click.stop>
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Confirmar Exclusão</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                            Tem certeza que deseja excluir o usuário "<strong>{{ $userToDelete?->name }}</strong>"? Esta
                            ação não pode ser desfeita.
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-5">
                    <button type="button" wire:click="$set('confirmingDeletion', false)"
                        class="px-4 py-2 bg-zinc-200 text-zinc-800 rounded-lg hover:bg-zinc-300">
                        Cancelar
                    </button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Sim, Excluir
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>