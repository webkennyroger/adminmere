<div class="h-[calc(100vh-186px)] overflow-hidden sm:h-[calc(100vh-174px)]" x-data="{ 
        isMobile: @entangle('isMobile'),
        selectMessageRoom(id) {
            this.isMobile = false;
            $wire.selectUser(id);
        }
    }">
    <div class="flex flex-col h-full gap-6 xl:flex-row xl:gap-5">
        <!-- Chat List Side -->
        <div class="flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white xl:flex xl:w-1/3 2xl:w-1/4 dark:border-white/5 dark:bg-zinc-900/50"
            :class="isMobile ? 'hidden' : 'flex'">

            <!-- Header sidebar -->
            <div class="sticky px-4 pt-4 pb-4 sm:px-5 sm:pt-5 xl:pb-0">
                <div class="flex items-start justify-between">
                    <h3 class="text-theme-xl font-semibold text-zinc-800 sm:text-2xl dark:text-white/90">
                        Bate-papos
                    </h3>
                    <div x-data="{ openDropDown: false }" class="relative">
                        <button @click="openDropDown = !openDropDown"
                            :class="openDropDown ? 'text-zinc-700 dark:text-white' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white'"
                            class="transition-colors">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openDropDown" @click.outside="openDropDown = false" x-transition
                            class="absolute top-full right-0 z-40 w-40 mt-2 space-y-1 rounded-xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-white/5 dark:bg-zinc-800"
                            x-cloak>
                            <button
                                class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-zinc-300">Ver
                                mais</button>
                            <button
                                class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-zinc-300 text-red-500">Excluir
                                tudo</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <div class="relative w-full">
                        <span class="absolute top-1/2 left-4 -translate-y-1/2">
                            <svg class="fill-zinc-400" width="18" height="18" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z">
                                </path>
                            </svg>
                        </span>
                        <input type="text" placeholder="Procurar contatos..."
                            class="h-11 w-full rounded-xl border border-zinc-200 bg-zinc-50 py-2.5 pl-11 pr-4 text-sm text-zinc-800 placeholder:text-zinc-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-none dark:border-white/5 dark:bg-zinc-800 dark:text-white/90 dark:placeholder:text-white/30 transition-all">
                    </div>
                </div>
            </div>

            <!-- User List Content -->
            <div class="flex-1 overflow-y-auto custom-scrollbar px-2 pb-4 mt-4">
                <div class="space-y-1">
                    @forelse($users as $user)
                                    <div wire:key="user-{{ $user->id }}" @click="selectMessageRoom({{ $user->id }})" class="group flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-200
                                                    {{ $selectedUser && $selectedUser->id === $user->id
                        ? 'bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20'
                        : 'hover:bg-zinc-50 dark:hover:bg-white/5 border border-transparent' }}">

                                        <div class="relative h-12 w-12 shrink-0">
                                            <!-- Avatar -->
                                            <div
                                                class="h-full w-full rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-300 font-bold overflow-hidden border border-zinc-200 dark:border-white/5">
                                                @if($user->profile?->image)
                                                    <img src="{{ Storage::url($user->profile->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ $user->initials() }}
                                                @endif
                                            </div>
                                            <!-- Status Dot -->
                                            <span
                                                class="absolute right-0.5 bottom-0.5 block h-3 w-3 rounded-full border-2 border-white dark:border-zinc-900 {{ $user->id % 2 == 0 ? 'bg-green-500' : 'bg-zinc-300 dark:bg-zinc-600' }}"></span>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-baseline mb-0.5">
                                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-200 truncate">
                                                    {{ $user->name }}</h3>
                                                @if($user->last_message)
                                                    <span
                                                        class="text-[10px] font-medium text-zinc-400 dark:text-zinc-500">{{ $user->last_message->created_at->diffForHumans(null, true) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate pr-2">
                                                    {{ $user->last_message ? Str::limit($user->last_message->content ?: '📁 Arquivo enviado', 30) : 'Toque para conversar' }}
                                                </p>
                                                @if($user->unread_count > 0)
                                                    <span
                                                        class="flex h-5 min-w-[20px] px-1.5 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white shadow-sm shadow-brand-500/20">
                                                        {{ $user->unread_count }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                    @empty
                        <div class="p-8 text-center">
                            <div
                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-400 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 font-medium">Nenhum contato</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Chat Box Side -->
        <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white dark:border-white/5 dark:bg-zinc-900/50 xl:flex-1"
            :class="isMobile ? 'flex fixed inset-0 z-50 rounded-none border-none' : 'hidden xl:flex'">

            @if($selectedUser)
                <!-- Chat Window Header -->
                <div
                    class="flex items-center justify-between border-b border-zinc-100 dark:border-white/5 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md px-4 py-3 sm:px-5 sm:py-4 shrink-0 z-20">
                    <div class="flex items-center gap-3 min-w-0">
                        <!-- Mobile Back Button (Open Users) -->
                        <button @click="isMobile = false"
                            class="xl:hidden p-2 -ml-2 text-zinc-400 hover:text-brand-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zMM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </button>

                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            <div
                                class="h-10 w-10 sm:h-11 sm:w-11 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-white font-bold overflow-hidden border border-zinc-200 dark:border-white/5">
                                @if($selectedUser->profile?->image)
                                    <img src="{{ Storage::url($selectedUser->profile->image) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    {{ $selectedUser->initials() }}
                                @endif
                            </div>
                        </div>

                        <!-- Name & Status -->
                        <div class="flex flex-col min-w-0">
                            <h3 class="font-bold text-zinc-900 dark:text-white text-sm sm:text-base truncate leading-tight">
                                {{ $selectedUser->name }}
                            </h3>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                <span
                                    class="text-[10px] sm:text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider">Online
                                    agora</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center gap-1 sm:gap-2">
                        <button
                            class="hidden sm:flex w-9 h-9 items-center justify-center rounded-xl bg-zinc-50 hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-500 dark:text-zinc-400 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </button>

                        <div x-data="{ openOptions: false }" class="relative">
                            <button @click="openOptions = !openOptions"
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-zinc-50 hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-500 dark:text-zinc-400 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                </svg>
                            </button>
                            <div x-show="openOptions" @click.outside="openOptions = false" x-transition x-cloak
                                class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-zinc-800 rounded-xl shadow-2xl border border-zinc-100 dark:border-white/5 z-50 overflow-hidden py-1">
                                <button
                                    class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5">Excluir
                                    conversa</button>
                                <button
                                    class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5">Silenciar</button>
                            </div>
                        </div>

                        <button @click="$wire.set('selectedUser', null)"
                            class="w-9 h-9 flex items-center justify-center text-zinc-400 hover:text-red-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Chat Messages Feed -->
                <div id="chat-messages"
                    class="flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 bg-zinc-50/30 dark:bg-zinc-950/20"
                    wire:ignore.self x-data="{ 
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

                    <div class="flex flex-col gap-6">
                        @forelse($chatMessages as $message)
                                    @php $isMe = $message->sender_id === auth()->id(); @endphp

                                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}" wire:key="msg-{{ $message->id }}">
                                        <div class="flex items-end gap-2.5 max-w-[85%] sm:max-w-[75%] md:max-w-[65%]">
                                            @if(!$isMe)
                                                <div
                                                    class="h-7 w-7 rounded-full bg-zinc-200 dark:bg-zinc-800 shrink-0 flex items-center justify-center text-[10px] font-bold text-zinc-600 dark:text-white border border-white dark:border-zinc-900 shadow-sm overflow-hidden mb-1">
                                                    @if($selectedUser->profile?->image)
                                                        <img src="{{ Storage::url($selectedUser->profile->image) }}"
                                                            class="h-full w-full object-cover">
                                                    @else
                                                        {{ $selectedUser->initials() }}
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                                <!-- Message Bubble -->
                                                <div class="relative px-4 py-2.5 rounded-2xl shadow-sm transition-all
                                                            {{ $isMe
                            ? 'bg-brand-500 text-white rounded-br-none'
                            : 'bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 rounded-bl-none border border-zinc-100 dark:border-white/5' 
                                                            }}">

                                                    <!-- Attachments Grid -->
                                                    @if(!empty($message->attachments))
                                                        <div class="mb-2 space-y-2 last:mb-0">
                                                            @foreach($message->attachments as $index => $attachment)
                                                                <div wire:key="att-{{ $message->id }}-{{ $index }}"
                                                                    class="rounded-xl overflow-hidden border border-black/5 dark:border-white/10 bg-black/5 dark:bg-white/5">
                                                                    @if(Str::startsWith($attachment['mime_type'], 'image/'))
                                                                        <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank"
                                                                            class="block">
                                                                            <img src="{{ asset('storage/' . $attachment['path']) }}"
                                                                                class="max-w-full h-auto object-cover hover:opacity-90 transition">
                                                                        </a>
                                                                    @elseif(Str::startsWith($attachment['mime_type'], 'video/'))
                                                                        <video controls class="max-w-full rounded-lg">
                                                                            <source src="{{ asset('storage/' . $attachment['path']) }}"
                                                                                type="{{ $attachment['mime_type'] }}">
                                                                        </video>
                                                                    @elseif(Str::startsWith($attachment['mime_type'], 'audio/'))
                                                                        <!-- WhatsApp Theme Audio -->
                                                                        <div x-data="{ speed: 1, playing: false }"
                                                                            class="flex items-center gap-3 p-3 min-w-[220px]">
                                                                            <button
                                                                                @click="playing = !playing; $parent.playAudio('{{ $message->id }}-{{ $index }}')"
                                                                                class="shrink-0 w-9 h-9 flex items-center justify-center rounded-full shadow-sm transition-transform active:scale-95 {{ $isMe ? 'bg-white/20 text-white' : 'bg-brand-500 text-white' }}">
                                                                                <svg x-show="!playing" class="w-5 h-5" fill="currentColor"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path d="M8 5v14l11-7z" />
                                                                                </svg>
                                                                                <svg x-show="playing" class="w-5 h-5" fill="currentColor"
                                                                                    viewBox="0 0 24 24" x-cloak>
                                                                                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                                                                                </svg>
                                                                            </button>

                                                                            <div class="flex-1">
                                                                                <audio id="audio-{{ $message->id }}-{{ $index }}"
                                                                                    @playing="playing = true" @pause="playing = false"
                                                                                    @ended="playing = false" class="hidden">
                                                                                    <source src="{{ asset('storage/' . $attachment['path']) }}">
                                                                                </audio>
                                                                                <div
                                                                                    class="h-1 w-full bg-black/10 dark:bg-white/10 rounded-full overflow-hidden">
                                                                                    <div class="h-full bg-current opacity-60 transition-all duration-100"
                                                                                        style="width: 0%"
                                                                                        x-init="let a = document.getElementById('audio-{{ $message->id }}-{{ $index }}'); a.ontimeupdate = () => { $el.style.width = (a.currentTime / a.duration * 100) + '%' }">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex justify-between items-center mt-1.5">
                                                                                    <span class="text-[9px] font-bold opacity-70 tracking-tighter"
                                                                                        x-init="let a = document.getElementById('audio-{{ $message->id }}-{{ $index }}'); a.onloadedmetadata = () => { $el.innerText = Math.floor(a.duration / 60) + ':' + (Math.floor(a.duration % 60)).toString().padStart(2, '0') }">0:00</span>
                                                                                    <button
                                                                                        @click="speed = (speed === 1 ? 1.5 : (speed === 1.5 ? 2 : 1)); $parent.setPlaybackSpeed('{{ $message->id }}-{{ $index }}', speed)"
                                                                                        class="text-[9px] font-extrabold px-1.5 py-0.5 rounded-full {{ $isMe ? 'bg-white/20' : 'bg-zinc-100 dark:bg-zinc-700' }} transition-colors">
                                                                                        <span x-text="speed + 'x'"></span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="flex items-center gap-3 p-3">
                                                                            <div class="p-2 bg-brand-500 rounded-lg text-white">
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path
                                                                                        d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                                                                    <polyline points="14 2 14 8 20 8" />
                                                                                </svg>
                                                                            </div>
                                                                            <div class="flex-1 min-w-0">
                                                                                <p
                                                                                    class="text-xs font-semibold truncate {{ $isMe ? 'text-white' : 'text-zinc-800 dark:text-zinc-100' }}">
                                                                                    {{ $attachment['name'] }}</p>
                                                                                <p class="text-[9px] opacity-60">
                                                                                    {{ $this->formatFileSize($attachment['size']) }}</p>
                                                                            </div>
                                                                            <a href="{{ asset('storage/' . $attachment['path']) }}" download
                                                                                class="p-2 hover:bg-black/5 dark:hover:bg-white/5 rounded-full transition">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                                    stroke-width="2" viewBox="0 0 24 24">
                                                                                    <path
                                                                                        d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" />
                                                                                </svg>
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @if($message->content)
                                                        <p class="leading-relaxed text-[13px] sm:text-sm whitespace-pre-wrap font-medium">
                                                            {{ $message->content }}</p>
                                                    @endif
                                                </div>

                                                <!-- Time & Status -->
                                                <div class="flex items-center gap-1.5 mt-1 px-1">
                                                    <span class="text-[10px] font-medium text-zinc-400 dark:text-zinc-500">
                                                        {{ $message->created_at->diffForHumans(null, true) }}
                                                    </span>
                                                    @if($isMe)
                                                        <svg class="h-3.5 w-3.5 {{ $message->read_at ? 'text-brand-400' : 'text-zinc-300 dark:text-zinc-600' }}"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                            <path d="M2 12l5 5L20 4M7 12l5 5L22 4" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        @empty
                            <div class="h-full min-h-[400px] flex flex-col items-center justify-center space-y-4 opacity-40">
                                <div class="bg-zinc-100 dark:bg-zinc-800 p-6 rounded-full">
                                    <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold dark:text-zinc-500 uppercase tracking-widest">Inicie a conversa!
                                </p>
                            </div>
                        @endforelse
                        <div id="scroll-anchor" class="h-0"></div>
                    </div>
                </div>

                <!-- Chat Input Fixed Bottom -->
                <div
                    class="sticky bottom-0 bg-white dark:bg-zinc-900 border-t border-zinc-100 dark:border-white/5 p-4 sm:p-5 z-20">
                    <form wire:submit.prevent="sendMessage" class="flex items-end gap-2 sm:gap-4 max-w-6xl mx-auto" x-data="{ 
                                isRecording: false, 
                                mediaRecorder: null, 
                                audioChunks: [],
                                content: @entangle('content'),
                                isUploading: false,
                                autoResize() { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; }
                            }" x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false">

                        <div
                            class="flex-1 relative flex items-center bg-zinc-50 dark:bg-zinc-950/40 rounded-2xl border border-zinc-200 dark:border-white/10 focus-within:border-brand-500 focus-within:ring-4 focus-within:ring-brand-500/10 transition-all p-1.5 sm:p-2">

                            <!-- Attachments -->
                            <div class="relative px-1">
                                <input type="file" wire:model.live="attachments" id="file-upload" class="hidden" multiple>
                                <label for="file-upload"
                                    class="p-2 sm:p-2.5 text-zinc-400 hover:text-brand-500 transition cursor-pointer flex items-center justify-center relative">
                                    @if(count($attachments) > 0)
                                        <span
                                            class="absolute -top-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-brand-500 text-[9px] font-bold text-white shadow-sm ring-2 ring-zinc-50 dark:ring-zinc-900">{{ count($attachments) }}</span>
                                    @endif
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.51a2 2 0 0 1-2.83-2.83l8.49-8.48" />
                                    </svg>
                                </label>
                            </div>

                            <!-- Text Area -->
                            <textarea x-model="content" @input="autoResize()" @keydown.enter.prevent="$wire.sendMessage()"
                                placeholder="Diga algo..."
                                class="flex-1 min-h-[44px] max-h-[160px] bg-transparent border-none text-[15px] text-zinc-800 dark:text-zinc-100 placeholder:text-zinc-400 focus:ring-0 py-2.5 resize-none overflow-y-auto custom-scrollbar"></textarea>

                            <!-- Uploading State Overlay -->
                            <div x-show="isUploading"
                                class="absolute inset-0 bg-white/80 dark:bg-zinc-900/80 rounded-2xl flex items-center justify-center z-10"
                                x-cloak>
                                <svg class="animate-spin h-5 w-5 text-brand-500" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>

                            <!-- UI Recording Interaction Overlay -->
                            <div x-show="isRecording"
                                class="absolute inset-0 bg-white dark:bg-zinc-800 rounded-2xl flex items-center px-4 gap-4 z-30 animate-in fade-in zoom-in duration-200"
                                x-cloak>
                                <div class="flex items-center gap-3 flex-1">
                                    <span
                                        class="flex h-3 w-3 rounded-full bg-red-500 animate-pulse ring-4 ring-red-500/20"></span>
                                    <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Gravando
                                        Áudio...</span>
                                </div>
                                <button type="button" @click="mediaRecorder.stop(); isRecording = false;"
                                    class="text-xs font-bold text-zinc-500 hover:text-red-500 transition-colors uppercase">Cancelar</button>
                            </div>
                        </div>

                        <!-- Main Buttons -->
                        <div class="flex items-center gap-1.5 sm:gap-2 h-full">
                            <!-- Recording Trigger -->
                            <div x-show="!content && !($wire.attachments && $wire.attachments.length)"
                                class="h-11 sm:h-12 w-11 sm:w-12">
                                <button type="button" @mousedown="
                                            isRecording = true;
                                            navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                                                mediaRecorder = new MediaRecorder(stream, { mimeType: 'audio/webm' });
                                                mediaRecorder.start();
                                                audioChunks = [];
                                                mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
                                                mediaRecorder.onstop = () => {
                                                    const blob = new Blob(audioChunks, { type: 'audio/webm' });
                                                    if(isRecording) { @this.upload('audioAttachment', blob, n => $wire.sendAudioMessage()); }
                                                    stream.getTracks().forEach(t => t.stop());
                                                };
                                            }).catch(e => { isRecording = false; alert('Erro no microfone: ' + e.message); });
                                        " @mouseup="if(isRecording) mediaRecorder.stop(); isRecording = false;"
                                    class="h-full w-full flex items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-brand-500 transition-all hover:scale-105 active:scale-95 shadow-sm border border-zinc-200 dark:border-white/5">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z" />
                                        <path d="M19 10v2a7 7 0 0 1-14 0v-2" />
                                        <line x1="12" x2="12" y1="19" y2="22" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Send Action -->
                            <button type="submit" x-show="content || ($wire.attachments && $wire.attachments.length)"
                                class="h-11 sm:h-12 w-11 sm:w-12 flex items-center justify-center rounded-2xl bg-brand-500 text-white hover:bg-brand-600 transition-all hover:scale-105 active:scale-95 shadow-lg shadow-brand-500/25 animate-in slide-in-from-right-4 duration-300">
                                <svg class="w-5 h-5 ml-0.5" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 2L11 13M22 2L15 22L11 13M22 2L2 9L11 13" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Pending Upload List -->
                    @if(count($attachments) > 0)
                        <div class="mt-3 flex flex-wrap gap-2 animate-in slide-in-from-bottom-2 duration-300">
                            @foreach($attachments as $index => $file)
                                <div wire:key="pending-{{ $index }}"
                                    class="flex items-center gap-2 px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-white/5 shadow-sm group">
                                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                    </svg>
                                    <span
                                        class="text-[11px] font-semibold text-zinc-600 dark:text-zinc-300 truncate max-w-[120px]">{{ $file->getClientOriginalName() }}</span>
                                    <button type="button" wire:click="removeAttachment({{ $index }})"
                                        class="p-0.5 text-zinc-400 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M18 6L6 18M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <!-- Empty State View -->
                <div
                    class="flex-1 flex flex-col items-center justify-center p-12 text-center animate-in fade-in duration-700">
                    <div
                        class="w-32 h-32 bg-zinc-50 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-8 relative">
                        <div class="absolute inset-0 rounded-full bg-brand-500/5 animate-ping opacity-25"></div>
                        <svg class="w-12 h-12 text-brand-500" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">Sua Central de Mensagens</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 max-w-sm leading-relaxed">
                        Selecione um contato ao lado para iniciar uma conversa segura. Você pode enviar arquivos, fotos e
                        mensagens de voz em tempo real.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Global Styles for Scrollbar and Extras -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e4e4e7;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #27272a;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #d4d4d8;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #3f3f46;
        }
    </style>
</div>

@script
<script>
    Livewire.on('scroll-to-bottom', () => {
        const container = document.getElementById('chat-messages');
        if (container) {
            setTimeout(() => {
                container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
            }, 50);
        }
    });

    // Initial scroll
    setTimeout(() => {
        const container = document.getElementById('chat-messages');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }, 200);
</script>
@endscript