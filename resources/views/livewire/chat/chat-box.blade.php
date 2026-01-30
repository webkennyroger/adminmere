<div>
    @if($isOpen && ($selectedUser || $selectedGroup))
            <div class="fixed bottom-24 right-4 md:right-6 z-[60] w-[calc(100%-2rem)] md:w-[360px] h-[600px] max-h-[70vh] bg-white dark:bg-zinc-900 shadow-2xl rounded-2xl border border-zinc-200 dark:border-zinc-800 flex flex-col transition-all duration-300 overflow-hidden"
                x-data="{
                    isTyping: false,
                    amITyping: false,
                    isRecording: false,
                    typingTimeout: null,
                    typingAvatar: null,
                    channel: null,
                    init() {
                        $wire.on('scroll-chat-to-bottom', () => { 
                            var container = $refs.chatContainer;
                            if(container) setTimeout(() => { container.scrollTop = container.scrollHeight; }, 100);
                        });
                        
                        // Listeners setup (Echo)...
                        if (typeof Echo !== 'undefined') {
                            let channelName = null;
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
                                            this.typingAvatar = e.avatar;
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
                            Echo.private(this.channel).whisper('typing', { 
                                userId: '{{ auth()->id() }}',
                                avatar: '{{ auth()->user()->profile?->image ? Storage::url(auth()->user()->profile->image) : (auth()->user()->image_url ?? "https://ui-avatars.com/api/?name=".auth()->user()->name) }}'
                            });
                        }
                    }
                }" x-init="init()">

                <!-- Header -->
                <div class="px-4 py-3 pb-4 border-b border-zinc-50 dark:border-zinc-800 flex items-center justify-between bg-white dark:bg-zinc-900 shrink-0">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <!-- Back Button -->
                        <button @click="$wire.closeChat(); $store.chatSidebar.open()" class="mr-1 text-zinc-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>

                        @if($selectedGroup)
                            <!-- Group Header info -->
                            <div class="relative shrink-0">
                                <img src="{{ $selectedGroup->image_url ?? 'https://ui-avatars.com/api/?name=Group' }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-white dark:ring-zinc-900">
                            </div>
                            <div class="flex flex-col min-w-0">
                                <h3 class="font-bold text-zinc-900 dark:text-zinc-100 text-base truncate leading-tight">
                                    {{ $selectedGroup->name }}
                                </h3>
                                <span class="text-xs text-zinc-500 truncate">Grupo</span>
                            </div>
                        @elseif($selectedUser)
                            <div class="relative shrink-0">
                                <img src="{{ $selectedUser->profile?->image ? Storage::url($selectedUser->profile->image) : $selectedUser->image_url }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                <!-- Online Dot (Overlay on Avatar not needed if text is explicit, but kept for style) -->
                            </div>
                            <div class="flex flex-col min-w-0">
                                <h3 class="font-bold text-zinc-900 dark:text-zinc-100 text-base truncate leading-tight">
                                    {{ $selectedUser->name }}
                                </h3>
                                <div class="flex items-center h-4 gap-1.5">
                                     <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                     <span class="text-xs font-medium text-green-600 dark:text-green-400">Online</span>
                                </div>
                            </div>
                        @endif
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
                                
                                <!-- Video Call -->
                                <button wire:click="startVideoCall" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Chamada de vídeo
                                </button>

                                <!-- Audio Call -->
                                <button wire:click="startAudioCall" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    Chamada de áudio
                                </button>
                                
                                <!-- Delete -->
                                <button wire:click="deleteConversation" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Excluir conversa
                                </button>

                                <!-- Mark as Unread -->
                                <button wire:click="markAsUnread" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Marcar como não lida
                                </button>

                                <!-- Mute -->
                                <button wire:click="toggleMute" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" /></svg>
                                    {{ $isMuted ? 'Reativar som' : 'Silenciar' }}
                                </button>

                                <!-- Archive -->
                                <button wire:click="toggleArchive" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                     <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    {{ $isArchived ? 'Desarquivar' : 'Arquivar' }}
                                </button>

                                <div class="h-px bg-zinc-100 dark:bg-zinc-700 my-1"></div>
                                
                                <!-- Report -->
                                <button wire:click="reportUser" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8l-2 2H5l-2-2zM5 21h18"></path></svg>
                                    Denunciar
                                </button>
                            </div>
                        </div>

                         <!-- Minimize Button -->
                         <button wire:click="minimizeChat" class="w-8 h-8 flex items-center justify-center text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        </button>

                        <!-- Close Button -->
                        <button wire:click="closeChat" class="w-8 h-8 flex items-center justify-center text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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

                                        @if(!empty($message->attachments))
                                            <div class="mt-2 flex flex-col gap-2">
                                                @foreach($message->attachments as $index => $attachment)
                                                    <div class="rounded-xl overflow-hidden border border-black/5 dark:border-white/5 bg-black/5 dark:bg-white/5">
                                                        @if(Str::startsWith($attachment['mime_type'], 'image/'))
                                                            <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $attachment['path']) }}" class="rounded-lg max-h-40 object-cover w-full hover:opacity-95 transition">
                                                            </a>
                                                        @elseif(Str::startsWith($attachment['mime_type'], 'video/'))
                                                            <video controls class="rounded-lg max-h-40 w-full">
                                                                <source src="{{ asset('storage/' . $attachment['path']) }}" type="{{ $attachment['mime_type'] }}">
                                                            </video>
                                                        @elseif(Str::startsWith($attachment['mime_type'], 'audio/'))
                                                            <!-- WhatsApp Style Audio Player -->
                                                            <div x-data="{ speed: 1, playing: false }" class="flex items-center gap-2 p-2 min-w-[180px]">
                                                                <button @click="playing = !playing; $parent.playAudio('{{ $message->id }}-{{ $index }}')" 
                                                                    class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full {{ $isMe ? 'bg-white/20 text-white' : 'bg-brand-500 text-white' }}">
                                                                    <svg x-show="!playing" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                                                    <svg x-show="playing" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                                                </button>
                                                                
                                                                <div class="flex-1 min-w-0">
                                                                    <audio id="audio-{{ $message->id }}-{{ $index }}" 
                                                                        @playing="playing = true" @pause="playing = false" @ended="playing = false"
                                                                        class="hidden">
                                                                        <source src="{{ asset('storage/' . $attachment['path']) }}" type="{{ $attachment['mime_type'] }}">
                                                                    </audio>
                                                                    <div class="h-1 w-full bg-black/10 dark:bg-white/10 rounded-full overflow-hidden">
                                                                        <div class="h-full bg-current opacity-50" style="width: 0%" 
                                                                            x-init="let a = document.getElementById('audio-{{ $message->id }}-{{ $index }}'); a.ontimeupdate = () => { $el.style.width = (a.currentTime / a.duration * 100) + '%' }"></div>
                                                                    </div>
                                                                    <div class="flex justify-between items-center mt-1">
                                                                        <span class="text-[9px] opacity-70" x-init="let a = document.getElementById('audio-{{ $message->id }}-{{ $index }}'); a.onloadedmetadata = () => { $el.innerText = Math.floor(a.duration / 60) + ':' + (Math.floor(a.duration % 60)).toString().padStart(2, '0') }">0:00</span>
                                                                        <button @click="speed = (speed === 1 ? 1.5 : (speed === 1.5 ? 2 : 1)); $parent.setPlaybackSpeed('{{ $message->id }}-{{ $index }}', speed)" 
                                                                            class="text-[9px] font-bold px-1 py-0.5 rounded-full {{ $isMe ? 'bg-white/20' : 'bg-zinc-200 dark:bg-zinc-700' }}">
                                                                            <span x-text="speed + 'x'"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <a href="{{ asset('storage/' . $attachment['path']) }}" download class="p-1 opacity-50 hover:opacity-100 transition">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank" class="flex items-center gap-2 p-2 rounded-lg bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 transition">
                                                                <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                                <div class="text-[11px] min-w-0">
                                                                    <p class="font-semibold truncate">{{ $attachment['name'] }}</p>
                                                                    <p class="text-[9px] text-zinc-500">{{ $this->formatFileSize($attachment['size'], 1) }}</p>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
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
                        <div x-show="isTyping" style="display: none;"
                            class="flex justify-start items-end gap-2 mt-2 transition-all duration-300">
                            <!-- Helper for Auth Avatar URL (using PHP to inject into JS/Alpine) -->
                            <div class="relative">
                                <!-- Other's Avatar (Generic or Selected User) -->
                                <template x-if="typingAvatar">
                                    <img :src="typingAvatar" class="w-8 h-8 rounded-full object-cover">
                                </template>
                                <!-- Fallback if no avatar in payload -->
                                <template x-if="!typingAvatar">
                                    <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500 font-bold border border-zinc-300 dark:border-zinc-700">
                                        ...
                                    </div>
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
                    <div class="p-3 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800"
                        x-data="{ 
                            content: @entangle('content'),
                            isRecording: false, 
                            mediaRecorder: null, 
                            audioChunks: [],
                            isUploading: false
                        }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false">
                        
                        <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
                            <!-- File Button -->
                            <div class="relative">
                                <input type="file" wire:model.live="attachments"
                                    id="chat-file-upload-{{ $selectedUser ? $selectedUser->id : ($selectedGroup ? $selectedGroup->id : '') }}"
                                    class="hidden" multiple>
                                <label for="chat-file-upload-{{ $selectedUser ? $selectedUser->id : ($selectedGroup ? $selectedGroup->id : '') }}"
                                    class="cursor-pointer text-zinc-400 hover:text-brand-500 p-1 relative">
                                    @if(count($attachments) > 0)
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-brand-500 text-white text-[10px] rounded-full flex items-center justify-center font-bold">
                                            {{ count($attachments) }}
                                        </div>
                                    @endif
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                </label>
                            </div>

                            <div class="relative flex-1">
                                <input x-model="content" 
                                    x-on:input="broadcastTyping; amITyping = true; clearTimeout(typingTimeout); typingTimeout = setTimeout(() => amITyping = false, 3000)" 
                                    type="text"
                                    placeholder="Digite uma mensagem..."
                                    class="w-full bg-zinc-100 dark:bg-zinc-800 border-none rounded-full py-2 px-4 text-sm focus:ring-1 focus:ring-brand-500 dark:text-white">
                                
                                <div x-show="isUploading" class="absolute right-3 top-1/2 -translate-y-1/2" x-cloak>
                                    <svg class="animate-spin h-3 w-3 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                            </div>

                            <div class="flex items-center gap-1">
                                <!-- Voice Button -->
                                <button type="button"
                                    x-show="!content && !($wire.attachments && $wire.attachments.length) && !isRecording"
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
                                        }).catch(err => { isRecording = false; });
                                    "
                                    @mouseup="if(isRecording) mediaRecorder.stop(); isRecording = false;"
                                    class="bg-brand-500 hover:bg-brand-600 text-white p-2 rounded-full shadow-md transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                </button>

                                <!-- Recording Pulse -->
                                <button type="button" x-show="isRecording" @click="isRecording = false; mediaRecorder.stop();" class="bg-red-500 text-white p-2 rounded-full shadow-md animate-pulse" x-cloak>
                                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"></path></svg>
                                </button>

                                <!-- Send Button -->
                                <button type="submit"
                                    x-show="content || ($wire.attachments && $wire.attachments.length)"
                                    class="bg-brand-500 hover:bg-brand-600 text-white p-2 rounded-full shadow-md transition-colors">
                                    <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>