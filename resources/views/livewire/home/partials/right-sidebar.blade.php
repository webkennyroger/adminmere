<div class="space-y-6">
    @if(!$isPremium)
        <!-- Premium Promo Card -->
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm relative">
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
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex flex-col gap-6">
        <section>
            <h2 class="text-xl font-extrabold text-zinc-900 dark:text-white mb-5">Seus desafios</h2>

            <div class="space-y-6">
                <!-- Challenge 1 -->
                <div
                    class="flex gap-4 items-start group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 p-2 rounded-lg transition-colors -mx-2">
                    <div class="relative flex-shrink-0">
                        <img src="https://placehold.co/48x48/374151/9ca3af?text=400"
                            class="w-12 h-12 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700">
                        <span
                            class="absolute -bottom-1 -right-1 bg-[#FC4C02] text-[9px] text-white px-1.5 py-0.5 rounded font-bold">400</span>
                    </div>
                    <div class="flex flex-col">
                        <p
                            class="text-sm font-bold text-zinc-700 dark:text-zinc-200 leading-tight group-hover:text-brand-600 dark:group-hover:text-white transition">
                            Desafio de dezembro: 400 minutos</p>
                        <div class="flex items-center gap-1 mt-1 text-zinc-500 dark:text-zinc-400">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-[11px]">966.853 participantes</span>
                        </div>
                    </div>
                </div>

                <!-- Challenge 2 -->
                <div
                    class="flex gap-4 items-start group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 p-2 rounded-lg transition-colors -mx-2">
                    <div class="relative flex-shrink-0 text-cyan-500 dark:text-cyan-400">
                        <div
                            class="w-12 h-12 rounded-xl bg-cyan-50 dark:bg-cyan-900/30 border border-cyan-100 dark:border-cyan-800 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p
                            class="text-sm font-bold text-zinc-700 dark:text-zinc-200 leading-tight group-hover:text-brand-600 dark:group-hover:text-white transition">
                            Desafio de dezembro: 5 km</p>
                        <div class="flex items-center gap-1 mt-1 text-zinc-500 dark:text-zinc-400">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-[11px]">1.007.400 participantes</span>
                        </div>
                    </div>
                </div>
            </div>

            <button
                class="w-full mt-6 py-2.5 border border-zinc-200 dark:border-zinc-700 rounded-xl text-xs font-bold text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white transition">
                Ver todos os desafios
            </button>
        </section>
    </div>
    <!-- Clubs Section -->
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex flex-col gap-6">
        <section class="flex gap-4 items-start">
            <div
                class="w-12 h-12 rounded-full border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-zinc-400 dark:text-zinc-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M12 3v18" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-zinc-900 dark:text-white">Clubes</h3>
                <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-1 leading-relaxed">
                    Por que fazer isso sozinho? Aproveite mais da experiência Strava entrando ou criando um Clube.
                </p>
                <button class="text-[#FC4C02] text-xs font-bold mt-2 hover:brightness-125 transition">Ver Todos os
                    Clubes</button>
            </div>
        </section>
    </div>

    <!-- Suggested Friends Section -->
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex flex-col gap-6">
        <section>
            <h2 class="text-xl font-extrabold text-zinc-900 dark:text-white mb-5">Amigos sugeridos</h2>

            <div class="space-y-6">
                <!-- Friend 1 -->
                <div class="flex gap-4">
                    <div class="relative">
                        <img src="https://i.pravatar.cc/100?u=rizky"
                            class="w-12 h-12 rounded-xl border-2 border-orange-500/50 p-0.5">
                        <div
                            class="absolute -top-1 -right-1 bg-orange-600 rounded-full border-2 border-white dark:border-[#1a1c1e] p-0.5">
                            <svg class="w-2 h-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-zinc-900 dark:text-zinc-100 leading-none">Rizky Fajar Heryanto
                        </p>
                        <p class="text-[10px] text-zinc-500 mt-1">Jakarta, Indonesia</p>
                        <p class="text-[10px] text-zinc-400 italic mt-1">Fan favorite on Strava</p>
                        <button
                            class="mt-2.5 px-6 py-1.5 bg-[#FC4C02] text-white rounded-lg text-xs font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-900/20">
                            Seguir
                        </button>
                    </div>
                </div>

                <!-- Friend 2 -->
                <div class="flex gap-4">
                    <img src="https://i.pravatar.cc/100?u=aliny"
                        class="w-12 h-12 rounded-full border border-zinc-200 dark:border-zinc-800">
                    <div class="flex-1">
                        <p class="text-sm font-bold text-zinc-900 dark:text-zinc-100 leading-none">Aliny Brito</p>
                        <p class="text-[10px] text-zinc-500 mt-1">Cuiabá, Mato Grosso, Brazil</p>
                        <p class="text-[10px] text-zinc-400 mt-1 italic">You have mutual friends</p>
                        <button
                            class="mt-2.5 px-6 py-1.5 border border-zinc-300 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300 rounded-lg text-xs font-bold hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                            Seguir
                        </button>
                    </div>
                </div>
            </div>

            <button
                class="w-full mt-8 py-2.5 border border-zinc-200 dark:border-zinc-700 rounded-xl text-xs font-bold text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                Encontre e convide seus amigos
            </button>
        </section>
    </div>
</div>