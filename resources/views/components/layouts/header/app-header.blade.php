<!-- ===== Header Start ===== -->
<header
    class="sticky top-0 z-50 w-full px-4 py-3 bg-white border-b border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 h-16">
    <div class="h-full flex items-center justify-between gap-4 relative">

        <!-- Left: Logo & Search -->
        <div class="flex items-center gap-4 lg:gap-8 shrink-0">
            <!-- Sidebar Toggle Button -->
            <button @click.stop="$store.sidebar.isExpanded = !$store.sidebar.isExpanded"
                class="p-2 -ml-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 focus:outline-none hidden xl:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <!-- Mobile Toggle -->
            <button @click.stop="$store.sidebar.setMobileOpen(!$store.sidebar.isMobileOpen)"
                class="p-2 -ml-2 mr-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 focus:outline-none xl:hidden">
                <!-- Menu Icon -->
                <svg x-show="!$store.sidebar.isMobileOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <!-- Close (X) Icon -->
                <svg x-show="$store.sidebar.isMobileOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

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
                <!-- Home (Timeline: Me + Following) -->
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
                <!-- Activities (Lightning: Only Me) -->
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
                    <a href="#" @click.prevent="$store.chatSidebar.toggle()"
                        class="flex items-center justify-center w-12 h-12 rounded-xl bg-zinc-50 text-zinc-400 hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 transition-colors relative">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <!-- Static Badge -->
                        <span
                            class="absolute top-2 right-2 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full border border-white dark:border-zinc-900">6</span>
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