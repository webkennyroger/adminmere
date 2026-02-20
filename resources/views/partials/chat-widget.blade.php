@if(auth()->check())
    <!-- Chat Sidebars and Boxes -->
    <livewire:chat.chat-sidebar />
    <livewire:chat.chat-box />

    <!-- Floating Chat Toggle Button -->
    <button @click="$store.chatSidebar.toggle()" id="floating-chat-button" style="z-index: 999999 !important;"
        class="fixed bottom-8 right-8 flex h-14 w-14 items-center justify-center rounded-2xl bg-success-600 hover:bg-success-700 shadow-xl shadow-success-500/30 transition-all duration-200 hover:scale-105 active:scale-95 border-2 border-success-400/40">
        <svg class="w-7 h-7 text-warning-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
            </path>
        </svg>

        @php
            $unreadCount = auth()->user()->messagesReceived()->whereNull('read_at')->count();
        @endphp

        @if($unreadCount > 0)
            <span
                class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-error-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-zinc-900">
                {{ $unreadCount }}
            </span>
        @endif
    </button>
@endif