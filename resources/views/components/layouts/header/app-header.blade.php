<!-- ===== Header Start ===== -->
<header
    class="sticky top-0 z-50 w-full px-4 py-3 bg-white border-b border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 h-16">
    <div class="h-full flex items-center justify-between gap-4 relative">

        <!-- Left: Logo & Search -->
        <div class="flex items-center gap-4 lg:gap-6 shrink-0">
            <!-- Sidebar Toggle Button (desktop) -->
            <flux:tooltip content="Recolher menu" position="bottom">
                <button @click.stop="$store.sidebar.isExpanded = !$store.sidebar.isExpanded"
                    class="p-2 -ml-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 focus:outline-none hidden xl:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </flux:tooltip>

            <!-- Search Bar -->
            <div class="hidden lg:flex items-center bg-zinc-100 dark:bg-zinc-800 rounded-full px-4 py-2.5 w-80">
                <svg class="w-5 h-5 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Search Here"
                    class="bg-transparent border-none outline-none text-sm w-full ml-2 text-zinc-600 dark:text-zinc-200 placeholder-zinc-400 focus:ring-0 p-0">
            </div>
        </div>

        <!-- Center: Navigation (desktop) -->
        <nav class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
            <ul class="flex items-center gap-1">
                <!-- Home -->
                <li>
                    <flux:tooltip content="Início" position="bottom">
                        <a href="{{ route('home', ['feed' => 'timeline']) }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl transition-colors
                                {{ request()->get('feed', 'timeline') === 'timeline' ? 'bg-brand-100 text-brand-600 dark:bg-brand-600/20 dark:text-brand-400' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </flux:tooltip>
                </li>

                <!-- Encontrar Amigos -->
                <li>
                    <flux:tooltip content="Encontrar amigos" position="bottom">
                        <a href="{{ route('home', ['feed' => 'personal']) }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl transition-colors
                                {{ request()->get('feed') === 'personal' ? 'bg-brand-100 text-brand-600 dark:bg-brand-600/20 dark:text-brand-400' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </a>
                    </flux:tooltip>
                </li>

                <!-- Chat / Mensagens -->
                <li>
                    <flux:tooltip content="Mensagens" position="bottom">
                        <a href="{{ route('chat.index') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl transition-colors relative
                                {{ request()->routeIs('chat.*') ? 'bg-brand-100 text-brand-600 dark:bg-brand-600/20 dark:text-brand-400' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            @if(auth()->check() && auth()->user()->messagesReceived()->whereNull('read_at')->count() > 0)
                                <span
                                    class="absolute top-2 right-2 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full border border-white dark:border-zinc-900">
                                    {{ auth()->user()->messagesReceived()->whereNull('read_at')->count() }}
                                </span>
                            @endif
                        </a>
                    </flux:tooltip>
                </li>

                <!-- Notificações -->
                <li>
                    <livewire:layouts.header.notification-dropdown />
                </li>

                <!-- Configurações -->
                <li>
                    <flux:tooltip content="Configurações" position="bottom">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl transition-colors
                                {{ request()->routeIs('profile.*') ? 'bg-brand-100 text-brand-600 dark:bg-brand-600/20 dark:text-brand-400' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </flux:tooltip>
                </li>
            </ul>
        </nav>

        <!-- Right: Actions -->
        <div class="flex items-center justify-end shrink-0 gap-3">

            <!-- Mobile Toggle (Hamburger) -->
            <flux:tooltip content="Menu" position="bottom">
                <button @click.stop="$store.sidebar.setMobileOpen(!$store.sidebar.isMobileOpen)"
                    class="flex items-center justify-center w-10 h-10 rounded-lg bg-zinc-100/50 hover:bg-zinc-100 dark:bg-zinc-800/50 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 focus:outline-none xl:hidden transition-all">
                    <svg x-show="!$store.sidebar.isMobileOpen" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="$store.sidebar.isMobileOpen" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </flux:tooltip>

            <!-- Chat (mobile only) -->
            <flux:tooltip content="Mensagens" position="bottom">
                <a href="{{ route('chat.index') }}"
                    class="flex md:hidden items-center justify-center w-10 h-10 rounded-lg transition-all relative
                        {{ request()->routeIs('chat.*') ? 'bg-brand-100 text-brand-600 dark:bg-brand-600/20 dark:text-brand-400' : 'bg-zinc-100/50 text-zinc-600 hover:bg-zinc-100 dark:bg-zinc-800/50 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    @if(auth()->check() && auth()->user()->messagesReceived()->whereNull('read_at')->count() > 0)
                        <span
                            class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-zinc-900"></span>
                    @endif
                </a>
            </flux:tooltip>

            <!-- Notifications (mobile only) -->
            <div class="md:hidden">
                <livewire:layouts.header.notification-dropdown />
            </div>

            <!-- User Profile Dropdown -->
            <x-layouts.header.user-dropdown />
        </div>
    </div>
</header>
<!-- ===== Header End ===== -->