@if(auth()->check())
    <!-- Chat Sidebars and Boxes -->
    <livewire:chat.chat-sidebar />
    <livewire:chat.chat-box />

    <!-- Floating Chat Toggle Button -->
    <button id="floating-chat-button" @click="$store.chatSidebar.toggle()" style="
                    position: fixed;
                    bottom: 2rem;
                    right: 2rem;
                    z-index: 40;
                    width: 3.5rem;
                    height: 3.5rem;
                    border-radius: 1rem;
                    background-color: #16a34a;
                    border: 2px solid rgba(74, 222, 128, 0.4);
                    box-shadow: 0 10px 25px rgba(22, 163, 74, 0.4);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: transform 0.15s ease, background-color 0.15s ease;
                " onmouseover="this.style.backgroundColor='#15803d'; this.style.transform='scale(1.05)';"
        onmouseout="this.style.backgroundColor='#16a34a'; this.style.transform='scale(1)';"
        onmousedown="this.style.transform='scale(0.95)';" onmouseup="this.style.transform='scale(1.05)';">
        <svg style="width: 1.75rem; height: 1.75rem; color: #fde047;" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
            </path>
        </svg>

        @php
            $unreadCount = auth()->user()->messagesReceived()->whereNull('read_at')->count();
        @endphp

        @if($unreadCount > 0)
            <span style="
                                position: absolute;
                                top: -0.5rem;
                                right: -0.5rem;
                                width: 1.25rem;
                                height: 1.25rem;
                                background-color: #ef4444;
                                border-radius: 9999px;
                                border: 2px solid white;
                                font-size: 0.625rem;
                                font-weight: 700;
                                color: white;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                {{ $unreadCount }}
            </span>
        @endif
    </button>
@endif