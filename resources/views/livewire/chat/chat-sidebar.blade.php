```html
<div>
    <!-- Mobile Backdrop -->
    <div x-show="$store.chatSidebar.isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="$store.chatSidebar.close()"
        class="fixed inset-0 bg-black/50 z-[60] md:hidden">
    </div>

    <!-- Sidebar Container -->
    <div 
        :class="$store.chatSidebar.isOpen ? 'translate-x-0 w-full md:w-80' : 'translate-x-full md:translate-x-0 md:w-20'"
        class="fixed right-0 top-0 md:top-16 h-full md:h-[calc(100vh-4rem)] bg-white dark:bg-zinc-900 shadow-xl z-[70] md:z-40 flex flex-col border-l border-zinc-200 dark:border-zinc-800 transition-all duration-300 transform">

        <!-- Mobile Header (Close Button) -->
        <div class="md:hidden p-4 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center bg-white dark:bg-zinc-900">
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Chat</h2>
            <button @click="$store.chatSidebar.close()" class="p-2 text-zinc-500 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Header Section -->
        <div class="p-4 mt-2 md:mt-5 flex flex-col gap-4 shrink-0" :class="$store.chatSidebar.isOpen ? 'items-stretch' : 'items-center'">
            
            <!-- Toggle & Title (Hidden on Mobile as we have custom header) -->
            <div class="hidden md:flex items-center justify-between">
                <h2 x-show="$store.chatSidebar.isOpen" x-transition class="text-lg font-semibold text-zinc-900 dark:text-white whitespace-nowrap">
                    Contatos
                </h2>
                <button @click="$store.chatSidebar.toggle()"
                    class="p-2 text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Search Input (Only when open) -->
            <div x-show="$store.chatSidebar.isOpen" x-transition class="relative bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                 <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live="search" type="text" placeholder="Procurar..." 
                    class="bg-transparent border-none w-full pl-9 py-2 text-sm text-zinc-700 dark:text-zinc-200 placeholder-zinc-400 focus:ring-0">
            </div>
        </div>

        <!-- Users List -->
        <div class="flex-1 w-full overflow-y-auto overflow-x-hidden flex flex-col space-y-2 scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-700"
            :class="$store.chatSidebar.isOpen ? 'items-stretch px-2' : 'items-center px-0'">
            
            @forelse($users as $user)
                <div wire:key="sidebar-user-{{ $user->id }}" wire:click="openChat({{ $user->id }}); if(window.innerWidth < 768) $store.chatSidebar.close()"
                    class="relative group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 rounded-xl transition-all flex items-center shrink-0"
                    :class="$store.chatSidebar.isOpen ? 'p-2 gap-3 justify-start' : 'p-2 justify-center'"
                    title="{{ $user->name }}">
                    
                    <!-- Avatar & Status -->
                    <div class="relative shrink-0">
                        <img src="{{ $user->profile?->image ? Storage::url($user->profile->image) : $user->image_url }}"
                            alt="{{ $user->name }}"
                            class="rounded-full object-cover ring-2 ring-transparent group-hover:ring-brand-500 transition-all"
                            :class="$store.chatSidebar.isOpen ? 'w-10 h-10' : 'w-10 h-10'">
                        
                        <!-- Online Status Dot -->
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-zinc-900 rounded-full"></span>

                        <!-- Unread Badge for Collapsed Mode -->
                        @if($user->unread_count > 0)
                            <div x-show="!$store.chatSidebar.isOpen" 
                                class="absolute -top-1 -right-1 w-4 h-4 flex items-center justify-center bg-red-500 text-white text-[9px] font-bold rounded-full border border-white dark:border-zinc-900 shadow-sm z-10 transition-all">
                                {{ $user->unread_count }}
                            </div>
                        @endif
                    </div>

                    <!-- Text Info (Only when open) -->
                    <div x-show="$store.chatSidebar.isOpen" x-transition class="flex flex-col flex-1 min-w-0 overflow-hidden">
                        <div class="flex justify-between items-baseline">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                {{ $user->name }}
                            </h4>
                            <span class="text-[10px] text-zinc-400 shrink-0 ml-2">
                                 {{ $user->last_message ? $user->last_message->created_at->format('H:i') : '' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center mt-0.5">
                            <p class="text-xs text-zinc-500 truncate pr-2">
                                 {{ $user->last_message ? $user->last_message->content : 'Inicie uma conversa' }}
                            </p>
                            
                            <div class="flex items-center gap-1">
                                 @if($user->unread_count > 0)
                                    <span class="flex items-center justify-center min-w-5 h-5 px-1.5 text-[10px] font-bold text-white bg-green-500 rounded-full">
                                        {{ $user->unread_count }}
                                    </span>
                                @endif

                                <!-- Archive Action (Hover) -->
                                <button wire:click.stop="toggleUserArchive({{ $user->id }})" 
                                    class="opacity-0 group-hover:opacity-100 shrink-0 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all"
                                    title="{{ $user->is_archived ? 'Desarquivar' : 'Arquivar' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($user->is_archived)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        @endif
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-zinc-500 text-xs py-4" x-show="$store.chatSidebar.isOpen">
                    Nenhum usuário
                </div>
            @endforelse

            <!-- Divider -->
            @if(count($users) > 0 && count($groups) > 0)
                <div class="shrink-0 h-px bg-zinc-200 dark:bg-zinc-700 my-2" :class="$store.chatSidebar.isOpen ? 'w-full' : 'w-8'"></div>
            @endif

            <!-- Groups Header (Only when open) -->
            <div x-show="$store.chatSidebar.isOpen" class="px-2 mt-4 mb-2 flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-zinc-500 tracking-wider">Grupos</h3>
                <span class="bg-zinc-100 dark:bg-zinc-800 text-zinc-500 text-[10px] px-1.5 rounded">{{ collect($groups)->count() }}</span>
            </div>

            <!-- Groups List -->
            @foreach($groups as $group)
                @php 
                     $avatars = [];
                     if(isset($group['members'])) {
                         foreach($group['members'] as $m) $avatars[] = $m['image'] ?? 'https://ui-avatars.com/api/?name=User';
                     }
                @endphp
                <div wire:key="group-{{ $group['id'] }}" wire:click="openGroup({{ $group['id'] }}); if(window.innerWidth < 768) $store.chatSidebar.close()" 
                    class="relative group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 rounded-xl transition-all flex items-center shrink-0"
                    :class="$store.chatSidebar.isOpen ? 'p-2 gap-3 justify-start' : 'p-2 justify-center'"
                    title="{{ $group['name'] }}">
                    
                    <!-- Group Avatar -->
                    <div class="relative shrink-0 w-10 h-10 overflow-hidden rounded-full ring-2 ring-transparent group-hover:ring-blue-500 transition-all">
                        @php $count = count($avatars); @endphp
                        @if($count <= 1)
                            <img src="{{ $avatars[0] ?? $group['image'] }}" class="w-full h-full object-cover">
                        @elseif($count == 2)
                            <div class="grid grid-cols-2 w-full h-full">
                                <img src="{{ $avatars[0] }}" class="w-full h-full object-cover">
                                <img src="{{ $avatars[1] }}" class="w-full h-full object-cover">
                            </div>
                        @elseif($count == 3)
                            <div class="grid grid-cols-2 grid-rows-2 w-full h-full">
                                <img src="{{ $avatars[0] }}" class="w-full h-full object-cover row-span-2">
                                <img src="{{ $avatars[1] }}" class="w-full h-full object-cover">
                                <img src="{{ $avatars[2] }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="grid grid-cols-2 grid-rows-2 w-full h-full">
                                <img src="{{ $avatars[0] }}" class="w-full h-full object-cover">
                                <img src="{{ $avatars[1] }}" class="w-full h-full object-cover">
                                <img src="{{ $avatars[2] }}" class="w-full h-full object-cover">
                                <img src="{{ $avatars[3] }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>

                    <!-- Group Info (Only when open) -->
                    <div x-show="$store.chatSidebar.isOpen" x-transition class="flex flex-col flex-1 min-w-0 overflow-hidden">
                        <div class="flex justify-between items-baseline">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                {{ $group['name'] }}
                            </h4>
                            <span class="text-[10px] text-zinc-400 shrink-0 ml-2">
                                {{ $group['time'] }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center mt-0.5">
                            <p class="text-xs text-zinc-500 truncate pr-2">
                                {{ $group['msg'] }}
                            </p>
                            <!-- Archive Action (Hover) -->
                            <button wire:click.stop="toggleGroupArchive({{ $group['id'] }})" 
                                class="opacity-0 group-hover:opacity-100 shrink-0 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all"
                                title="{{ $group['is_archived'] ? 'Desarquivar' : 'Arquivar' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($group['is_archived'])
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    @endif
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Empty State for Archived Groups -->
            @if($showArchived && count($groups) == 0)
                <div class="text-center text-zinc-400 text-xs py-4" x-show="$store.chatSidebar.isOpen">
                    Nenhum grupo arquivado
                </div>
            @endif

            <!-- Create Group Button (Hide in Archive Mode) -->
            @if(!$showArchived)
            <div class="mt-4 flex gap-2 w-full">
                <button wire:click="openNewChatModal" 
                    class="shrink-0 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-100 transition-colors w-full py-2 gap-2"
                    :class="$store.chatSidebar.isOpen ? '' : 'w-10 h-10'"
                    title="Nova Conversa">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8M12 8v8"></path>
                    </svg>
                    <span x-show="$store.chatSidebar.isOpen" class="text-sm font-medium">Conversa</span>
                </button>
                <button wire:click="openCreateGroupModal" 
                    class="shrink-0 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 transition-colors w-full py-2 gap-2"
                    :class="$store.chatSidebar.isOpen ? '' : 'w-10 h-10'"
                    title="Criar Grupo">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span x-show="$store.chatSidebar.isOpen" class="text-sm font-medium">Grupo</span>
                </button>
            </div>
            @endif
        </div>

        <!-- Archived Chats Toggle -->
        <div class="shrink-0 p-2 border-t border-zinc-100 dark:border-zinc-800" :class="$store.chatSidebar.isOpen ? 'w-full' : 'w-full flex justify-center'">
            <button wire:click="toggleArchived" 
                class="flex items-center text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors"
                :class="$store.chatSidebar.isOpen ? 'w-full justify-between px-2' : 'justify-center p-2'"
                title="Conversas Arquivadas">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <span x-show="$store.chatSidebar.isOpen" class="text-sm">
                        {{ $showArchived ? 'Caixa de Entrada' : 'Arquivadas' }}
                    </span>
                </span>
                <svg x-show="$store.chatSidebar.isOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>

        <!-- Modals (Outside the layout flow but inside the component) -->
        @if($showNewChatModal)
            <div class="fixed inset-0 z-[80] flex items-center justify-center bg-black/50 p-4">
                <div class="bg-white dark:bg-zinc-900 w-full max-w-md rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
                    <div class="p-4 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                        <h3 class="font-bold text-lg dark:text-white">Nova Conversa</h3>
                        <button wire:click="$set('showNewChatModal', false)" class="text-zinc-400 hover:text-zinc-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Selecionar Membro</label>
                        <input wire:model="searchUser" type="text" placeholder="Digite o nome do usuário..." class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-brand-500" />
                        <div class="mt-2 max-h-40 overflow-y-auto space-y-1">
                            @foreach($filteredUsers as $user)
                                <button wire:click="startChat({{ $user->id }})" class="w-full flex items-center gap-2 px-3 py-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                                    <img src="{{ $user->profile?->image ? Storage::url($user->profile->image) : $user->image_url }}" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm dark:text-gray-200">{{ $user->name }}</span>
                                </button>
                            @endforeach
                            @if(count($filteredUsers) == 0)
                                <div class="text-xs text-zinc-400 p-2">Nenhum usuário encontrado.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($showCreateGroupModal)
            <div class="fixed inset-0 z-[80] flex items-center justify-center bg-black/50 p-4">
                <div class="bg-white dark:bg-zinc-900 w-full max-w-md rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
                    <div class="p-4 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                        <h3 class="font-bold text-lg dark:text-white">Criar Novo Grupo</h3>
                        <button wire:click="$set('showCreateGroupModal', false)" class="text-zinc-400 hover:text-zinc-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="p-4 overflow-y-auto space-y-4">
                        <!-- Group Name -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Nome do Grupo</label>
                            <input wire:model="newGroupName" type="text" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-brand-500" placeholder="Ex: Time de Vendas">
                            @error('newGroupName') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- User Selection -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Selecionar Membros</label>
                            <div class="space-y-2 border rounded-lg p-2 dark:border-zinc-700 max-h-48 overflow-y-auto">
                                @foreach($users as $user)
                                    <label class="flex items-center gap-3 p-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded cursor-pointer">
                                        <input type="checkbox" wire:model="selectedUsersForGroup" value="{{ $user->id }}" class="rounded text-brand-500">
                                        <img src="{{ $user->profile?->image ? Storage::url($user->profile->image) : $user->image_url }}" class="w-8 h-8 rounded-full object-cover">
                                        <span class="text-sm dark:text-gray-200">{{ $user->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedUsersForGroup') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-4 border-t border-zinc-100 dark:border-zinc-800 flex justify-end gap-2">
                         <button wire:click="$set('showCreateGroupModal', false)" class="px-4 py-2 text-sm text-zinc-500 hover:text-zinc-700">Cancelar</button>
                         <button wire:click="createGroup" class="px-4 py-2 text-sm bg-brand-500 text-white rounded-lg hover:bg-brand-600">Criar Grupo</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
```
