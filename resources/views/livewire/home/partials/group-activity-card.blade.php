<!-- Spacer -->
<div class="h-6"></div>

<!-- Demo Card 3: Group Activity -->
<div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
    <!-- Header: Group Info -->
    <div class="p-4 flex items-center gap-3">
        <div
            class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center border border-zinc-200 dark:border-zinc-700">
            <img src="https://cdn-icons-png.flaticon.com/512/55/55239.png" class="w-6 h-6 opacity-60 dark:invert"
                alt="Running">
        </div>
        <div>
            <h4 class="text-sm font-bold text-zinc-900 dark:text-white">
                <span class="font-bold">Nadya Nascimento</span> correu com <span class="font-bold">Piter Padilha</span>
            </h4>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                1 de dezembro de 2025 · Cuiabá, Mato Grosso
            </p>
        </div>
    </div>

    <!-- Full Width Map -->
    <div class="w-full h-48 bg-zinc-100 dark:bg-zinc-800 relative">
        <img src="https://maps.googleapis.com/maps/api/staticmap?center=-15.601, -56.097&zoom=14&size=600x300&style=feature:all|element:all|saturation:-100|visibility:simplified&sensor=false&key=AIzaSyCka52TrH3u26pUrTyRwKkogWB-FdWA2bU"
            alt="Map Placeholder" class="w-full h-full object-cover opacity-80"
            onerror="this.src='https://placehold.co/600x300/e2e8f0/94a3b8?text=Mapa+da+Corrida+em+Grupo'">
    </div>

    <!-- User 1 Section (Nadya) -->
    <div x-data="{ showComments: false }" class="border-b border-zinc-100 dark:border-zinc-800">
        <div class="p-4">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Nadya+Nascimento&color=7F9CF5&background=EBF4FF"
                        class="w-10 h-10 rounded-full border border-zinc-200 dark:border-zinc-700">
                    <span class="font-bold text-sm text-zinc-900 dark:text-white">Nadya Nascimento</span>
                </div>
                <button class="text-zinc-400 hover:text-zinc-600">
                    <svg class="w-5 h-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-4">Corrida matinal</h3>

            <!-- Stats Grid -->
            <div class="flex gap-8 mb-4">
                <div>
                    <span class="block text-xs text-zinc-500 dark:text-zinc-400">Distância</span>
                    <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">5,01 km</span>
                </div>
                <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                    <span class="block text-xs text-zinc-500 dark:text-zinc-400">Ritmo</span>
                    <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">6:40 /km</span>
                </div>
                <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                    <span class="block text-xs text-zinc-500 dark:text-zinc-400">Tempo</span>
                    <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">33min 25s</span>
                </div>
                <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                    <span class="block text-xs text-zinc-500 dark:text-zinc-400">Conquistas</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5 text-zinc-700 dark:text-zinc-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 21h8M12 17v4M7 3h10a2 2 0 0 1 2 2v2a6 6 0 0 1-6 6 6 6 0 0 1-6-6V5a2 2 0 0 1 2-2Z" />
                        </svg>
                        <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">1</span>
                    </div>
                </div>
            </div>

            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">Rua Projetada/UFMT - 500m <span
                    class="font-bold">RP</span> (3:00)</p>

            <!-- Photos -->
            <div class="grid grid-cols-2 gap-2 mb-4">
                <div class="h-32 rounded-lg overflow-hidden bg-zinc-100 relative">
                    <img src="https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&w=400&q=80"
                        class="w-full h-full object-cover">
                </div>
                <div class="h-32 rounded-lg overflow-hidden bg-zinc-100 relative">
                    <img src="https://images.unsplash.com/photo-1552674605-5d28c475baa8?auto=format&fit=crop&w=400&q=80"
                        class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Footer Interactions -->
            <div class="flex items-center justify-between mt-2">
                <div class="flex items-center gap-2">
                    <div class="flex -space-x-2">
                        <img class="w-6 h-6 rounded-full border-2 border-white dark:border-zinc-900"
                            src="https://ui-avatars.com/api/?name=User+One&background=random" alt="">
                        <img class="w-6 h-6 rounded-full border-2 border-white dark:border-zinc-900"
                            src="https://ui-avatars.com/api/?name=User+Two&background=random" alt="">
                        <img class="w-6 h-6 rounded-full border-2 border-white dark:border-zinc-900"
                            src="https://ui-avatars.com/api/?name=User+Three&background=random" alt="">
                    </div>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">3 kudos</span>
                </div>
                <div class="flex gap-2">
                    <button class="p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                    </button>
                    <button @click="showComments = !showComments"
                        class="p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Comment Section -->
            <div x-show="showComments" style="display: none;" x-transition
                class="mt-3 pt-3 border-t border-zinc-100 dark:border-zinc-800 flex gap-3">
                <img src="{{ auth()->user()->image_url }}" class="w-8 h-8 rounded-full object-cover">
                <div class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center pr-2">
                    <input type="text" placeholder="Adicione um comentário..."
                        class="bg-transparent border-none w-full text-sm px-3 py-2 focus:ring-0 text-zinc-700 dark:text-zinc-200">
                    <button class="text-brand-600 font-semibold text-sm hover:text-brand-700 px-2">Publicar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User 2 Section (Piter) -->
    <div x-data="{ showComments: false }" class="p-4">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=Piter+Padilha&color=F87171&background=FEF2F2"
                    class="w-10 h-10 rounded-full border border-zinc-200 dark:border-zinc-700">
                <span class="font-bold text-sm text-zinc-900 dark:text-white">Piter Padilha</span>
            </div>
            <button class="text-zinc-400 hover:text-zinc-600">
                <svg class="w-5 h-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-4">Morning Run</h3>

        <!-- Stats Grid -->
        <div class="flex gap-8 mb-4">
            <div>
                <span class="block text-xs text-zinc-500 dark:text-zinc-400">Distância</span>
                <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">6,00 km</span>
            </div>
            <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                <span class="block text-xs text-zinc-500 dark:text-zinc-400">Ritmo</span>
                <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">5:51 /km</span>
            </div>
            <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                <span class="block text-xs text-zinc-500 dark:text-zinc-400">Tempo</span>
                <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">35min 11s</span>
            </div>
        </div>

        <!-- Footer Interactions -->
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-2">
                <span class="text-sm text-zinc-500 dark:text-zinc-400 px-2 py-1">Seja o primeiro a dar kudos!</span>
            </div>
            <div class="flex gap-2">
                <button class="p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </button>
                <button @click="showComments = !showComments"
                    class="p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Comment Section -->
        <div x-show="showComments" style="display: none;" x-transition
            class="mt-3 pt-3 border-t border-zinc-100 dark:border-zinc-800 flex gap-3">
            <img src="{{ auth()->user()->image_url }}" class="w-8 h-8 rounded-full object-cover">
            <div class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center pr-2">
                <input type="text" placeholder="Adicione um comentário..."
                    class="bg-transparent border-none w-full text-sm px-3 py-2 focus:ring-0 text-zinc-700 dark:text-zinc-200">
                <button class="text-brand-600 font-semibold text-sm hover:text-brand-700 px-2">Publicar</button>
            </div>
        </div>
    </div>
</div>