<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | MERE APP</title>


    <!-- Critical Stores Initialization -->
    <script>
        // Theme Pre-check
        const savedTheme = localStorage.getItem('theme');
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        const theme = savedTheme || systemTheme;
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            // Ensure body gets the class as soon as it exists (DOMContentLoaded or later)
            document.addEventListener('DOMContentLoaded', () => {
                document.body.classList.add('dark', 'bg-zinc-900');
            });
        }

        // Define Store Initialization Logic
        function initMyStores() {
            if (!window.Alpine) return;

            // Theme Store
            if (!Alpine.store('theme')) {
                Alpine.store('theme', {
                    theme: theme,
                    toggle() {
                        this.theme = this.theme === 'light' ? 'dark' : 'light';
                        localStorage.setItem('theme', this.theme);
                        if (this.theme === 'dark') {
                            document.documentElement.classList.add('dark');
                            if (document.body) document.body.classList.add('dark', 'bg-zinc-900');
                        } else {
                            document.documentElement.classList.remove('dark');
                            if (document.body) document.body.classList.remove('dark', 'bg-zinc-900');
                        }
                    }
                });
            }

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

        // Attempt initialization on multiple hooks to catch the right moment
        document.addEventListener('alpine:init', initMyStores);
        document.addEventListener('livewire:init', initMyStores);
        document.addEventListener('DOMContentLoaded', initMyStores);

        // Immediate check (if Alpine is already loaded via defer)
        if (window.Alpine) initMyStores();
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Quill CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Alpine.js -->
    {{--
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}


    <!-- Livewire styles -->
    @livewireStyles



    <!-- Additional styles -->
    @stack('styles')



</head>

<body x-data="{ 'loaded': true}">

    {{-- preloader --}}
    <x-common.preloader />
    {{-- preloader end --}}


    <!-- ===== Page Wrapper Start ===== -->
    <div class="min-h-screen xl:flex">
        <!-- ===== Sidebar Start ===== -->
        <x-layouts.sidebar.sidebar />
        <!-- ===== Sidebar End ===== -->
        <!-- ===== Content Area Start ===== -->
        <div class="flex-1 transition-all duration-300 ease-in-out xl:ml-[90px]" :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- ===== Header Start ===== -->
            <x-layouts.header.app-header />
            <!-- ===== Header End ===== -->
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6 transition-all duration-300" x-data
                :style="$store.chatSidebar?.isOpen ? 'margin-right: 400px;' : ''">
                {{ $slot }}
            </div>
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <!-- Chat Components -->
    <livewire:chat.chat-sidebar />
    <livewire:chat.chat-box />

    <!-- Toast Container -->
    <x-toast.container />

    @if(session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('success', "{{ session('message') }}");
            });
        </script>
    @endif

    <!-- Quill JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <!-- Livewire scripts -->
    @livewireScripts
    @stack('scripts')
</body>

</html>