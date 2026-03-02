<div wire:key="chat-box-wrapper">
 @if($isOpen && ($selectedUser || $selectedGroup))
 <div x-data="{
 isMinimized: @entangle('isMinimized'),
 isTyping: false,
 amITyping: false,
 isRecording: false,
 typingTimeout: null,
 typingAvatar: null,
 channel: null,
 init() {
 $wire.on('scroll-chat-to-bottom', () => { 
 if(!this.isMinimized) {
 var container = $refs.chatContainer;
 if(container) setTimeout(() => { container.scrollTop = container.scrollHeight; }, 100);
 }
 });
 
 if (typeof Echo !== 'undefined') {
 let channelName = null;
 @if($selectedGroup)
 channelName = 'chat.group.{{ $selectedGroup->id }}';
 @elseif($selectedUser && auth()->check())
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
 avatar: '{{ auth()->user()?->profile?->image ? Storage::url(auth()->user()->profile->image) : (auth()->user()?->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()?->name ?? 'User')) }}'
 });
 }
 }
 }" 
 x-init="init()"
 x-cloak
 class="fixed bottom-0 z-50 w-[calc(100%-2rem)] md:w-96 bg-white dark:bg-zinc-950 shadow-2xl border-x border-t border-zinc-200 dark:border-white/10 flex flex-col transition-all duration-300 overflow-hidden"
 :class="{
 'right-4 md:right-[26rem]': $store.chatSidebar?.isOpen,
 'right-4': !$store.chatSidebar?.isOpen,
 'h-[520px]': !isMinimized,
 'h-14 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800': isMinimized
 }">

 <!-- Header -->
 <div class="px-4 py-3 border-b border-zinc-100 dark:border-white/5 flex items-center justify-between bg-white dark:bg-zinc-950 shrink-0 h-14 z-20"
 @click="if(isMinimized) isMinimized = false">
 <div class="flex items-center gap-3 overflow-hidden">
 <!-- Internal Back Button -->
 <button @click.stop="$wire.closeChat()" class="md:hidden p-1.5 -ml-1 text-zinc-400 hover:text-brand-500 transition-colors">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
 </button>

 @php
 $avatarUrl = null;
 $displayName = '';
 if($selectedGroup) {
 $avatarUrl = $selectedGroup->image_url ?? 'https://ui-avatars.com/api/?name=G';
 $displayName = $selectedGroup->name;
 } elseif($selectedUser) {
 $avatarUrl = $selectedUser->profile?->image ? Storage::url($selectedUser->profile->image) : $selectedUser->image_url;
 $displayName = $selectedUser->name;
 }
 @endphp

 <div class="relative shrink-0">
 <div class="w-9 h-9 bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 overflow-hidden flex items-center justify-center font-bold text-zinc-500">
 @if($avatarUrl)
 <img src="{{ $avatarUrl }}" class="w-full h-full object-cover">
 @else
 {{ substr($displayName, 0, 1) }}
 @endif
 </div>
 @if($selectedUser)
 <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-zinc-900 "></span>
 @endif
 </div>

 <div class="flex flex-col min-w-0">
 <h3 class="font-bold text-zinc-900 dark:text-white text-sm truncate leading-tight">
 {{ $displayName }}
 </h3>
 <div class="flex items-center gap-1" x-show="!isMinimized">
 <span class="text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-tighter">Online</span>
 </div>
 </div>
 </div>

 <!-- Actions -->
 <div class="flex items-center gap-0.5">
 <button @click.stop="isMinimized = !isMinimized" class="w-8 h-8 flex items-center justify-center hover:bg-zinc-50 dark:hover:bg-zinc-800 text-zinc-400 dark:text-zinc-500 transition-all">
 <svg x-show="!isMinimized" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
 <svg x-show="isMinimized" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m10-10V6a2 2 0 00-2-2h-2m4 10v2a2 2 0 01-2 2h-2"></path></svg>
 </button>
 <button wire:click="closeChat" class="w-8 h-8 flex items-center justify-center hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 text-zinc-400 transition-all">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
 </button>
 </div>
 </div>

 <!-- Messages Window -->
 <div x-ref="chatContainer" 
 wire:ignore.self
 class="flex-1 overflow-y-auto p-4 space-y-4 bg-zinc-50/50 dark:bg-zinc-950/20 custom-scrollbar scroll-smooth"
 :class="isMinimized ? 'hidden' : 'block'">
 
 @forelse($chatMessages as $message)
 @php 
 $senderId = $message->sender_id ?? $message->user_id;
 $isMe = $senderId === auth()->id(); 
 @endphp
 
 <div class="flex {{ $isMe ? 'justify-end' : 'justify-start items-end gap-2' }}" wire:key="popup-msg-{{ $message->id }}">
 @if(!$isMe)
 <div class="w-6 h-6 bg-zinc-200 dark:bg-zinc-800 shrink-0 mb-1 border border-white dark:border-zinc-800 shadow-sm overflow-hidden flex items-center justify-center text-[8px] font-bold text-zinc-500">
 @if($message->sender?->profile?->image)
 <img src="{{ Storage::url($message->sender->profile->image) }}" class="w-full h-full object-cover">
 @else
 {{ substr($message->sender->name ?? '?', 0, 1) }}
 @endif
 </div>
 @endif

 <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }} max-w-[80%]">
 <div class="relative px-3 py-2 text-[13px] shadow-sm font-medium
 {{ $isMe 
 ? 'bg-brand-500 text-white ' 
 : 'bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 border border-zinc-100 dark:border-white/5' }}">
 
 @if(!empty($message->attachments))
 <div class="mb-2 space-y-1.5 last:mb-0">
 @foreach($message->attachments as $index => $at)
 <div class=" overflow-hidden border border-black/5 dark:border-white/5">
 @if(Str::startsWith($at['mime_type'], 'image/'))
 <img src="{{ asset('storage/' . $at['path']) }}" class="max-h-32 w-full object-cover">
 @else
 <div class="flex items-center gap-2 p-2 bg-zinc-50 dark:bg-zinc-950/50">
 <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
 <span class="text-[10px] truncate max-w-[100px]">{{ $at['name'] }}</span>
 </div>
 @endif
 </div>
 @endforeach
 </div>
 @endif
 {{ $message->content }}
 </div>
 <span class="text-[9px] text-zinc-400 mt-1 px-1">
 {{ $message->created_at->diffForHumans(null, true) }}
 </span>
 </div>
 </div>
 @empty
 <div class="flex-1 flex flex-col items-center justify-center h-full opacity-30 p-8 text-center bg-transparent">
 <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
 <p class="text-[11px] font-bold uppercase tracking-widest">Aguardando mensagem...</p>
 </div>
 @endforelse

 <!-- Indicators -->
 <div x-show="isTyping" class="flex gap-2 items-center" x-cloak>
 <div class="bg-zinc-100 dark:bg-zinc-800 p-2 px-3 flex items-center gap-1 shadow-sm">
 <span class="w-1 h-1 bg-zinc-400 animate-bounce"></span>
 <span class="w-1 h-1 bg-zinc-400 animate-bounce delay-75"></span>
 <span class="w-1 h-1 bg-zinc-400 animate-bounce delay-150"></span>
 </div>
 </div>

 <div id="popup-anchor" class="h-0"></div>
 </div>

 <!-- Footer / Input -->
 <div class="p-3 bg-white dark:bg-zinc-950 border-t border-zinc-100 dark:border-white/5 transition-all"
 :class="isMinimized ? 'hidden' : 'block'">
 
 <form wire:submit.prevent="sendMessage" class="flex items-center gap-2"
 x-data="{ 
 content: @entangle('content'),
 isUploading: false 
 }"
 x-on:livewire-upload-start="isUploading = true"
 x-on:livewire-upload-finish="isUploading = false"
 x-on:livewire-upload-error="isUploading = false">
 
 <div class="relative">
 <input type="file" wire:model.live="attachments" id="popup-file" class="hidden" multiple>
 <label for="popup-file" class="p-2 text-zinc-400 hover:text-brand-500 transition cursor-pointer flex items-center justify-center relative">
 @if(count($attachments) > 0)
 <span class="absolute -top-0.5 -right-0.5 w-3.5 h-3.5 bg-brand-500 text-white text-[8px] flex items-center justify-center font-bold">{{ count($attachments) }}</span>
 @endif
 <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.51a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
 </label>
 </div>

 <div class="flex-1 relative">
 <input x-model="content" 
 @input="broadcastTyping"
 @keydown.enter.prevent="$wire.sendMessage()"
 placeholder="Digite..." 
 class="w-full bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-white/5 py-2 px-4 text-sm focus:ring-1 focus:ring-brand-500 dark:text-white transition-all">
 
 <div x-show="isUploading" class="absolute right-3 top-1/2 -translate-y-1/2" x-cloak>
 <svg class="animate-spin h-3 w-3 text-brand-500" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
 </div>
 </div>

 <button type="submit" 
 class="bg-brand-500 hover:bg-brand-600 text-white p-2 shadow-md transition-all active:scale-90 disabled:opacity-50"
 {{ !$content && count($attachments) == 0 ? 'disabled' : '' }}>
 <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
 </button>
 </form>
 </div>
 </div>
 @endif
</div>