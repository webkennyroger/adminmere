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
            document.body.classList.add('dark', 'bg-zinc-900');
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js Stores (Theme only, no sidebar needed) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark', 'bg-zinc-900');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-zinc-900');
                    }
                }
            });
        });
    </script>

    @livewireStyles
</head>

<body x-data="{ 'loaded': true}" class="bg-gray-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 min-h-screen">

    {{-- preloader --}}
    <x-common.preloader />

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex flex-col min-h-screen">

        <!-- ===== Header Start ===== -->
        <header
            class="sticky top-0 z-50 flex w-full bg-white border-b border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="container mx-auto px-4 max-w-7xl h-16 flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img class="w-8" src="{{ asset('assets/images/logo/merelogo.png') }}" alt="Mere App" />
                    <span
                        class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white hidden sm:block">Mere<span
                            class="text-brand-500">App</span></span>
                </a>

                <!-- Centered Navigation Icons -->
                <nav class="hidden md:flex flex-1 justify-center max-w-2xl mx-auto">
                    <ul class="flex items-center gap-6 lg:gap-10">
                        <!-- Home (Active) -->
                        <li>
                            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 p-2 text-brand-600 border-b-2 border-brand-600">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                </svg>
                            </a>
                        </li>

                        <!-- My Network -->
                        <li>
                            <a href="#" class="flex flex-col items-center gap-1 p-2 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </a>
                        </li>

                        <!-- Jobs -->
                        <li>
                            <a href="#" class="flex flex-col items-center gap-1 p-2 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </a>
                        </li>

                        <!-- Notifications -->
                        <li>
                            <a href="#" class="flex flex-col items-center gap-1 p-2 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors relative">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-1 right-1 flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full border-2 border-white dark:border-zinc-900">9+</span>
                            </a>
                        </li>

                        <!-- Messages -->
                        <li>
                            <a href="#" class="flex flex-col items-center gap-1 p-2 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors relative">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <span class="absolute top-1 right-1 flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full border-2 border-white dark:border-zinc-900">6</span>
                            </a>
                        </li>
                        
                        <!-- Profile (Generic Icon) -->
                        <li>
                            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 p-2 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Notifications -->
                    <livewire:layouts.header.notification-dropdown />

                    <!-- User Dropdown -->
                    <x-layouts.header.user-dropdown />
                </div>
            </div>
        </header>
        <!-- ===== Header End ===== -->

        <!-- ===== Content Area Start ===== -->
        <main class="flex-1 py-6 px-4">
            <div class="container mx-auto max-w-7xl">
                {{ $slot }}
            </div>
        </main>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

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
</body>

</html>