<div>
    <!-- Mobile Backdrop -->
    <div x-cloak x-show="$store.chatSidebar.isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="$store.chatSidebar.close()"
        class="fixed inset-0 bg-black/20 z-99998">
    </div>

    <!-- Widget Container -->
    <div x-cloak
        x-show="$store.chatSidebar.isOpen"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 z-99999 h-full w-80 md:w-96 bg-white dark:bg-zinc-900 shadow-2xl border-l border-zinc-200 dark:border-zinc-800 flex flex-col overflow-hidden">

        <!-- Header -->
        <div class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-white dark:bg-zinc-900 shrink-0">
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Mensagens</h2>
            <div class="flex items-center gap-1">
                <!-- New Chat / Edit -->
                <button wire:click="openNewChatModal" class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <!-- Options Dropdown -->
                <div class="relative" x-data="{ openOptions: false }">
                    <button @click="openOptions = !openOptions" 
                            @click.away="openOptions = false" 
                            class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 focus:outline-none rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                    </button>

                    <div x-show="openOptions" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-zinc-900 rounded-xl shadow-xl border border-zinc-100 dark:border-zinc-800 z-50 py-1 overflow-hidden"
                         style="display: none;">
                        
                        <!-- Mark all as read -->
                        <button wire:click="markAllAsRead" @click="openOptions = false" class="flex items-center w-full px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors gap-3">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Marcar todas como lidas
                        </button>

                        <!-- Chat settings -->
                        <button class="flex items-center w-full px-4 py-2.5 text-sm text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors gap-3 opacity-60 cursor-not-allowed" title="Em breve">
                             <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                             </svg>
                            Configurações do chat
                        </button>

                         <!-- Disable Notifications -->
                         <button class="flex items-center w-full px-4 py-2.5 text-sm text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors gap-3 opacity-60 cursor-not-allowed" title="Em breve">
                             <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                             </svg>
                            Desativar notificações
                        </button>

                         <!-- Message sounds -->
                         <button class="flex items-center w-full px-4 py-2.5 text-sm text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors gap-3 opacity-60 cursor-not-allowed" title="Em breve">
                             <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                             </svg>
                            Sons de mensagem
                        </button>

                         <!-- Block settings -->
                         <button class="flex items-center w-full px-4 py-2.5 text-sm text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors gap-3 opacity-60 cursor-not-allowed" title="Em breve">
                             <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                             </svg>
                            Configurações de bloqueio
                        </button>

                        <div class="border-t border-zinc-100 dark:border-zinc-800 my-1"></div>

                        <!-- Create Group -->
                        <button wire:click="openCreateGroupModal" @click="openOptions = false" class="flex items-center w-full px-4 py-2.5 text-sm text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors gap-3 font-medium">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zMM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Criar um grupo
                        </button>
                    </div>
                </div>
                <!-- Close -->
                <button @click="$store.chatSidebar.close()" class="p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Search Section -->
        <div class="p-3 bg-white dark:bg-zinc-900 shrink-0">
            <div class="relative bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                 <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live="search" type="text" placeholder="Pesquisar..." 
                    class="bg-transparent border-none w-full pl-9 py-2 text-sm text-zinc-700 dark:text-zinc-200 placeholder-zinc-400 focus:ring-0">
            </div>
        </div>



        <!-- Users List -->
        <div class="flex-1 w-full overflow-y-auto flex flex-col space-y-2 px-2 pb-2 scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-700" style="overflow-x: hidden !important;">
            
            @forelse($users as $user)
                <div wire:key="sidebar-user-{{ $user->id }}" wire:click="openChat({{ $user->id }})"
                    class="relative group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 rounded-xl transition-all flex items-center shrink-0 p-2 gap-3 justify-start"
                    title="{{ $user->name }}">
                    
                    <!-- Avatar & Status -->
                    <div class="relative shrink-0">
                        <img src="{{ $user->profile?->image ? Storage::url($user->profile->image) : $user->image_url }}"
                            alt="{{ $user->name }}"
                            class="rounded-full object-cover ring-2 ring-transparent group-hover:ring-brand-500 transition-all w-10 h-10">
                        
                        <!-- Online Status Dot -->
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-zinc-900 rounded-full"></span>
                    </div>

                    <!-- Text Info -->
                    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
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
                <div class="text-center text-zinc-500 text-xs py-4">
                    Nenhum usuário
                </div>
            @endforelse

            <!-- Divider -->
            @if(count($users) > 0 && count($groups) > 0)
                <div class="shrink-0 h-px bg-zinc-200 dark:bg-zinc-700 my-2 w-full"></div>
            @endif

            <!-- Groups Header -->
            <div class="px-2 mt-4 mb-2 flex items-center justify-between">
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
                <div wire:key="group-{{ $group['id'] }}" wire:click="openGroup({{ $group['id'] }})" 
                    class="relative group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 rounded-xl transition-all flex items-center shrink-0 p-2 gap-3 justify-start"
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

                    <!-- Group Info -->
                    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
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
                <div class="text-center text-zinc-400 text-xs py-4">
                    Nenhum grupo arquivado
                </div>
            @endif

            <!-- Create Group Button -->
            @if(!$showArchived)
            <div class="mt-4 flex gap-2 w-full">
                <button wire:click="openNewChatModal" 
                    class="shrink-0 flex items-center justify-center rounded-full bg-green-50 text-green-600 hover:bg-green-100 transition-colors w-full py-2 gap-2"
                    title="Nova Conversa">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8M12 8v8"></path>
                    </svg>
                    <span class="text-sm font-medium">Conversa</span>
                </button>
                <button wire:click="openCreateGroupModal" 
                    class="shrink-0 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 transition-colors w-full py-2 gap-2"
                    title="Criar Grupo">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="text-sm font-medium">Grupo</span>
                </button>
            </div>
            @endif
        </div>

        <!-- Archived Chats Toggle -->
        <div class="shrink-0 w-full justify-between bg-yellow-50 dark:bg-yellow-900/10 border-t border-yellow-100 dark:border-yellow-800/20">
            <button wire:click="toggleArchived" 
                class="flex items-center text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors w-full justify-between p-3"
                title="Conversas Arquivadas">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <span class="text-sm font-bold">
                        {{ $showArchived ? 'Caixa de Entrada' : 'Arquivadas' }}
                    </span>
                </span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>

        <!-- Modals (Outside the layout flow but inside the component) -->
        @if($showNewChatModal)
            <div class="fixed inset-0 z-80 flex items-center justify-center bg-black/50 p-4">
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
            <div class="fixed inset-0 z-80 flex items-center justify-center bg-black/50 p-4">
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
