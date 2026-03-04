<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" flux-appearance="system">

<head>
    @include('partials.head')
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body x-data="{ loaded: true }"
    class="bg-zinc-100 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 min-h-screen font-sans">

    <x-common.preloader />

    <!-- ══════════ HEADER — SocialV Style ══════════ -->
    <header
        class="sticky top-0 z-50 w-full bg-white dark:bg-zinc-900 border-b border-zinc-200/80 dark:border-zinc-800 h-[70px] shadow-sm">
        <div class="h-full flex items-center justify-between px-4 lg:px-6 max-w-[1920px] mx-auto">

            <!-- LEFT: Logo + Toggle + Search -->
            <div class="flex items-center gap-4 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img class="w-9 h-9 rounded-lg" src="{{ asset('assets/images/logo/merelogo.png') }}" alt="Mere" />
                    <span
                        class="hidden sm:inline text-xl font-bold text-zinc-800 dark:text-white tracking-tight">Mere</span>
                </a>

                <div class="flex items-center gap-3">
                    <!-- Sidebar Toggle (mobile) -->
                    <flux:tooltip content="Abrir menu" position="bottom">
                        <button @click="$store.sidebar.isMobileOpen = !$store.sidebar.isMobileOpen"
                            class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </flux:tooltip>

                    <!-- Sidebar Toggle Desktop -->
                    <flux:tooltip content="Recolher menu" position="bottom">
                        <button @click.stop="$store.sidebar.isExpanded = !$store.sidebar.isExpanded"
                            class="hidden lg:flex w-10 h-10 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-500 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                            </svg>
                        </button>
                    </flux:tooltip>
                </div>

                <!-- Search -->
                <div class="hidden lg:flex items-center bg-zinc-100 dark:bg-zinc-800 rounded-full px-4 py-2 w-72">
                    <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Buscando algo?"
                        class="bg-transparent border-none outline-none text-sm w-full ml-2 text-zinc-600 dark:text-zinc-200 placeholder-zinc-400 focus:ring-0 p-0">
                </div>
            </div>



            <!-- RIGHT: Icons + Profile -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- Icon group -->
                <div class="flex items-center gap-0.5">
                    <!-- Home -->
                    <flux:tooltip content="Início" position="bottom">
                        <a href="{{ route('home') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                    </flux:tooltip>

                    <!-- Users / Find Friends -->
                    <flux:tooltip content="Encontrar amigos" position="bottom">
                        <a href="{{ route('users.find') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-zinc-50 dark:bg-zinc-800 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </flux:tooltip>

                    <!-- Messages -->
                    <flux:tooltip content="Mensagens" position="bottom">
                        <a href="{{ route('chat.index') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-zinc-50 dark:bg-zinc-800 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all relative">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            @if(auth()->check() && auth()->user()->messagesReceived()->whereNull('read_at')->count() > 0)
                                <span
                                    class="absolute -top-0.5 -right-0.5 w-4 h-4 text-[9px] font-bold text-white bg-red-500 rounded-full flex items-center justify-center border-2 border-white dark:border-zinc-900">
                                    {{ auth()->user()->messagesReceived()->whereNull('read_at')->count() }}
                                </span>
                            @endif
                        </a>
                    </flux:tooltip>

                    <!-- Notifications -->
                    <livewire:layouts.header.notification-dropdown />

                    @if(auth()->check() && auth()->user()->isAdmin())
                        <flux:tooltip content="Administração" position="bottom">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center justify-center w-10 h-10 rounded-xl bg-zinc-50 dark:bg-zinc-800 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </flux:tooltip>
                    @endif
                </div>

                <!-- User Dropdown -->
                <flux:tooltip content="Minha conta" position="bottom">
                    <x-layouts.header.user-dropdown />
                </flux:tooltip>
            </div>
        </div>
    </header>

    <!-- ══════════ MAIN WRAPPER ══════════ -->
    <div class="flex min-h-[calc(100vh-70px)] max-w-[1920px] mx-auto">

        <!-- ══════════ LEFT SIDEBAR — SocialV Style ══════════ -->
        <div class="shrink-0 hidden lg:block transition-all duration-300 ease-in-out sticky top-[70px] h-[calc(100vh-70px)] z-40"
            :class="{
                'w-[260px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'w-[80px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
            }">
            <aside
                class="flex flex-col w-full bg-white dark:bg-zinc-900 border-r border-zinc-200/80 dark:border-zinc-800 h-full overflow-y-auto no-scrollbar"
                @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
                @mouseleave="$store.sidebar.setHovered(false)">

                @auth
                    <!-- Perfil do Usuário (Componente Unificado) -->
                    <div class="p-2">
                        <livewire:home.partials.user-profile-card />
                    </div>


                    <!-- Collapsed state: just avatar -->
                    <div class="py-4 px-2 border-b border-zinc-200/80 dark:border-zinc-800 flex flex-col items-center"
                        x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered"
                        x-transition.opacity.duration.200ms>
                        <a href="{{ profile_url(auth()->user()) }}">
                            <img src="{{ auth()->user()->image_url }}"
                                class="w-10 h-10 rounded-full object-cover ring-2 ring-green-500/30 hover:ring-green-500 transition-all cursor-pointer"
                                alt="{{ auth()->user()->name }}">
                        </a>
                    </div>
                @endauth

                <!-- Menu Section -->
                <nav class="flex-1 py-4">
                    <ul class="space-y-1"
                        :class="($store.sidebar.isExpanded || $store.sidebar.isHovered) ? 'px-3' : 'px-2'">

                        <!-- Activity / Timeline -->
                        <li>
                            <a href="{{ route('home', ['feed' => 'personal']) }}"
                                class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all font-semibold text-[15px] whitespace-nowrap overflow-hidden
                                {{ request()->get('feed', 'timeline') === 'personal' && request()->routeIs('home') ? 'bg-green-500 text-white shadow-sm' : ' hover:bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 dark:hover:bg-zinc-800' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Minhas
                                    atividades</span>
                            </a>
                        </li>

                        <!-- Membros -->
                        <li>
                            <a href="{{ route('users.find') }}"
                                class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all font-semibold text-[15px] whitespace-nowrap overflow-hidden
                                {{ request()->routeIs('users.find') ? 'bg-green-500 text-white shadow-sm' : 'text-green-500 hover:text-zinc-900 hover:bg-green-100 dark:hover:bg-green-900/30 dark:text-green-400' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.49m-7.142 0A4.125 4.125 0 003 19.32a9.38 9.38 0 002.625-.372m0 0a9.337 9.337 0 004.121.952m0 0a9.337 9.337 0 004.121-.952m0 0A4.125 4.125 0 0015 19.128m0 0V18a2.25 2.25 0 00-2.25-2.25h-1.5A2.25 2.25 0 009 18v1.128m6-4.5A3.375 3.375 0 109 14.628v-1.128A3.375 3.375 0 1015 13.5v1.128z" />
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Usuarios</span>
                            </a>
                        </li>

                        <!-- Groups -->
                        <li>
                            <a href="#"
                                class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all font-semibold text-[15px] whitespace-nowrap overflow-hidden text-slate-500 hover:bg-slate-100 dark:hover:bg-zinc-800 dark:text-zinc-400">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Grupos</span>
                            </a>
                        </li>

                        <!-- Desafios -->
                        <li>
                            <a href="{{ route('challenges.index') }}"
                                class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all font-semibold text-[15px] whitespace-nowrap overflow-hidden
                                {{ request()->routeIs('challenges.*') ? 'bg-[#3b5998] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100 dark:hover:bg-zinc-800 dark:text-zinc-400' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Desafios</span>
                            </a>
                        </li>
                        <!-- Treinamentos -->
                        <li>
                            <a href="#"
                                class="flex items-center w-full gap-3.5 px-3 py-2.5 rounded-xl transition-all font-semibold text-[15px] whitespace-nowrap overflow-hidden text-slate-500 hover:bg-slate-100 dark:hover:bg-zinc-800 dark:text-zinc-400">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    class="flex-1 text-left">Treinamentos</span>
                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    class="w-4 h-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </li>

                        <!-- Chat -->
                        <li>
                            <a href="{{ route('chat.index') }}"
                                class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all font-semibold text-[15px] whitespace-nowrap overflow-hidden
                                {{ request()->routeIs('chat.*') ? 'bg-[#3b5998] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100 dark:hover:bg-zinc-800 dark:text-zinc-400' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Chat</span>
                            </a>
                        </li>

                        <!-- Assinaturas -->
                        <li>
                            <a href="{{ route('billing.index') }}"
                                class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all font-semibold text-[15px] whitespace-nowrap overflow-hidden
                                {{ request()->routeIs('billing.*') ? 'bg-[#3b5998] text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100 dark:hover:bg-zinc-800 dark:text-zinc-400' }}">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Assinatura</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Bottom Icons -->
                <div class="p-3 border-t border-zinc-200/80 dark:border-zinc-800">
                    <div class="flex items-center justify-around">
                        <a href="{{ route('home') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ route('users.find') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ route('challenges.index') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('profile') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        <!-- ══════════ CONTENT AREA ══════════ -->
        <main class="flex-1 min-w-0 transition-all duration-300">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800 shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
        <div class="flex items-center justify-around h-14">
            <a href="{{ route('home', ['feed' => 'timeline']) }}"
                class="flex flex-col items-center justify-center w-full h-full {{ request()->get('feed', 'timeline') === 'timeline' ? 'text-green-600 dark:text-green-400' : 'text-zinc-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="text-[10px] font-semibold mt-0.5">Início</span>
            </a>
            <a href="{{ route('users.find') }}"
                class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('users.find') ? 'text-green-600 dark:text-green-400' : 'text-zinc-400' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
                <span class="text-[10px] font-semibold mt-0.5">Comunidade</span>
            </a>
            <a href="{{ route('chat.index') }}"
                class="flex flex-col items-center justify-center w-full h-full relative {{ request()->routeIs('chat.*') ? 'text-green-600 dark:text-green-400' : 'text-zinc-400' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span class="text-[10px] font-semibold mt-0.5">Chat</span>
            </a>
            <a href="{{ auth()->check() ? route('profile.view', auth()->user()->handle ?? auth()->user()->id) : '#' }}"
                class="flex flex-col items-center justify-center w-full h-full text-zinc-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-[10px] font-semibold mt-0.5">Perfil</span>
            </a>
        </div>
    </nav>

    @include('partials.chat-widget')
    <x-toast.container />
    <x-ui.lightbox />

    @if(session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showToast('success', "{{ session('message') }}");
            });
        </script>
    @endif

    @fluxScripts
    @livewireScripts
    @stack('scripts')
</body>

</html>