<div>
    @if($isOpen && ($selectedUser || $selectedGroup))
            <div class="fixed bottom-0 right-4 md:right-80 z-50 w-full max-w-sm bg-white dark:bg-zinc-900 shadow-2xl rounded-t-2xl border border-zinc-200 dark:border-zinc-800 flex flex-col transition-all duration-300 {{ $isMinimized ? 'h-14' : 'h-[500px]' }}"
                x-data="{
                                                                                isTyping: false,
                                                                                amITyping: false,
                                                                                isRecording: false,
                                                                                typingTimeout: null,
                                                                                typingAvatar: null,
                                                                                channel: null,
                                                                                init() {
                                                                                    // Scroll helper
                                                                                    $wire.on('scroll-chat-to-bottom', () => { 
                                                                                        var container = $refs.chatContainer;
                                                                                        if(container) setTimeout(() => { container.scrollTop = container.scrollHeight; }, 100);
                                                                                    });

                                                                                    if (typeof Echo !== 'undefined') {
                                                                                        let channelName = null;
                                                                                        
                                                                                        // Determine Channel Name
                                                                                        @if($selectedGroup)
                                                                                            channelName = 'chat.group.{{ $selectedGroup->id }}';
                                                                                        @elseif($selectedUser)
                                                                                            let ids = [{{ auth()->id() }}, {{ $selectedUser->id }}].sort((a, b) => a - b);
                                                                                            channelName = 'chat.' + ids[0] + '_' + ids[1];
                                                                                        @endif

                                                                                        if(channelName) {
                                                                                            this.channel = channelName;
                                                                                            Echo.private(channelName)
                                                                                                .listenForWhisper('typing', (e) => {
                                                                                                    if(e.userId != '{{ auth()->id() }}') {
                                                                                                        this.isTyping = true;
                                                                                                        this.typingAvatar = e.avatar; // Capture avatar from payload
                                                                                                        clearTimeout(this.typingTimeout);
                                                                                                        this.typingTimeout = setTimeout(() => { this.isTyping = false; }, 3000);
                                                                                                    }
                                                                                                })
                                                                                                .listenForWhisper('recording', (e) => {
                                                                                                    if(e.userId != '{{ auth()->id() }}') {
                                                                                                        this.isRecording = true;
                                                                                                        this.isTyping = false;
                                                                                                        setTimeout(() => { this.isRecording = false; }, 5000); 
                                                                                                    }
                                                                                                });
                                                                                        }
                                                                                    }
                                                                                },
                                                                                broadcastTyping() {
                                                                                    if (typeof Echo !== 'undefined' && this.channel) {
                                                                                        Echo.private(this.channel)
                                                                                            .whisper('typing', { 
                                                                                                userId: '{{ auth()->id() }}',
                                                                                                avatar: '{{ auth()->user()->profile?->image ? Storage::url(auth()->user()->profile->image) : (auth()->user()->image_url ?? "https://ui-avatars.com/api/?name=".auth()->user()->name) }}'
                                                                                            });
                                                                                    }
                                                                                }
                                                                            }" x-init="init()">

                <!-- Header -->
                <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between bg-white dark:bg-zinc-900 rounded-t-2xl cursor-pointer"
                    wire:click="minimizeChat">
                    <div class="flex items-center gap-3">
                        @if($selectedGroup)
                            <!-- Group Header Design -->
                            <div class="flex items-center -space-x-2 overflow-hidden mr-2">
                                @if(isset($selectedGroup->members))
                                    @foreach(collect($selectedGroup->members)->take(4) as $member)
                                        <img src="{{ $member->profile?->image ? Storage::url($member->profile->image) : $member->image_url }}"
                                            class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-900 object-cover bg-zinc-100"
                                            title="{{ $member->name }}">
                                    @endforeach
                                @else
                                    <img src="{{ $selectedGroup->image_url }}" class="w-8 h-8 rounded-full object-cover">
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm leading-tight">
                                    {{ $selectedGroup->name }}
                                </h3>
                                <div class="h-4 flex items-center">
                                    <span class="text-[10px] text-zinc-500 dark:text-zinc-400 truncate max-w-[150px]">
                                        {{ isset($selectedGroup->members) ? 'Grupo' : 'Grupo' }}
                                    </span>
                                </div>
                            </div>
                        @elseif($selectedUser)
                            <div class="relative">
                                <img src="{{ $selectedUser->profile?->image ? Storage::url($selectedUser->profile->image) : $selectedUser->image_url }}"
                                    class="w-8 h-8 rounded-full object-cover">
                                <span
                                    class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 border-2 border-white dark:border-zinc-900 rounded-full"></span>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm leading-tight">
                                    {{ $selectedUser->name }}
                                </h3>

                                <!-- Status text logic -->
                                <div class="h-4 flex items-center">
                                    <span x-show="isTyping"
                                        class="text-[10px] text-brand-500 flex items-center gap-1 transition-all"
                                        style="display: none;">
                                        digitando<span class="animate-bounce">.</span><span
                                            class="animate-bounce delay-100">.</span><span class="animate-bounce delay-200">.</span>
                                    </span>
                                    <span x-show="isRecording"
                                        class="text-[10px] text-red-500 flex items-center gap-1 transition-all"
                                        style="display: none;">
                                        gravando áudio...
                                    </span>
                                    <span x-show="!isTyping && !isRecording && !{{ $isMinimized ? 'true' : 'false' }}"
                                        class="text-[10px] text-green-500 flex items-center gap-1 transition-all">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Disponível
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-1" @click.stop>
                        <!-- Header Options Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="absolute right-0 top-full mt-1 w-54 bg-white dark:bg-zinc-800 rounded-lg shadow-xl border border-zinc-200 dark:border-zinc-700 z-50 overflow-hidden text-sm">

                                <!-- Video Call -->
                                <button wire:click="startVideoCall"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Chamada de vídeo
                                </button>

                                <!-- Audio Call -->
                                <button wire:click="startAudioCall"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    Chamada de áudio
                                </button>

                                <div class="h-px bg-zinc-100 dark:bg-zinc-700 my-1"></div>

                                <!-- Delete -->
                                <button wire:click="deleteConversation"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Excluir conversa
                                </button>

                                <!-- Mark as Unread -->
                                <button wire:click="markAsUnread"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    Marcar como não lida
                                </button>

                                <!-- Muted -->
                                <button wire:click="toggleMute"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 {{ $isMuted ? 'text-red-500' : 'text-zinc-400' }}" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        @if($isMuted)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"
                                                clip-rule="evenodd" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                        @endif
                                    </svg>
                                    {{ $isMuted ? 'Reativar som' : 'Silenciar' }}
                                </button>

                                <!-- Archive -->
                                <button wire:click="toggleArchive"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($isArchived)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        @endif
                                    </svg>
                                    {{ $isArchived ? 'Desarquivar' : 'Arquivar' }}
                                </button>

                                <div class="h-px bg-zinc-100 dark:bg-zinc-700 my-1"></div>

                                <!-- Report -->
                                <button wire:click="reportUser"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8l-2 2H5l-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 10a2 2 0 11-4 0 2 2 0 014 0zM9 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 21h18M5 10V7a5 5 0 0110 0v3"></path>
                                    </svg>
                                    Denunciar
                                </button>
                            </div>
                        </div>

                        <button wire:click="minimizeChat"
                            class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>

                        <button wire:click="closeChat" class="text-zinc-400 hover:text-red-500 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Messages -->
                @if(!$isMinimized)
                    <div x-ref="chatContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-zinc-50 dark:bg-zinc-900/50">
                        <!-- Date Separator Mock (Static for Design) -->
                        <div class="flex justify-center mb-4">
                            <span
                                class="text-xs font-medium text-zinc-400 bg-zinc-50 dark:bg-zinc-800 px-3 py-1 rounded-full border border-zinc-100 dark:border-zinc-700">
                                Jul 16, 2022, 06:15 am
                            </span>
                        </div>

                        @forelse($chatMessages as $message)
                            @php 
                                $senderId = $message->sender_id ?? $message->user_id;
                                $isMe = $senderId === auth()->id(); 
                                $senderRes = $message->sender ?? null;
                                $senderImage = $senderRes->image_url ?? $senderRes->profile->image ?? 'https://ui-avatars.com/api/?name='.($senderRes->name ?? 'User');
                                if($senderRes && isset($senderRes->profile) && $senderRes->profile && $senderRes->profile->image) {
                                     $senderImage = Storage::url($senderRes->profile->image);
                                }
                            @endphp
                            
                            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start items-end gap-2' }} group/container">
                                @if(!$isMe)
                                    <img src="{{ $senderImage }}" class="w-8 h-8 rounded-full object-cover mb-1 shadow-sm" title="{{ $senderRes->name ?? '' }}">
                                @endif

                                <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }} max-w-[75%]">
                                    <div
                                        class="relative px-3 py-2 pr-8 rounded-2xl text-sm {{ $isMe ? 'bg-brand-500 text-white rounded-br-none' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 rounded-bl-none shadow-sm' }}">
                                        <!-- Dropdown Trigger (3 dots) -->
                                        <div x-data="{ open: false }"
                                            class="absolute top-1 right-1 hidden group-hover/message:block z-10">
                                            <button @click="open = !open"
                                                class="p-0.5 text-zinc-300 hover:text-white rounded-full hover:bg-black/10 transition">
                                                <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.outside="open = false"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                class="absolute right-0 top-6 w-32 bg-white dark:bg-zinc-800 rounded-lg shadow-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden z-20">
                                                <button wire:click="deleteMessage({{ $message->id }})"
                                                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-500 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Excluir
                                                </button>
                                            </div>
                                        </div>

                                        @if($message->attachment_path)
                                            <div class="mb-2">
                                                @if($message->attachment_type === 'image')
                                                    <img src="{{ asset('storage/' . $message->attachment_path) }}"
                                                        class="rounded-lg max-h-32 object-cover">
                                                @else
                                                    <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank"
                                                        class="flex items-center gap-2 underline text-xs">
                                                        Ver Anexo
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                        {{ $message->content }}
                                    </div>
                                    <span class="text-[10px] text-zinc-400 mt-1">
                                        {{ $message->created_at instanceof \Carbon\Carbon ? $message->created_at->format('H:i') : $message->created_at }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div
                                class="h-full flex flex-col items-center justify-center text-zinc-500 dark:text-zinc-400 text-sm gap-2">
                                <span class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-full">👋</span>
                                <p>Diga olá para {{ $selectedUser ? $selectedUser->name : $selectedGroup->name }}!</p>
                            </div>
                        @endforelse

                        <!-- Typing Bubble Indicator (Animated) -->
                        <div x-show="isTyping || amITyping" style="display: none;"
                            class="flex justify-start items-end gap-2 mt-2 transition-all duration-300">
                            <!-- Helper for Auth Avatar URL (using PHP to inject into JS/Alpine) -->
                            <div class="relative">
                                <!-- My Avatar -->
                                <template x-if="amITyping">
                                    <img src="{{ auth()->user()->profile?->image ? Storage::url(auth()->user()->profile->image) : (auth()->user()->image_url ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name) }}" 
                                        class="w-8 h-8 rounded-full object-cover">
                                </template>
                                <!-- Other's Avatar (Generic or Selected User) -->
                                <template x-if="!amITyping && isTyping">
                                    <template x-if="typingAvatar">
                                        <img :src="typingAvatar" class="w-8 h-8 rounded-full object-cover">
                                    </template>
                                    <!-- Fallback if no avatar in payload -->
                                    <template x-if="!typingAvatar">
                                        <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500 font-bold border border-zinc-300 dark:border-zinc-700">
                                            ...
                                        </div>
                                    </template>
                                </template>
                            </div>

                            <div
                                class="bg-zinc-100 dark:bg-zinc-800 p-3 rounded-2xl rounded-bl-sm flex items-center gap-1 w-16 h-10 shadow-sm">
                                <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full animate-bounce"></span>
                                <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full animate-bounce delay-100"></span>
                                <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full animate-bounce delay-200"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Input -->
                    <div class="p-3 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800">
                        <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
                            <!-- File Button -->
                            <div class="relative">
                                <input type="file" wire:model="attachment"
                                    id="chat-file-upload-{{ $selectedUser ? $selectedUser->id : $selectedGroup->id }}"
                                    class="hidden">
                                <label for="chat-file-upload-{{ $selectedUser ? $selectedUser->id : $selectedGroup->id }}"
                                    class="cursor-pointer text-zinc-400 hover:text-brand-500 p-1">
                                    @if($attachment)
                                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                    @endif
                                </label>
                            </div>

                            <input wire:model="content" 
                                x-on:input="broadcastTyping; amITyping = true; clearTimeout(typingTimeout); typingTimeout = setTimeout(() => amITyping = false, 3000)" 
                                type="text"
                                placeholder="Digite uma mensagem..."
                                class="flex-1 bg-zinc-100 dark:bg-zinc-800 border-none rounded-full py-2 px-4 text-sm focus:ring-1 focus:ring-brand-500 dark:text-white">

                            <button type="submit"
                                class="bg-brand-500 hover:bg-brand-600 text-white p-2 rounded-full shadow-md transition-colors">
                                <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>