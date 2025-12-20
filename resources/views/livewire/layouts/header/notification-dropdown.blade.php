{{-- Notification Dropdown Component --}}
<div class="relative" x-data="{ 
    dropdownOpen: @entangle('isOpen'), 
    notifying: {{ $this->unreadCount > 0 ? 'true' : 'false' }} 
}" 
@click.away="dropdownOpen = false">

    <!-- Notification Button -->
    <button
        class="relative flex items-center justify-center text-zinc-500 transition-colors bg-white border border-zinc-200 rounded-full hover:text-dark-900 h-11 w-11 hover:bg-zinc-100 hover:text-zinc-700 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white"
        @click="dropdownOpen = !dropdownOpen"
        type="button"
    >
        {{-- Notification Badge --}}
        <span class="absolute right-0 top-0.5 z-1 h-2 w-2 rounded-full {{ $this->badgeColor }}">
            @if($this->notificationStatus === 'new')
            <span class="absolute inline-flex w-full h-full {{ $this->badgeColor }} rounded-full opacity-75 -z-1 animate-ping"></span>
            @endif
        </span>

        <!-- Bell Icon -->
        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z" fill=""/>
        </svg>
    </button>

    <!-- Dropdown Start -->
    <div
        x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="fixed inset-x-4 top-24 z-999 mx-auto w-[calc(100%-2rem)] max-w-sm flex-col rounded-2xl border border-zinc-200 bg-white shadow-theme-lg dark:border-zinc-800 dark:bg-zinc-900 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-3 sm:w-[380px]"
        style="display: none;"
    >
        <!-- Header -->
        <div class="rounded-t-lg bg-zinc-50 dark:bg-zinc-800">
            <div class="flex items-center justify-between px-4 pt-3 pb-2">
                <div class="flex items-center gap-2">
                    <h3 class="font-medium text-zinc-800 dark:text-zinc-100">
                        Notificações
                    </h3>
                    @if($this->unreadCount > 0)
                    <div class="flex items-center justify-center h-5 px-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500/20">
                        {{ $this->unreadCount }}
                    </div>
                    @endif
                </div>
                <button
                    @click="dropdownOpen = false"
                    class="flex items-center justify-center w-7 h-7 text-zinc-500 rounded-full hover:bg-zinc-200/50 dark:text-zinc-400 dark:hover:bg-zinc-700/50"
                    type="button"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex overflow-x-auto scroll-smooth bg-zinc-50 px-3 dark:bg-zinc-800 border-b border-zinc-100 dark:border-zinc-700 no-scrollbar">
            @foreach([
                'all' => 'Todos',
                'message' => 'Mensagem', 
                'challenges' => 'Desafios',
                'tickets' => 'Ticket', 
                'registers' => 'Registro', 
                'security' => 'Segurança'
            ] as $key => $label)
            <button
                wire:click="setTab('{{ $key }}')"
                class="shrink-0 whitespace-nowrap border-b-2 px-3 py-2 text-sm font-medium transition-colors {{ $activeTab === $key ? 'border-brand-500 text-brand-600 dark:border-brand-400 dark:text-brand-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                type="button"
            >
                {{ $label }}
            </button>
            @endforeach
        </div>

        <!-- Content -->
        <div class="flex flex-col h-[350px] overflow-y-auto custom-scrollbar p-4 space-y-4">
            
            @if(count($this->filteredNotifications) > 0)
                <div class="space-y-4">
                    @foreach($this->filteredNotifications as $notification)
                        <div class="group flex items-center justify-between gap-3 p-1 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors relative">
                            <div class="flex min-w-0 gap-3">
                                <!-- Icon / Image -->
                                <div class="relative inline-flex shrink-0 h-10 w-10">
                                    @if(isset($notification->data['image']) && $notification->data['image'])
                                         <img src="{{ Storage::url($notification->data['image']) }}" class="h-full w-full rounded-lg object-cover" alt="Image">
                                    @else
                                        <div 
                                            class="flex h-full w-full items-center justify-center rounded-lg {{ $notification->data['icon_bg'] ?? 'bg-zinc-100' }} {{ $notification->data['icon_color'] ?? 'text-zinc-500' }}"
                                        >
                                            {!! $notification->data['icon'] ?? '' !!}
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Text Info -->
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-sm text-zinc-800 dark:text-zinc-100">
                                        {{ $notification->data['title'] ?? 'Notificação' }}
                                    </p>
                                    <div class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $notification->data['description'] ?? '' }}
                                    </div>
                                    <div class="mt-0.5 truncate text-xs text-zinc-400 dark:text-zinc-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            <!-- Individual Archive Button (Visible on Hover) -->
                            <button 
                                wire:click.stop="archiveItem('{{ $notification->id }}')"
                                class="opacity-0 group-hover:opacity-100 transition-opacity absolute right-2 top-1/2 -translate-y-1/2 p-1.5 text-zinc-400 hover:text-red-500 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md"
                                title="Arquivar esta notificação"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center h-full px-4 text-center">
                    <p class="font-medium text-zinc-500 dark:text-zinc-400">Ainda não há novas notificações.</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="shrink-0 overflow-hidden rounded-b-lg bg-zinc-50 dark:bg-zinc-800 border-t border-zinc-100 dark:border-zinc-700">
            @if(count($this->filteredNotifications) > 0)
            <button 
                wire:click="archiveAll"
                class="w-full py-3 text-sm font-medium text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-zinc-100 dark:hover:bg-zinc-700 transition-colors" 
                type="button"
            >
                Arquivar todas as notificações
            </button>
            @else
             <button 
                disabled
                class="w-full py-3 text-sm font-medium text-zinc-400 cursor-not-allowed dark:text-zinc-600" 
                type="button"
            >
                Tudo limpo por aqui
            </button>
            @endif
        </div>
    </div>
    <!-- Dropdown End -->
</div>
