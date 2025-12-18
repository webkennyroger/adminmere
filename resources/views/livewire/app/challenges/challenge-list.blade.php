<div>
    <x-common.page-breadcrumb title="Desafios" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @forelse($challenges as $challenge)
            @php
                $userChallenge = $challenge->users->first(); // Since we filtered by auth user in query
                $isJoined = $userChallenge !== null;
                $progress = $isJoined ? $userChallenge->pivot->progress : 0;
                $percent = $challenge->goal_km > 0 ? min(100, ($progress / $challenge->goal_km) * 100) : 0;
            @endphp

            <div
                class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden flex flex-col h-full shadow-theme-xs">
                <!-- Challenge Image -->
                <div class="h-48 bg-zinc-100 dark:bg-zinc-800 w-full relative">
                    @if($challenge->image)
                        <img src="{{ Storage::url($challenge->image) }}" alt="{{ $challenge->title }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center w-full h-full text-zinc-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/90 text-zinc-800 shadow-sm backdrop-blur-sm">
                            {{ $challenge->goal_km }} km
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5 flex flex-col flex-1">
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-brand-600 dark:text-brand-400 uppercase tracking-wider">
                                {{ $challenge->category->name ?? 'Geral' }}
                            </span>
                            @if($isJoined)
                                <span
                                    class="text-xs font-semibold text-green-600 bg-green-100 dark:bg-green-900/30 dark:text-green-400 px-2 py-0.5 rounded-full">Participando</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-1">{{ $challenge->title }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">{{ $challenge->description }}</p>
                    </div>

                    <div class="mt-auto space-y-4">
                        <!-- Dates -->
                        <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>{{ $challenge->start_date->format('d/m') }} -
                                {{ $challenge->end_date->format('d/m/Y') }}</span>
                        </div>

                        @if($isJoined)
                            <!-- Progress Bar -->
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Progresso</span>
                                    <span class="font-medium text-zinc-900 dark:text-white">{{ number_format($progress, 1) }} /
                                        {{ number_format($challenge->goal_km, 1) }} km</span>
                                </div>
                                <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-brand-600 h-2.5 rounded-full transition-all duration-500"
                                        style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @else
                            <!-- Join Button -->
                            <button wire:click="join({{ $challenge->id }})"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium rounded-lg transition-colors focus:ring-4 focus:ring-brand-500/20">
                                Ingressar no Desafio
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full flex flex-col items-center justify-center p-12 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl">
                <div class="mb-4 text-zinc-400">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Nenhum desafio ativo</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Fique atento, novos desafios serão lançados em
                    breve!</p>
            </div>
        @endforelse
    </div>
</div>
```