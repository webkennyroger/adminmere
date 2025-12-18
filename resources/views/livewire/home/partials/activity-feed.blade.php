<div class="space-y-6">
    <!-- Create Post / Status Update -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4 shadow-sm">
        <div class="flex gap-4">
            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                class="w-12 h-12 rounded-full object-cover border border-zinc-100 dark:border-zinc-800">
            <div class="flex-1">
                <button
                    class="w-full text-left px-5 py-3.5 bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700/80 rounded-full text-zinc-500 dark:text-zinc-400 text-sm font-medium transition-all duration-200 border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    No que você está pensando?
                </button>
                <div class="flex justify-between items-center mt-3 px-2">
                    <div class="flex gap-4">
                        <button
                            class="flex items-center gap-1.5 text-zinc-500 hover:text-brand-600 text-xs font-medium transition-colors">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Foto
                        </button>
                        <button
                            class="flex items-center gap-1.5 text-zinc-500 hover:text-brand-600 text-xs font-medium transition-colors">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Vídeo
                        </button>
                        <button
                            class="flex items-center gap-1.5 text-zinc-500 hover:text-brand-600 text-xs font-medium transition-colors">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Evento
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Feed Items -->
    @forelse($activities as $activity)
        <div x-data="{ showComments: false }"
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
            <!-- Header -->
            <div class="p-4 flex items-center gap-3">
                <img src="{{ $activity->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($activity->user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                    class="w-10 h-10 rounded-full object-cover">
                <div>
                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white">{{ $activity->user->name }}</h4>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }} •
                        @if($activity->type == 'challenge_joined') Ingressou em um desafio @else Completou um desafio @endif
                    </p>
                </div>
            </div>

            <!-- Content -->
            <div class="px-4 pb-2">
                <p class="text-sm text-zinc-800 dark:text-zinc-200 mb-3">
                    Estou participando do desafio <strong>{{ $activity->challenge->title }}</strong>!
                    Minha meta é completar {{ $activity->challenge->goal_km }} km. 🚀
                </p>
                @if($activity->challenge->image)
                    <div class="rounded-lg overflow-hidden border border-zinc-100 dark:border-zinc-800 mb-3">
                        <img src="{{ Storage::url($activity->challenge->image) }}" class="w-full h-64 object-cover">
                        <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50">
                            <h5 class="font-semibold text-sm text-zinc-900 dark:text-white">{{ $activity->challenge->title }}
                            </h5>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ $activity->challenge->category->name ?? 'Geral' }} •
                                {{ $activity->challenge->start_date->format('d/m') }} -
                                {{ $activity->challenge->end_date->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer (Likes/Comments/Share) -->
            <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                <div class="flex gap-4">
                    <button class="flex items-center gap-1 text-zinc-500 hover:text-brand-600 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        <span>0</span>
                    </button>
                    <button @click="showComments = !showComments"
                        class="flex items-center gap-1 text-zinc-500 hover:text-brand-600 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>0</span>
                    </button>
                </div>
                <!-- Share -->
                <button class="text-zinc-500 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                </button>
            </div>

            <!-- Comment Section -->
            <div x-show="showComments" style="display: none;" x-transition
                class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 flex gap-3">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                    class="w-8 h-8 rounded-full object-cover border border-zinc-100 dark:border-zinc-800">
                <div class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center pr-2">
                    <input type="text" placeholder="Adicione um comentário, @ para mencionar"
                        class="bg-transparent border-none w-full text-sm px-3 py-2 focus:ring-0 text-zinc-700 dark:text-zinc-200 placeholder-zinc-400">
                    <button
                        class="text-brand-600 font-semibold text-sm hover:text-brand-700 px-2 transition-colors">Publicar</button>
                </div>
            </div>
        </div>
    @empty
        <div x-data="{ showComments: false }"
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
            <!-- Header -->
            <div class="p-4 flex items-start justify-between">
                <div class="flex gap-3">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                        class="w-10 h-10 rounded-full object-cover border border-zinc-100 dark:border-zinc-800">
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white">
                            {{ auth()->user()->name }}
                        </h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            Ontem às 06:59 · Mere App · Cuiabá, Mato Grosso
                        </p>
                    </div>
                </div>
                <button class="text-zinc-400 hover:text-zinc-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <!-- Title & Description -->
            <div class="px-4 pb-2 flex gap-3">
                <div class="shrink-0 mt-1">
                    <img src="https://cdn-icons-png.flaticon.com/512/55/55239.png" class="w-6 h-6 opacity-60 dark:invert"
                        alt="Running">
                </div>
                <div class="flex flex-col">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white leading-tight">Corrida matinal</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        descrição da corrida
                    </p>
                </div>
            </div>

            <!-- Map Placeholder -->
            <div class="px-4 pb-4 mt-2">
                <div class="w-full h-48 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden relative">
                    <img src="https://maps.googleapis.com/maps/api/staticmap?center=-15.601, -56.097&zoom=14&size=600x300&style=feature:all|element:all|saturation:-100|visibility:simplified&sensor=false&key="
                        alt="Map Placeholder" class="w-full h-full object-cover opacity-80"
                        onerror="this.src='https://placehold.co/600x300/e2e8f0/94a3b8?text=Mapa+da+Corrida'">
                </div>

                <!-- Stats Grid (Centered) -->
                <div class="flex justify-center mt-4 mb-2">
                    <div class="flex gap-8 text-center">
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Distância</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">4,18 km</span>
                        </div>
                        <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Ritmo</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">4:55 /km</span>
                        </div>
                        <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Tempo</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">20min 35s</span>
                        </div>
                        <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Conquistas</span>
                            <div class="flex items-center justify-center gap-1">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 21h8M12 17v4M7 3h10a2 2 0 0 1 2 2v2a6 6 0 0 1-6 6 6 6 0 0 1-6-6V5a2 2 0 0 1 2-2Z" />
                                </svg>
                                <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">1</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Achievement Banner -->
                <div class="mt-2 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3 flex items-center gap-3">
                    <div class="text-orange-500 shrink-0">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            Parabéns! Você acabou seu 3º tempo mais rápido na milha!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                <div class="flex gap-4">
                    <button class="flex items-center gap-1 text-zinc-500 hover:text-brand-600 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        <span>0</span>
                    </button>
                    <button @click="showComments = !showComments"
                        class="flex items-center gap-1 text-zinc-500 hover:text-brand-600 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>0</span>
                    </button>
                </div>
                <button class="text-zinc-500 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                </button>
            </div>

            <!-- Comment Section -->
            <div x-show="showComments" style="display: none;" x-transition
                class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 flex gap-3">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                    class="w-8 h-8 rounded-full object-cover border border-zinc-100 dark:border-zinc-800">
                <div class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center pr-2">
                    <input type="text" placeholder="Adicione um comentário, @ para mencionar"
                        class="bg-transparent border-none w-full text-sm px-3 py-2 focus:ring-0 text-zinc-700 dark:text-zinc-200 placeholder-zinc-400">
                    <button
                        class="text-brand-600 font-semibold text-sm hover:text-brand-700 px-2 transition-colors">Publicar</button>
                </div>
            </div>
        </div>

        <!-- Spacer -->
        <div class="h-6"></div>

        <!-- Demo Card 2: Activity with Images -->
        <div x-data="{ showComments: false }"
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
            <!-- Header -->
            <div class="p-4 flex items-start justify-between">
                <div class="flex gap-3">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                        class="w-10 h-10 rounded-full object-cover border border-zinc-100 dark:border-zinc-800">
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            7 de dez. de 2025 · Mere App · Cuiabá, Mato Grosso
                        </p>
                    </div>
                </div>
                <button class="text-zinc-400 hover:text-zinc-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <!-- Title & Description -->
            <div class="px-4 pb-2 flex gap-3">
                <div class="shrink-0 mt-1">
                    <img src="https://cdn-icons-png.flaticon.com/512/55/55239.png" class="w-6 h-6 opacity-60 dark:invert"
                        alt="Running">
                </div>
                <div class="flex flex-col">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white leading-tight">Cuiabá Corrida</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        descrição da corrida
                    </p>
                </div>
            </div>

            <!-- Media Content (Map + Images) -->
            <div class="px-4 pb-4 mt-2">
                <!-- Map -->
                <div class="w-full h-48 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden relative mb-2">
                    <img src="https://maps.googleapis.com/maps/api/staticmap?center=-15.596, -56.096&zoom=13&size=600x300&style=feature:all|element:all|saturation:-100|visibility:simplified&sensor=false&key="
                        alt="Map Placeholder" class="w-full h-full object-cover opacity-80"
                        onerror="this.src='https://placehold.co/600x300/e2e8f0/94a3b8?text=Mapa+da+Corrida'">
                </div>

                <!-- Images Grid -->
                <div class="grid grid-cols-3 gap-2">
                    <div class="h-32 rounded-lg overflow-hidden bg-zinc-100 relative group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1552674605-5d28c475baa8?auto=format&fit=crop&w=400&q=80"
                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="h-32 rounded-lg overflow-hidden bg-zinc-100 relative group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1571008887538-b36bb32f4571?auto=format&fit=crop&w=400&q=80"
                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="h-32 rounded-lg overflow-hidden bg-zinc-100 relative group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1483729558449-99ef09a8c325?auto=format&fit=crop&w=400&q=80"
                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                </div>

                <!-- Stats Grid (Centered) -->
                <div class="flex justify-center mt-4 mb-4">
                    <div class="flex gap-8 text-center">
                        <div>
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Distância</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">11,01 km</span>
                        </div>
                        <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Ritmo</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">7:39 /km</span>
                        </div>
                        <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Tempo</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">1h 24min</span>
                        </div>
                        <div class="border-l border-zinc-200 dark:border-zinc-700 pl-8">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Conquistas</span>
                            <div class="flex items-center justify-center gap-1">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 21h8M12 17v4M7 3h10a2 2 0 0 1 2 2v2a6 6 0 0 1-6 6 6 6 0 0 1-6-6V5a2 2 0 0 1 2-2Z" />
                                </svg>
                                <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Achievement Banner -->
                <div class="mt-2 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3 flex items-center gap-3">
                    <div class="text-orange-500 shrink-0">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            Parabéns! Você acabou seu 3º tempo mais rápido na milha!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
                <div class="flex gap-4">
                    <button class="flex items-center gap-1 text-zinc-500 hover:text-brand-600 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        <span>0</span>
                    </button>
                    <button @click="showComments = !showComments"
                        class="flex items-center gap-1 text-zinc-500 hover:text-brand-600 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>0</span>
                    </button>
                </div>
                <button class="text-zinc-500 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                </button>
            </div>

            <!-- Comment Section -->
            <div x-show="showComments" style="display: none;" x-transition
                class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 flex flex-col gap-3">

                <!-- Comments List (Mock for Demo 2) -->
                <div class="flex gap-3 mb-2" x-data="{ showReplies: false, liked: false, replyLiked: false }">
                    <img src="https://ui-avatars.com/api/?name=Visitante+teste&background=E9D5FF&color=6B21A8"
                        class="w-8 h-8 rounded-full border border-zinc-100 dark:border-zinc-800 shrink-0">

                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div class="bg-zinc-100 dark:bg-zinc-800 rounded-2xl rounded-tl-none px-4 py-2">
                                <p class="font-bold text-sm text-zinc-900 dark:text-white">Visitante teste</p>
                            </div>
                            <button @click="liked = !liked" class="text-zinc-400 hover:text-red-500 transition-colors"
                                :class="{ 'text-red-500': liked }">
                                <svg class="w-4 h-4" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center gap-4 mt-1 ml-2 text-xs text-zinc-500 dark:text-zinc-400">
                            <span>agora</span>
                            <button class="font-semibold hover:underline">Responder</button>
                        </div>

                        <div class="mt-2 text-xs">
                            <button @click="showReplies = !showReplies"
                                class="flex items-center gap-2 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                                <div class="w-8 h-px bg-zinc-300 dark:bg-zinc-700"></div>
                                <span x-text="showReplies ? 'Ocultar respostas' : 'Visualizar respostas (1)'"></span>
                            </button>
                        </div>

                        <!-- Nested Reply -->
                        <div x-show="showReplies" style="display: none;" x-transition class="mt-3 flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Visitante+testey&background=F3E8FF&color=7E22CE"
                                class="w-8 h-8 rounded-full border border-zinc-100 dark:border-zinc-800 shrink-0">
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <div class="bg-zinc-100 dark:bg-zinc-800 rounded-2xl rounded-tl-none px-4 py-2">
                                        <p class="font-bold text-sm text-zinc-900 dark:text-white">Visitante testey</p>
                                    </div>
                                    <button @click="replyLiked = !replyLiked"
                                        class="text-zinc-400 hover:text-red-500 transition-colors"
                                        :class="{ 'text-red-500': replyLiked }">
                                        <svg class="w-4 h-4" :fill="replyLiked ? 'currentColor' : 'none'"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center gap-4 mt-1 ml-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>agora</span>
                                    <button class="font-semibold hover:underline">Responder</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 w-full">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                        class="w-8 h-8 rounded-full object-cover border border-zinc-100 dark:border-zinc-800">
                    <div class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center pr-2">
                        <input type="text" placeholder="Adicione um comentário, @ para mencionar"
                            class="bg-transparent border-none w-full text-sm px-3 py-2 focus:ring-0 text-zinc-700 dark:text-zinc-200 placeholder-zinc-400">
                        <button
                            class="text-brand-600 font-semibold text-sm hover:text-brand-700 px-2 transition-colors">Publicar</button>
                    </div>
                </div>
            </div>

    @endforelse

        @include('livewire.home.partials.group-activity-card')

    </div>