<div class="h-[calc(100vh-186px)] overflow-hidden sm:h-[calc(100vh-174px)]">
    <div class="flex flex-col h-full gap-6 xl:flex-row xl:gap-5">
        <!-- Chat List -->
        <div x-data="{ isMobile: false }" @click.outside="isMobile = false" class="flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white xl:flex xl:w-1/4 dark:border-zinc-800 dark:bg-white/3">
            <!-- header, search etc (same as your markup) -->
            <div class="sticky px-4 pt-4 pb-4 sm:px-5 sm:pt-5 xl:pb-0">
                <div class="flex items-start justify-between">
                    <h3 class="text-theme-xl font-semibold text-zinc-800 sm:text-2xl dark:text-white/90">
                        Bate-papos 
                    </h3>
                    <div x-data="{ openDropDown: false }" class="relative">
                        <button @click="openDropDown = !openDropDown" :class="openDropDown ? 'text-zinc-700 dark:text-white' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white'" class="text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white">
                            <!-- icon -->
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z" fill=""></path>
                            </svg>
                        </button>
                        <div x-show="openDropDown" @click.outside="openDropDown = false" x-transition="" class="shadow-theme-lg dark:bg-zinc-dark absolute top-full right-0 z-40 w-40 space-y-1 rounded-2xl border border-zinc-200 bg-white p-2 dark:border-zinc-800" style="display: none;">
                            <button class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-zinc-300">
                                Ver mais
                            </button>
                            <button class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-zinc-300">
                                Excluir
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-3 pb-14 xl:pb-0">
                    <button @click="isMobile = !isMobile" class="flex h-11 w-full max-w-11 items-center justify-center rounded-lg border border-zinc-300 text-zinc-700 xl:hidden dark:border-zinc-700 dark:text-zinc-400">
                        <!-- mobile button icon -->
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25H20C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L20 12.75C20.4142 12.75 20.75 12.4142 20.75 12C20.75 11.5858 20.4142 11.25 20 11.25L4 11.25Z" fill=""></path>
                        </svg>
                    </button>

                    <div class="relative my-2 w-full">
                        <form>
                            <button class="absolute top-1/2 left-4 -translate-y-1/2">
                                <svg class="fill-zinc-500 dark:fill-zinc-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" fill=""></path>
                                </svg>
                            </button>

                            <input type="text" placeholder="Procurar..." class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-zinc-300 bg-transparent py-2.5 pr-3.5 pl-[42px] text-sm text-zinc-800 placeholder:text-zinc-400 focus:ring-3 focus:outline-hidden dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:placeholder:text-white/30">
                        </form>
                    </div>
                </div>
            </div>


            <div class="no-scrollbar flex-col overflow-auto" :class="isMobile ? 'flex fixed top-0 left-0 z-999999 h-screen w-80 bg-white dark:bg-zinc-900 shadow-2xl' : 'hidden xl:flex'">
                <div class="flex items-center justify-between border-b border-zinc-200 p-5 xl:hidden dark:border-zinc-800">
                    <h3 class="text-theme-xl font-semibold text-zinc-800 sm:text-2xl dark:text-white/90">
                        Bater papo
                    </h3>
                   <div class="flex items-center gap-1">
                        <div x-data="{ openDropDown: false }" class="relative -mb-1.5">
                            <button @click="openDropDown = !openDropDown" :class="openDropDown ? 'text-zinc-700 dark:text-white' :
                                    'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white'" class="text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z" fill=""></path>
                                </svg>
                            </button>

                            <div x-show="openDropDown" @click.outside="openDropDown = false" x-transition="" class="shadow-theme-lg dark:bg-zinc-dark absolute top-full right-0 z-40 w-40 space-y-1 rounded-2xl border border-zinc-200 bg-white p-2 dark:border-zinc-800" style="display: none;">
                                <button class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-zinc-300"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;">Ver mais</font></font></button>
                                <button class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-zinc-300"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;">Excluir</font></font></button>
                            </div>
                        </div>

                        <button @click="isMobile = !isMobile" class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-300 text-zinc-700 dark:border-zinc-700 dark:text-zinc-400">
                            <!-- chevron icon -->
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z" fill=""></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex max-h-full flex-col overflow-auto px-4 sm:px-5">
                    <div class="custom-scrollbar max-h-full space-y-1 overflow-auto">                 
                        @forelse($users as $user)
                            <div wire:key="{{ $user->id }}" 
                                wire:click="selectUser({{ $user->id }})"
                                class="group flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-200
                                        {{ $selectedUser && $selectedUser->id === $user->id 
                                            ? 'bg-blue-50 dark:bg-blue-600/10 border border-blue-200 dark:border-blue-600/20' 
                                            : 'hover:bg-zinc-50 dark:hover:bg-zinc-800 border border-transparent' }}">
                                
                                <div class="relative h-10 w-10 shrink-0">
                                    <!-- Avatar -->
                                    <div class="h-full w-full rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-500 dark:text-zinc-300 font-bold overflow-hidden">
                                        {{ $user->initials() }}
                                    </div>
                                    <!-- Status Code (Green/zinc) -->
                                    <span class="absolute right-0 bottom-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white dark:ring-zinc-900 {{ $user->id % 2 == 0 ? 'bg-green-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline">
                                        <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-200 truncate">{{ $user->name }}</h3>
                                        @if($user->last_message)
                                            <span class="text-xs text-zinc-400">{{ $user->last_message->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center mt-1">
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 truncate">
                                            {{ $user->last_message ? Str::limit($user->last_message->content ?: 'Anexo enviado', 20) : 'Toque para iniciar' }}
                                        </p>
                                        @if($user->unread_count > 0)
                                            <span class="flex h-5 min-w-[20px] px-1.5 items-center justify-center rounded-full bg-green-500 text-xs font-bold text-white">
                                                {{ $user->unread_count }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-zinc-500 text-sm">Nenhum contato disponível.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- end chat list -->
        </div>
        <!-- end chat list -->

        <!-- Chat Box -->
        <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/3 xl:w-3/4">
            @if($selectedUser)
                <!-- ====== Chat Box Start -->
                <!-- ====== Chat Box Header (Redesigned) -->
                <div class="flex items-center justify-between border-b border-zinc-50 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-5 py-4 shrink-0">
                    <div class="flex items-center gap-3 overflow-hidden">
                        
                        <!-- Mobile Back Button -->
                        <button @click="selectedUser = null; isMobile = false" class="mr-1 xl:hidden text-zinc-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>

                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            <div class="h-10 w-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-600 dark:text-white font-bold overflow-hidden">
                                @if($selectedUser->profile?->image)
                                     <img src="{{ Storage::url($selectedUser->profile->image) }}" class="w-full h-full object-cover">
                                @else
                                     {{ $selectedUser->initials() }}
                                @endif
                            </div>
                        </div>
                        
                        <!-- Name & Status -->
                        <div class="flex flex-col min-w-0">
                            <h3 class="font-bold text-zinc-900 dark:text-zinc-100 text-base truncate leading-tight">
                                {{ $selectedUser->name }}
                            </h3>
                            <div class="flex items-center h-4 gap-1.5">
                                 <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                 <span class="text-xs font-medium text-green-600 dark:text-green-400">Online</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions (Right) -->
                    <!-- Actions (Right) -->
                    <div class="flex items-center gap-1">
                        
                        <!-- Options Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-8 h-8 flex items-center justify-center rounded-lg bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-300 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.outside="open = false" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-100 dark:border-zinc-700 z-50 overflow-hidden py-1">
                                
                                <!-- Video Call Mock -->
                                <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Chamada de vídeo
                                </button>

                                <!-- Audio Call Mock -->
                                <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    Chamada de áudio
                                </button>
                                
                                <!-- Delete Mock -->
                                <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Excluir conversa
                                </button>

                                <!-- Mark as Unread Mock -->
                                <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Marcar como não lida
                                </button>

                                <!-- Mute Mock -->
                                <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" /></svg>
                                    Silenciar
                                </button>

                                <!-- Archive Mock -->
                                <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                     <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    Arquivar
                                </button>

                                <div class="h-px bg-zinc-100 dark:bg-zinc-700 my-1"></div>
                                
                                <!-- Report Mock -->
                                <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8l-2 2H5l-2-2zM5 21h18"></path></svg>
                                    Denunciar
                                </button>
                            </div>
                        </div>

                         <!-- Minimize Button (Visual) -->
                         <button type="button" class="w-8 h-8 flex items-center justify-center text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        </button>

                        <!-- Close Button (Clears selection) -->
                        <button @click="$wire.set('selectedUser', null)" class="w-8 h-8 flex items-center justify-center text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                <!-- Chat Messages -->
                <div id="chat-messages" class="custom-scrollbar max-h-full flex-1 space-y-6 overflow-auto p-5 xl:space-y-8 xl:p-6"
                    x-data="{ 
                        playAudio(id) {
                            let audio = document.getElementById('audio-' + id);
                            let others = document.querySelectorAll('audio');
                            others.forEach(a => { if(a !== audio) a.pause(); });
                            if(audio.paused) audio.play(); else audio.pause();
                        },
                        setPlaybackSpeed(id, speed) {
                            let audio = document.getElementById('audio-' + id);
                            if(audio) audio.playbackRate = speed;
                        }
                    }">
                    @forelse($chatMessages as $message)
                        @php
                            $isMe = $message->sender_id === auth()->id();
                        @endphp
                        
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} mb-4" wire:key="msg-{{ $message->id }}">
                            <div class="flex items-end gap-3 max-w-[85%] lg:max-w-[70%]">
                                @if(!$isMe)
                                    <div class="h-8 w-8 rounded-full bg-zinc-200 dark:bg-zinc-700 shrink-0 flex items-center justify-center text-xs text-zinc-600 dark:text-white overflow-hidden shadow-inner">
                                        @if($selectedUser->profile?->image)
                                            <img src="{{ Storage::url($selectedUser->profile->image) }}" class="h-full w-full object-cover">
                                        @else
                                            {{ $selectedUser->initials() }}
                                        @endif
                                    </div>
                                @endif

                                <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                    <!-- Message Bubble -->
                                    <div class="group relative px-4 py-3 rounded-2xl shadow-sm transition-all
                                        {{ $isMe 
                                            ? 'bg-brand-500 text-white rounded-br-sm' 
                                            : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 rounded-bl-sm border border-zinc-100 dark:border-zinc-700' 
                                        }}">
                                        
                                        <!-- Attachments -->
                                        @if(!empty($message->attachments))
                                            <div class="mb-2 space-y-2">
                                                @foreach($message->attachments as $index => $attachment)
                                                    <div class="rounded-xl overflow-hidden border border-black/5 dark:border-white/5 bg-black/5 dark:bg-white/5">
                                                        @if(Str::startsWith($attachment['mime_type'], 'image/'))
                                                            <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank" class="block aspect-video lg:aspect-auto">
                                                                <img src="{{ asset('storage/' . $attachment['path']) }}" class="max-w-full max-h-[400px] object-contain mx-auto hover:opacity-95 transition">
                                                            </a>
                                                        @elseif(Str::startsWith($attachment['mime_type'], 'video/'))
                                                            <video controls class="max-w-full max-h-[400px] rounded-lg">
                                                                <source src="{{ asset('storage/' . $attachment['path']) }}" type="{{ $attachment['mime_type'] }}">
                                                            </video>
                                                        @elseif(Str::startsWith($attachment['mime_type'], 'audio/'))
                                                            <!-- WhatsApp Style Audio Player -->
                                                            <div x-data="{ speed: 1, playing: false }" class="flex items-center gap-3 p-3 min-w-[200px] lg:min-w-[280px]">
                                                                <button @click="playing = !playing; $parent.playAudio('{{ $message->id }}-{{ $index }}')" 
                                                                    class="shrink-0 w-10 h-10 flex items-center justify-center rounded-full {{ $isMe ? 'bg-white/20 text-white' : 'bg-brand-500 text-white' }}">
                                                                    <svg x-show="!playing" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                                                    <svg x-show="playing" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                                                </button>
                                                                
                                                                <div class="flex-1">
                                                                    <audio id="audio-{{ $message->id }}-{{ $index }}" 
                                                                        @playing="playing = true" @pause="playing = false" @ended="playing = false"
                                                                        class="hidden">
                                                                        <source src="{{ asset('storage/' . $attachment['path']) }}" type="{{ $attachment['mime_type'] }}">
                                                                    </audio>
                                                                    <div class="h-1.5 w-full bg-black/10 dark:bg-white/10 rounded-full overflow-hidden">
                                                                        <div class="h-full bg-current opacity-50" style="width: 0%" 
                                                                            x-init="let a = document.getElementById('audio-{{ $message->id }}-{{ $index }}'); a.ontimeupdate = () => { $el.style.width = (a.currentTime / a.duration * 100) + '%' }"></div>
                                                                    </div>
                                                                    <div class="flex justify-between items-center mt-1">
                                                                        <span class="text-[10px] opacity-70" x-init="let a = document.getElementById('audio-{{ $message->id }}-{{ $index }}'); a.onloadedmetadata = () => { $el.innerText = Math.floor(a.duration / 60) + ':' + (Math.floor(a.duration % 60)).toString().padStart(2, '0') }">0:00</span>
                                                                        
                                                                        <!-- Speed Control -->
                                                                        <button @click="speed = (speed === 1 ? 1.5 : (speed === 1.5 ? 2 : 1)); $parent.setPlaybackSpeed('{{ $message->id }}-{{ $index }}', speed)" 
                                                                            class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $isMe ? 'bg-white/20' : 'bg-zinc-200 dark:bg-zinc-700' }} hover:opacity-80">
                                                                            <span x-text="speed + 'x'"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <a href="{{ asset('storage/' . $attachment['path']) }}" download class="p-2 opacity-50 hover:opacity-100 transition">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="flex items-center gap-3 p-3 {{ $isMe ? 'bg-white/10' : 'bg-zinc-100 dark:bg-zinc-700/50' }}">
                                                                <div class="p-2 bg-brand-500 rounded-lg text-white">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                                                </div>
                                                                <div class="flex-1 min-w-0">
                                                                    <p class="text-xs font-medium truncate {{ $isMe ? 'text-white' : 'text-zinc-700 dark:text-zinc-200' }}">{{ $attachment['name'] }}</p>
                                                                    <p class="text-[10px] opacity-60">{{ $this->formatFileSize($attachment['size']) }}</p>
                                                                </div>
                                                                <a href="{{ asset('storage/' . $attachment['path']) }}" download class="p-1.5 hover:bg-black/10 rounded-full transition">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($message->content)
                                            <p class="leading-relaxed text-sm whitespace-pre-wrap">{{ $message->content }}</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Time -->
                                    <div class="flex items-center gap-1 mt-1 {{ $isMe ? 'flex-row-reverse mr-1' : 'ml-1' }}">
                                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500">
                                            {{ $message->created_at->diffForHumans(null, true) }}
                                        </span>
                                        @if($isMe)
                                            <svg class="h-3 w-3 {{ $message->read_at ? 'text-brand-500' : 'text-zinc-300' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <path d="M2 12l5 5L20 4M7 12l5 5L22 4" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-zinc-500 dark:text-zinc-600 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            <p class="text-sm">Inicie a conversa!</p>
                        </div>
                    @endforelse
                    <div id="scroll-anchor"></div>
                </div>

                <!-- Chat Input -->
                <div class="sticky bottom-0 border-t border-zinc-100 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-4">
                    <form wire:submit.prevent="sendMessage" class="flex items-end gap-3" 
                        x-data="{ 
                            isRecording: false, 
                            mediaRecorder: null, 
                            audioChunks: [],
                            content: @entangle('content'),
                            isUploading: false,
                            autoResize() {
                                $el.style.height = 'auto';
                                $el.style.height = $el.scrollHeight + 'px';
                            }
                        }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false">
                        
                        <div class="flex-1 relative flex items-center bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 focus-within:border-brand-500 transition-colors p-2 px-3">
                            <!-- File Button -->
                            <div class="relative">
                                <input type="file" wire:model.live="attachments" id="file-upload" class="hidden" multiple>
                                <label for="file-upload" class="p-2 text-zinc-400 hover:text-brand-500 transition cursor-pointer flex items-center justify-center relative">
                                    @if(count($attachments) > 0)
                                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white shadow-sm">{{ count($attachments) }}</span>
                                    @endif
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.51a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                </label>
                            </div>

                            <!-- Input Field -->
                            <textarea x-model="content"
                                @input="autoResize()"
                                @keydown.enter.prevent="$wire.sendMessage()"
                                placeholder="Digite uma mensagem..." 
                                class="flex-1 min-h-[40px] max-h-[120px] bg-transparent border-none text-sm text-zinc-800 dark:text-white/90 placeholder:text-zinc-400 focus:ring-0 py-2 resize-none overflow-y-auto custom-scrollbar"></textarea>
                            
                            <!-- Recording Indicator -->
                            <div x-show="isRecording" class="absolute inset-0 bg-white dark:bg-zinc-800 rounded-2xl flex items-center px-4 gap-3 z-10 animate-fade-in" x-cloak>
                                <span class="flex h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                                <span class="text-xs font-medium text-red-500">Gravando áudio...</span>
                                <div class="flex-1"></div>
                                <button type="button" @click="mediaRecorder.stop(); isRecording = false;" class="text-xs font-semibold text-zinc-500 hover:text-red-500 px-2 py-1">Cancelar</button>
                            </div>

                            <!-- Uploading Indicator -->
                            <div x-show="isUploading" class="absolute right-3 top-1/2 -translate-y-1/2" x-cloak>
                                <svg class="animate-spin h-4 w-4 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            <!-- Voice Button -->
                            <div x-show="!content && !($wire.attachments && $wire.attachments.length)">
                                <button type="button"
                                    @mousedown="
                                        isRecording = true;
                                        navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                                            mediaRecorder = new MediaRecorder(stream, { mimeType: 'audio/webm' });
                                            mediaRecorder.start();
                                            audioChunks = [];
                                            mediaRecorder.ondataavailable = event => audioChunks.push(event.data);
                                            mediaRecorder.onstop = () => {
                                                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                                                audioChunks = [];
                                                if(isRecording) {
                                                    @this.upload('audioAttachment', audioBlob, (uploadedFilename) => {
                                                        $wire.sendAudioMessage();
                                                    });
                                                }
                                                stream.getTracks().forEach(track => track.stop());
                                            };
                                        }).catch(err => {
                                            isRecording = false;
                                            alert('Permissão de microfone negada ou erro: ' + err.message);
                                        });
                                    "
                                    @mouseup="if(isRecording) mediaRecorder.stop(); isRecording = false;"
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-brand-500 transition-all hover:scale-105 active:scale-95 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" x2="12" y1="19" y2="22"/></svg>
                                </button>
                            </div>

                            <!-- Send Button -->
                            <button type="submit" 
                                x-show="content || ($wire.attachments && $wire.attachments.length)"
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-500 text-white hover:bg-brand-600 transition-all hover:scale-105 active:scale-95 shadow-md shadow-brand-500/20">
                                <svg class="ml-0.5" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 2L11 13M22 2L15 22L11 13M22 2L2 9L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    @if(count($attachments) > 0)
                        <div class="mt-2 flex flex-wrap gap-2 animate-slide-up">
                            @foreach($attachments as $index => $file)
                                <div class="group relative flex items-center gap-2 px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800/80 rounded-lg border border-zinc-200 dark:border-zinc-700 pr-8">
                                    <svg class="w-4 h-4 text-brand-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-300 truncate max-w-[120px]">{{ $file->getClientOriginalName() }}</span>
                                    <button type="button" wire:click="removeAttachment({{ $index }})" class="absolute right-1 text-zinc-400 hover:text-red-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <!-- ====== Chat Box End -->
        </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center p-8 text-center text-zinc-500 dark:text-zinc-600">
                    <div class="h-24 w-24 bg-zinc-100 dark:bg-zinc-800/50 rounded-full flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                <h3 class="text-xl font-semibold text-zinc-700 dark:text-zinc-300">Selecione uma conversa</h3>
                <p class="mt-2 text-zinc-500 max-w-sm">Escolha um contato para conversar, enviar arquivos e mídias em tempo real.</p>
            </div>
        @endif
    </div>
</div>


@script
<script>
    Livewire.on('scroll-to-bottom', () => {
         const container = document.getElementById('chat-messages');
         if (container) {
             container.scrollTop = container.scrollHeight;
         }
    });
     
     // Initial scroll attempt
     setTimeout(() => {
         const container = document.getElementById('chat-messages');
         if (container) {
             container.scrollTop = container.scrollHeight;
         }
     }, 100);
</script>
@endscript