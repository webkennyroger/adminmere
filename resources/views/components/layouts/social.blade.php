<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Home' }} | MERE APP</title>

    <!-- Theme initialization -->
    <script>
        const savedTheme = localStorage.getItem('theme');
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        const theme = savedTheme || systemTheme;
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js Stores (Theme only, no sidebar needed) -->


    @livewireStyles
</head>

<body x-data="{ 'loaded': true}" class="bg-gray-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 min-h-screen">

    {{-- preloader
    <x-common.preloader />
    --}}

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex flex-col min-h-screen">

        <!-- ===== Header Start ===== -->
        <header
            class="sticky top-0 z-50 w-full p-10 bg-white border-b border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 h-16">
            <div class="px-4 h-full flex items-center justify-between gap-4 relative">

                <!-- Left: Logo & Search -->
                <div class="flex items-center gap-6 lg:gap-8 shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img class="w-8 h-8 lg:w-10 lg:h-10" src="{{ asset('assets/images/logo/merelogo.png') }}"
                            alt="Logo" />
                    </a>

                    <!-- Search Bar -->
                    <div class="hidden lg:flex items-center bg-zinc-100 dark:bg-zinc-800 rounded-full px-4 py-2.5 w-72">
                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" placeholder="Buscar..."
                            class="bg-transparent border-none outline-none text-sm w-full ml-2 text-zinc-600 dark:text-zinc-200 placeholder-zinc-400 focus:ring-0 p-0">
                    </div>
                </div>

                <!-- Center: Navigation -->
                <nav class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                    <ul class="flex items-center gap-3">
                        <!-- Home (Active) -->
                        <li>
                            <a href="{{ route('home', ['feed' => 'timeline']) }}"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-colors {{ request()->get('feed', 'timeline') === 'timeline' ? 'bg-brand-100 text-brand-600 dark:bg-brand-600/20 dark:text-brand-400' : 'bg-zinc-50 text-zinc-400 hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <!-- Network (Lightning: Me) -->
                        <li>
                            <a href="{{ route('home', ['feed' => 'personal']) }}"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-colors {{ request()->get('feed') === 'personal' ? 'bg-brand-100 text-brand-600 dark:bg-brand-600/20 dark:text-brand-400' : 'bg-zinc-50 text-zinc-400 hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </a>
                        </li>

                        <!-- Notifications -->
                        <li>
                            <livewire:layouts.header.notification-dropdown />
                        </li>

                        <!-- Messages -->
                        <li>
                            <a href="{{ route('chat.index') }}"
                                class="flex items-center justify-center w-12 h-12 rounded-xl bg-zinc-50 text-zinc-400 hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 transition-colors relative">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <!-- Unread Badge -->
                                @if(auth()->check() && auth()->user()->messagesReceived()->whereNull('read_at')->count() > 0)
                                    <span
                                        class="absolute top-2 right-2 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full border border-white dark:border-zinc-900">
                                        {{ auth()->user()->messagesReceived()->whereNull('read_at')->count() }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Right: Actions -->
                <div class="flex items-center justify-end shrink-0 gap-3 sm:gap-4">

                    <!-- Dark Mode Toggle -->
                    <x-common.dark-mode-toggle />
                    <!-- User Profile Dropdown -->
                    <x-layouts.header.user-dropdown />
                </div>
            </div>
        </header>
        <!-- ===== Header End ===== -->

        <!-- ===== Content Area Start ===== -->
        <main>
            {{ $slot }}
        </main>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <!-- Chat Sidebar & Overlay -->
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

    @livewireScripts

    <!-- Floating Chat Button (Opens Sidebar) -->
    <button @click="$store.chatSidebar.toggle()"
        style="position: fixed; bottom: 24px; right: 24px; left: auto; z-index: 9999;"
        class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-lg flex items-center justify-center transition-transform hover:scale-105 active:scale-95 group">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <!-- Unread Badge (Dynamic) -->
        @if(auth()->check() && auth()->user()->messagesReceived()->whereNull('read_at')->count() > 0)
            <span class="absolute top-3 right-3 w-3 h-3 bg-red-500 rounded-full border-2 border-blue-600"
                x-show="$store.chatSidebar && !$store.chatSidebar.isOpen"></span>
        @endif
    </button>


</body>

</html>