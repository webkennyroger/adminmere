<div class="space-y-6">
    @livewire('home.partials.user-profile-card')
    @if(!$isPremium)
        <!-- Premium Promo Card -->
        <div
            class="bg-white dark:bg-zinc-950 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm relative">
            <div class="p-5 relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white leading-tight">
                        Experimente o Premium grátis
                    </h3>
                    <span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded font-bold">Pro</span>
                </div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                    Desbloqueie estatísticas avançadas e planos de treino personalizados.
                </p>
                <a href="{{ route('billing.index') }}"
                    class="block w-full py-2 px-4 bg-linear-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white text-center text-sm font-medium rounded-lg shadow-sm transition-all">
                    Testar 1 mês grátis
                </a>
            </div>
        </div>
    @endif

    <!-- Challenges Section -->
    <div
        class="bg-white dark:bg-zinc-950 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex flex-col gap-6">
        <section>
            <h2 class="text-xl font-extrabold text-zinc-900 dark:text-white mb-5">Seus desafios</h2>

            <div class="space-y-6">
                @forelse($myChallenges as $challenge)
                    <a href="{{ route('challenges.show', $challenge) }}"
                        class="flex gap-4 items-start group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 p-2 rounded-lg transition-colors -mx-2"
                        wire:key="challenge-{{ $challenge->id }}">
                        <div class="relative shrink-0">
                            <img src="{{ $challenge->image ? Storage::url($challenge->image) : 'https://placehold.co/48x48/374151/9ca3af?text=Img' }}"
                                class="w-12 h-12 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 object-cover">
                            <span
                                class="absolute -bottom-1 -right-1 bg-[#FC4C02] text-[9px] text-white px-1.5 py-0.5 rounded font-bold">{{ $challenge->goal_value ?? 'Go' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <p
                                class="text-sm font-bold text-zinc-700 dark:text-zinc-200 leading-tight group-hover:text-brand-600 dark:group-hover:text-white transition line-clamp-2">
                                {{ $challenge->title }}
                            </p>
                            <div class="flex items-center gap-1 mt-1 text-zinc-500 dark:text-zinc-400">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-[11px]">{{ $challenge->users_count ?? 0 }} participantes</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center text-zinc-500 text-xs py-2">
                        Você não está participando de nenhum desafio.
                    </div>
                @endforelse
            </div>

            <a href="{{ route('challenges.index') }}"
                class="block w-full text-center mt-6 py-2.5 border border-zinc-200 dark:border-zinc-700 rounded-xl text-xs font-bold text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white transition">
                Ver todos os desafios
            </a>
        </section>
    </div>
    <!-- Clubs Section -->
    <div
        class="bg-white dark:bg-zinc-950 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex flex-col gap-6">
        <section class="flex gap-4 items-start">
            <div
                class="w-12 h-12 rounded-full border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-zinc-400 dark:text-zinc-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M12 3v18" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-zinc-900 dark:text-white">Clubes</h3>
                <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-1 leading-relaxed">
                    Por que fazer isso sozinho? Aproveite mais da experiência MERE entrando ou criando um Clube.
                </p>
                <button class="text-[#FC4C02] text-xs font-bold mt-2 hover:brightness-125 transition">Ver Todos os
                    Clubes</button>
            </div>
        </section>
    </div>

    <livewire:home.partials.suggested-friends />
</div>