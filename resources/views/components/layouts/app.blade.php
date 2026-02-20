<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" flux-appearance="system">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Home' }} | MERE APP</title>

    <script>
        // Theme initialization to prevent flash
        (function () {
            const theme = localStorage.getItem('theme') || 'system';
            if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Stores Initialization -->
    <script>
        function initGlobalStores() {
            if (!window.Alpine) return;

            // Sidebar Store
            if (!Alpine.store('sidebar')) {
                Alpine.store('sidebar', {
                    isExpanded: window.innerWidth >= 1280,
                    isMobileOpen: false,
                    isHovered: false,
                    init() {
                        window.addEventListener('resize', () => {
                            if (window.innerWidth < 1280) {
                                this.isMobileOpen = false;
                                this.isExpanded = false;
                            } else {
                                this.isMobileOpen = false;
                                this.isExpanded = true;
                            }
                        });
                    },
                    toggleExpanded() { this.isExpanded = !this.isExpanded; this.isMobileOpen = false; },
                    setMobileOpen(val) { this.isMobileOpen = val; },
                    setHovered(val) { if (window.innerWidth >= 1280 && !this.isExpanded) this.isHovered = val; }
                });
            }

            // Chat Sidebar Store
            if (!Alpine.store('chatSidebar')) {
                Alpine.store('chatSidebar', {
                    isOpen: false,
                    activeChat: null,
                    toggle() { this.isOpen = !this.isOpen; },
                    openChat(chat) { this.activeChat = chat; this.isOpen = true; },
                    close() { this.isOpen = false; }
                });
            }
        }

        // Initialize stores on multiple hooks
        document.addEventListener('alpine:init', initGlobalStores);
        document.addEventListener('livewire:init', initGlobalStores);
        document.addEventListener('DOMContentLoaded', initGlobalStores);
    </script>

    <!-- Quill CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @livewireStyles
    @stack('styles')
</head>

<body x-data="{ loaded: true }" class="min-h-screen bg-zinc-50 dark:bg-zinc-900 transition-colors duration-300">
    {{-- preloader --}}
    <x-common.preloader />

    <!-- ===== Page Wrapper Start ===== -->
    <div class="min-h-screen xl:flex">
        <!-- ===== Sidebar Start ===== -->
        <x-layouts.sidebar.sidebar />

        <!-- ===== Content Area Start ===== -->
        <div class="flex-1 transition-all duration-300 ease-in-out xl:ml-[90px]" :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- ===== Header Start ===== -->
            <x-layouts.header.app-header />

            <main class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6 transition-all duration-300"
                :style="$store.chatSidebar?.isOpen ? 'margin-right: 400px;' : ''">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Chat Components -->
    @if(!request()->is('chat*'))
        <livewire:chat.chat-sidebar />
        <livewire:chat.chat-box />

        <!-- Floating Chat Toggle Button -->
        <button @click="$store.chatSidebar.toggle()"
            class="fixed bottom-8 right-8 z-[99998] flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500 hover:bg-green-600 shadow-xl shadow-green-500/30 transition-all duration-200 hover:scale-105 active:scale-95 border-2 border-green-400/40">
            <svg class="w-7 h-7 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                </path>
            </svg>
            @if(auth()->check() && auth()->user()->messagesReceived()->whereNull('read_at')->count() > 0)
                <span
                    class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-zinc-900">
                    {{ auth()->user()->messagesReceived()->whereNull('read_at')->count() }}
                </span>
            @endif
        </button>
    @endif

    <!-- Toast Container -->
    <x-toast.container />

    @if(session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('success', "{{ session('message') }}");
            });
        </script>
    @endif

    @fluxScripts
    @livewireScripts

    <!-- Quill JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    @stack('scripts')
</body>

</html>