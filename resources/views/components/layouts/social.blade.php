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

            <!-- LEFT: Logo + Brand -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- Sidebar Toggle (mobile) -->
                <button @click="$store.sidebar.isMobileOpen = !$store.sidebar.isMobileOpen"
                    class="lg:hidden p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img class="w-9 h-9 rounded-lg" src="{{ asset('assets/images/logo/merelogo.png') }}" alt="Mere" />
                    <span
                        class="hidden sm:inline text-xl font-bold text-zinc-800 dark:text-white tracking-tight">Mere</span>
                </a>
            </div>

            <!-- CENTER: Navigation Links -->
            <nav class="hidden md:flex items-center gap-1 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                <a href="{{ route('home', ['feed' => 'timeline']) }}"
                    class="nav-link {{ request()->get('feed', 'timeline') === 'timeline' ? 'nav-link-active' : '' }}">
                    INÍCIO
                </a>
                <a href="{{ route('home', ['feed' => 'personal']) }}"
                    class="nav-link {{ request()->get('feed') === 'personal' ? 'nav-link-active' : '' }}">
                    ATIVIDADES
                </a>
                <a href="{{ route('users.find') }}"
                    class="nav-link {{ request()->routeIs('users.find') ? 'nav-link-active' : '' }}">
                    COMUNIDADE
                </a>
                <a href="{{ route('chat.index') }}"
                    class="nav-link {{ request()->routeIs('chat.*') ? 'nav-link-active' : '' }}">
                    MENSAGENS
                </a>
            </nav>

            <!-- RIGHT: Search + Icons + Profile -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- Search -->
                <div class="hidden lg:flex items-center bg-zinc-100 dark:bg-zinc-800 rounded-lg px-3 py-2 w-52">
                    <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Buscar..."
                        class="bg-transparent border-none outline-none text-sm w-full ml-2 text-zinc-600 dark:text-zinc-200 placeholder-zinc-400 focus:ring-0 p-0">
                </div>

                <!-- Icon group -->
                <div class="flex items-center gap-0.5">
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="header-icon" title="Admin">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    @endif

                    <!-- Users / Find Friends -->
                    <a href="{{ route('users.find') }}" class="header-icon" title="Encontrar amigos">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>

                    <!-- Messages -->
                    <a href="{{ route('chat.index') }}" class="header-icon relative">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
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

                    <!-- Notifications -->
                    <livewire:layouts.header.notification-dropdown />
                </div>

                <!-- User Dropdown -->
                <x-layouts.header.user-dropdown />
            </div>
        </div>
    </header>

    <!-- ══════════ MAIN WRAPPER ══════════ -->
    <div class="flex min-h-[calc(100vh-70px)] max-w-[1920px] mx-auto">

        <!-- ══════════ LEFT SIDEBAR — SocialV Style ══════════ -->
        <div class="relative shrink-0 hidden lg:block transition-all duration-300 ease-in-out" :class="{
                'w-[260px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'w-[80px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
            }">
            <aside
                class="flex flex-col w-full bg-white dark:bg-zinc-900 border-r border-zinc-200/80 dark:border-zinc-800 sticky top-[70px] h-[calc(100vh-70px)] overflow-y-auto no-scrollbar z-40"
                @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
                @mouseleave="$store.sidebar.setHovered(false)">

                @auth
                    <!-- Expanded state: centered profile card -->
                    <div class="border-b border-zinc-200/80 dark:border-zinc-800"
                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered" x-transition.opacity.duration.200ms>

                        <!-- Cover Banner -->
                        <div
                            class="h-20 bg-gradient-to-r from-zinc-200 via-zinc-100 to-zinc-200 dark:from-zinc-800 dark:via-zinc-700 dark:to-zinc-800 overflow-hidden">
                            @if(auth()->user()->cover_url)
                                <img src="{{ auth()->user()->cover_url }}" class="w-full h-full object-cover" alt="">
                            @endif
                        </div>

                        <!-- Avatar centered (overlaps banner) -->
                        <div class="flex flex-col items-center -mt-8 pb-3 px-4">
                            <a href="{{ profile_url(auth()->user()) }}" class="relative mb-3">
                                <img src="{{ auth()->user()->image_url }}"
                                    class="w-16 h-16 rounded-full object-cover border-3 border-white dark:border-zinc-900 shadow-md hover:ring-2 hover:ring-brand-500 transition-all cursor-pointer"
                                    alt="{{ auth()->user()->name }}">
                                @if(auth()->user()->isManager() || auth()->user()->isAdmin())
                                    <svg class="w-5 h-5 text-blue-500 absolute -bottom-0.5 -right-0.5 bg-white dark:bg-zinc-900 rounded-full p-0.5"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                    </svg>
                                @endif
                            </a>

                            <!-- Name centered -->
                            <a href="{{ profile_url(auth()->user()) }}" class="hover:text-brand-600 transition-colors">
                                <h4 class="text-[15px] font-bold text-zinc-900 dark:text-white text-center leading-tight">
                                    {{ auth()->user()->name }}
                                </h4>
                            </a>

                            <!-- Handle centered -->
                            <span
                                class="text-[13px] text-zinc-500 dark:text-zinc-400 mt-0.5">{{ '@' . (auth()->user()->handle ?? auth()->user()->id) }}</span>
                        </div>

                        <!-- Divider -->
                        <div class="mx-4 border-t border-zinc-200/80 dark:border-zinc-700"></div>

                        <!-- Stats row -->
                        <div class="flex items-center justify-center py-3 px-2">
                            <div class="flex-1 text-center">
                                <div class="text-[15px] font-bold text-brand-600 dark:text-brand-400">
                                    {{ auth()->user()->following()->count() }}
                                </div>
                                <div class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5">Seguindo</div>
                            </div>
                            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-700"></div>
                            <div class="flex-1 text-center">
                                <div class="text-[15px] font-bold text-brand-600 dark:text-brand-400">
                                    {{ auth()->user()->followers()->count() }}
                                </div>
                                <div class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5">Seguidores</div>
                            </div>
                            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-700"></div>
                            <div class="flex-1 text-center">
                                <div class="text-[15px] font-bold text-brand-600 dark:text-brand-400">
                                    {{ auth()->user()->activities()->count() }}
                                </div>
                                <div class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5">Atividades</div>
                            </div>
                        </div>

                        <!-- Meu perfil button -->
                        <div class="px-4 pb-4 pt-1">
                            <a href="{{ profile_url(auth()->user()) }}"
                                class="flex items-center justify-center gap-2 w-full py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Meu perfil
                            </a>
                        </div>
                    </div>

                    <!-- Collapsed state: just avatar -->
                    <div class="py-4 px-2 border-b border-zinc-200/80 dark:border-zinc-800 flex flex-col items-center"
                        x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered"
                        x-transition.opacity.duration.200ms>
                        <a href="{{ profile_url(auth()->user()) }}">
                            <img src="{{ auth()->user()->image_url }}"
                                class="w-10 h-10 rounded-full object-cover ring-2 ring-brand-500/30 hover:ring-brand-500 transition-all cursor-pointer"
                                alt="{{ auth()->user()->name }}">
                        </a>
                    </div>
                @endauth

                <!-- Menu Section -->
                <nav class="flex-1" :class="($store.sidebar.isExpanded || $store.sidebar.isHovered) ? 'p-3' : 'p-2'">
                    <h5 class="px-3 mb-2 text-[11px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider"
                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                        x-transition.opacity.duration.200ms>
                        Menu</h5>
                    <ul class="space-y-0.5">
                        <li>
                            <a href="{{ route('home', ['feed' => 'timeline']) }}"
                                class="sidebar-link {{ request()->get('feed', 'timeline') === 'timeline' && request()->routeIs('home') ? 'sidebar-link-active' : '' }}"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>Atividade</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.find') }}"
                                class="sidebar-link {{ request()->routeIs('users.find') ? 'sidebar-link-active' : '' }}"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>Membros</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('challenges.index') }}"
                                class="sidebar-link {{ request()->routeIs('challenges.*') ? 'sidebar-link-active' : '' }}"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>Desafios</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('chat.index') }}"
                                class="sidebar-link {{ request()->routeIs('chat.*') ? 'sidebar-link-active' : '' }}"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>Mensagens</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('billing.index') }}"
                                class="sidebar-link {{ request()->routeIs('billing.*') ? 'sidebar-link-active' : '' }}"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>Assinatura</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home', ['feed' => 'personal']) }}"
                                class="sidebar-link {{ request()->get('feed') === 'personal' ? 'sidebar-link-active' : '' }}"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>Estatísticas</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Support Section -->
                    <h5 class="px-3 mt-6 mb-2 text-[11px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider"
                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                        x-transition.opacity.duration.200ms>
                        Suporte</h5>
                    <div x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered"
                        class="my-4 border-t border-zinc-200/80 dark:border-zinc-800 mx-2"></div>
                    <ul class="space-y-0.5">
                        <li>
                            <a href="{{ route('support.index') }}"
                                class="sidebar-link {{ request()->routeIs('support.*') ? 'sidebar-link-active' : '' }}"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>Ajuda</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-link"
                                :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered) ? 'justify-center' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered"
                                    x-transition.opacity.duration.200ms>FAQ</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Bottom Icons -->
                <div class="p-3 border-t border-zinc-200/80 dark:border-zinc-800">
                    <div class="flex items-center justify-around">
                        <a href="{{ route('home') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ route('users.find') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </a>
                        <a href="{{ route('challenges.index') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('profile') }}"
                            class="p-2 rounded-lg text-zinc-400 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-600/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Toggle Arrow — outside aside, on the border -->
            <button @click="$store.sidebar.toggleExpanded()"
                class="absolute top-28 -right-3.5 w-7 h-7 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm flex items-center justify-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-all z-50 cursor-pointer"
                :title="$store.sidebar.isExpanded ? 'Fechar sidebar' : 'Abrir sidebar'">
                <svg class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" :class="$store.sidebar.isExpanded ? '' : 'rotate-180'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
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
                class="flex flex-col items-center justify-center w-full h-full {{ request()->get('feed', 'timeline') === 'timeline' ? 'text-brand-600 dark:text-brand-400' : 'text-zinc-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="text-[10px] font-semibold mt-0.5">Início</span>
            </a>
            <a href="{{ route('users.find') }}"
                class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('users.find') ? 'text-brand-600 dark:text-brand-400' : 'text-zinc-400' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
                <span class="text-[10px] font-semibold mt-0.5">Comunidade</span>
            </a>
            <a href="{{ route('chat.index') }}"
                class="flex flex-col items-center justify-center w-full h-full relative {{ request()->routeIs('chat.*') ? 'text-brand-600 dark:text-brand-400' : 'text-zinc-400' }}">
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