<div>
    <!-- Sidebar -->
    <aside
        class="fixed left-0 top-16 h-[calc(100vh-4rem)] bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 overflow-y-auto scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-700 z-40 transition-all duration-300 ease-in-out"
        :class="$store.userSidebar.isOpen ? 'w-64' : 'w-16'">

        <nav class="px-2 py-4 mt-5 space-y-1">
            <!-- Página Inicial -->
            <a href="{{ route('home') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                :class="!$store.userSidebar.isOpen && 'justify-center'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span x-show="$store.userSidebar.isOpen" class="text-sm font-medium whitespace-nowrap">Página
                    Inicial</span>
            </a>

            <!-- Meu Perfil -->
            <a href="{{ route('profile.view', Auth::user()) }}"
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                :class="!$store.userSidebar.isOpen && 'justify-center'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span x-show="$store.userSidebar.isOpen" class="text-sm font-medium whitespace-nowrap">Meu Perfil</span>
            </a>

            <!-- Desafios -->
            <a href="{{ route('challenges.index') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                :class="!$store.userSidebar.isOpen && 'justify-center'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                    </path>
                </svg>
                <span x-show="$store.userSidebar.isOpen" class="text-sm font-medium whitespace-nowrap">Desafios</span>
            </a>

            <!-- Estatísticas -->
            <a href="#"
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                :class="!$store.userSidebar.isOpen && 'justify-center'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <span x-show="$store.userSidebar.isOpen"
                    class="text-sm font-medium whitespace-nowrap">Estatísticas</span>
            </a>

            <!-- Comunidade -->
            <a href="#"
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                :class="!$store.userSidebar.isOpen && 'justify-center'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span x-show="$store.userSidebar.isOpen" class="text-sm font-medium whitespace-nowrap">Comunidade</span>
            </a>

            <!-- Minha Assinatura -->
            <a href="{{ route('billing.index') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                :class="!$store.userSidebar.isOpen && 'justify-center'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span x-show="$store.userSidebar.isOpen" class="text-sm font-medium whitespace-nowrap">Minha
                    Assinatura</span>
            </a>

            <!-- Suporte (com submenu) -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center gap-3 px-3 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                    :class="!$store.userSidebar.isOpen && 'justify-center'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span x-show="$store.userSidebar.isOpen"
                        class="flex-1 text-sm font-medium whitespace-nowrap text-left">Suporte</span>
                    <svg x-show="$store.userSidebar.isOpen" class="w-4 h-4 transition-transform shrink-0"
                        :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Submenu -->
                <div x-show="open && $store.userSidebar.isOpen" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('support.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        Lista de Tickets
                    </a>
                    <a href="{{ route('support.show', 1) }}"
                        class="block px-3 py-2 rounded-lg text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        Novo Ticket
                    </a>
                </div>
            </div>
        </nav>
    </aside>
</div>