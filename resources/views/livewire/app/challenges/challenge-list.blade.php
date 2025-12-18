<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Featured Challenge Banner -->
    <div class="relative w-full rounded-3xl overflow-hidden shadow-2xl bg-[#FC4C02]">
        <!-- Background Pattern/Graphic -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-orange-500"></div>
            <!-- Abstract Shapes representing the reference design -->
            <div class="absolute top-0 right-0 w-2/3 h-full bg-[#FC4C02] opacity-50 transform skew-x-12 translate-x-20">
            </div>
            <div
                class="absolute bottom-0 right-10 w-64 h-64 bg-yellow-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20">
            </div>
            <div
                class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full mix-blend-overlay filter blur-2xl opacity-10">
            </div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-8 md:p-12 gap-8">
            <div class="flex-1 max-w-xl text-white">
                <div class="mb-4 flex items-center gap-3">
                    <span
                        class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Destaque
                        do Mês</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black mb-6 leading-tight">
                    Desafio de Dezembro: <br />Corra 100km
                </h1>

                <div class="space-y-3 mb-8 text-white/90 font-medium">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Corra um total de 100km em um mês</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>1 de dez. de 2025 a 31 de dez. de 2025</span>
                    </div>
                </div>

                <button
                    class="bg-white text-[#FC4C02] hover:bg-zinc-50 font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Participar do Desafio
                </button>
            </div>

            <!-- Right Side Graphic/Icons -->
            <div class="hidden md:block relative w-96 h-64">
                <!-- Badges floating -->
                <div class="absolute top-4 right-4 bg-white p-2 rounded-xl shadow-lg transform rotate-12">
                    <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" class="w-20 h-20" alt="Medal">
                </div>
                <div class="absolute bottom-4 right-20 bg-white p-2 rounded-xl shadow-lg transform -rotate-6">
                    <img src="https://cdn-icons-png.flaticon.com/512/5906/5906043.png" class="w-16 h-16" alt="Shoe">
                </div>
                <div
                    class="absolute top-1/2 left-4 bg-zinc-900 border-2 border-white p-2 rounded-xl shadow-2xl transform -rotate-12 z-20">
                    <div class="text-center px-4 py-2">
                        <span class="block text-2xl font-black text-white">100K</span>
                        <span class="block text-xs font-bold text-zinc-400 uppercase">Run</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-hide">
        <button
            class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-bold text-zinc-700 dark:text-zinc-200 hover:border-zinc-400 dark:hover:border-zinc-500 whitespace-nowrap transition-colors shadow-sm">
            Todos
        </button>
        <button
            class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-bold text-zinc-700 dark:text-zinc-200 hover:border-zinc-400 dark:hover:border-zinc-500 whitespace-nowrap transition-colors shadow-sm flex items-center gap-2">
            <span class="material-icons text-base">directions_run</span> Corrida
        </button>
        <button
            class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-bold text-zinc-700 dark:text-zinc-200 hover:border-zinc-400 dark:hover:border-zinc-500 whitespace-nowrap transition-colors shadow-sm flex items-center gap-2">
            <span class="material-icons text-base">pedal_bike</span> Ciclismo
        </button>
        <button
            class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-bold text-zinc-700 dark:text-zinc-200 hover:border-zinc-400 dark:hover:border-zinc-500 whitespace-nowrap transition-colors shadow-sm flex items-center gap-2">
            <span class="material-icons text-base">pool</span> Natação
        </button>
        <button
            class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-bold text-zinc-700 dark:text-zinc-200 hover:border-zinc-400 dark:hover:border-zinc-500 whitespace-nowrap transition-colors shadow-sm flex items-center gap-2">
            <span class="material-icons text-base">hiking</span> Caminhada
        </button>
    </div>

    @php
        $joinedChallenges = $challenges->filter(function ($c) {
            return $c->users->isNotEmpty();
        });
        $recommendedChallenges = $challenges->filter(function ($c) {
            return $c->users->isEmpty();
        });
    @endphp

    <!-- Recommended for You -->
    <section>
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}"
                class="w-8 h-8 rounded-full border border-zinc-200">
            <h2 class="text-xl font-extrabold text-zinc-900 dark:text-white">Recomendados para você</h2>
            <span class="text-sm text-zinc-500 dark:text-zinc-400 font-normal">Com base nas suas atividades</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($recommendedChallenges as $challenge)
                <div
                    class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full group relative">
                    <a href="{{ route('challenges.demo') }}" class="absolute inset-0 z-0"></a>
                    <!-- Card Image Header -->
                    <div class="h-32 bg-zinc-100 dark:bg-zinc-800 relative overflow-hidden pointer-events-none">
                        <!-- Abstract Background -->
                        <div class="absolute inset-0 bg-[#FC4C02] opacity-10 group-hover:opacity-20 transition-opacity">
                        </div>
                        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-orange-500 rounded-full opacity-20"></div>

                        <!-- Logo Badge -->
                        <div
                            class="absolute top-3 left-3 bg-white dark:bg-zinc-900 px-2 py-1 rounded shadow-sm border border-zinc-100 dark:border-zinc-700">
                            <span class="text-[10px] font-black tracking-tighter text-[#FC4C02] uppercase">MERE</span>
                        </div>

                        <!-- Icons -->
                        <div class="absolute bottom-2 right-2 flex gap-1">
                            <div class="bg-white dark:bg-zinc-900 p-1.5 rounded-lg shadow-sm">
                                <img src="https://cdn-icons-png.flaticon.com/512/2583/2583344.png" class="w-5 h-5">
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 flex flex-col flex-1 pointer-events-none">
                        <h3 class="font-bold text-zinc-900 dark:text-white mb-2 leading-tight min-h-[40px]">
                            {{ $challenge->title }}
                        </h3>

                        <div class="space-y-3 mb-4 flex-1">
                            <div class="flex items-start gap-2">
                                <span class="material-icons text-zinc-400 text-lg">shoe_prints</span>
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($challenge->description, 60) }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-icons text-zinc-400 text-lg">calendar_today</span>
                                <p class="text-[10px] text-zinc-500 dark:text-zinc-500">
                                    {{ $challenge->start_date->format('d M') }} a
                                    {{ $challenge->end_date->format('d M, Y') }}
                                </p>
                            </div>
                            <p class="text-[10px] text-zinc-400 pl-7">0 amigos entraram</p>
                        </div>

                        <!-- We use pointer-events-auto for the button so users can still click "Join" directly without going to the page if they prefer, 
                                     BUT giving precedence to the page view might be better. 
                                     Strava usually opens a modal or page. Let's make the button also go to the page or keep functionality?
                                     The user said "when I click on some challenge it will open this page".
                                     So lets leave the Join button working but also have the card clickable.
                                     However, nested clickable links are invalid HTML (a inside a).
                                     So we can make the join button a separate element with higher z-index, OR 
                                     just accept that clicking the card goes to page.
                                     The current join button is a wire:click.
                                -->
                        <div class="pointer-events-auto mt-auto relative z-10">
                            <button wire:click.stop="join({{ $challenge->id }})"
                                class="w-full bg-[#FC4C02] hover:bg-[#e04302] text-white py-2 rounded-lg text-sm font-bold shadow-md shadow-orange-900/10 transition-colors">
                                Participar do Desafio
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-zinc-500">
                    Você já está participando de todos os desafios recomendados!
                </div>
            @endforelse
        </div>
    </section>

    <!-- Joined Challenges -->
    @if($joinedChallenges->isNotEmpty())
        <section>
            <h2 class="text-xl font-extrabold text-zinc-900 dark:text-white mb-6">Desafios em que você entrou</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($joinedChallenges as $challenge)
                    @php
                        $userChallenge = $challenge->users->first();
                        $progress = $userChallenge->pivot->progress;
                        $percent = $challenge->goal_km > 0 ? min(100, ($progress / $challenge->goal_km) * 100) : 0;
                    @endphp
                    <div
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full group relative">
                        <a href="{{ route('challenges.demo') }}" class="absolute inset-0 z-0"></a>
                        <!-- Card Image Header -->
                        <div class="h-32 bg-zinc-800 relative overflow-hidden pointer-events-none">
                            <!-- Darker Theme for Joined -->
                            <div class="absolute inset-0 bg-zinc-800"></div>
                            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white opacity-5 rounded-full"></div>

                            <!-- Logo Badge -->
                            <div class="absolute top-3 left-3 bg-[#FC4C02] px-2 py-1 rounded shadow-sm">
                                <span class="text-[10px] font-black tracking-tighter text-white uppercase">MERE</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 flex flex-col flex-1 pointer-events-none">
                            <h3 class="font-bold text-zinc-900 dark:text-white mb-2 leading-tight min-h-[40px]">
                                {{ $challenge->title }}
                            </h3>

                            <div class="space-y-3 mb-4 flex-1">
                                <div class="flex items-start gap-2">
                                    <span class="material-icons text-zinc-400 text-lg">flag</span>
                                    <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                        {{ $challenge->goal_km }} km meta
                                    </p>
                                </div>

                                <!-- Progress -->
                                <div class="pl-7">
                                    <div class="flex justify-between text-[10px] mb-1 text-zinc-500">
                                        <span>{{ number_format($progress, 1) }} km</span>
                                        <span>{{ number_format($percent, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-[#FC4C02] h-1.5 rounded-full transition-all duration-500"
                                            style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="material-icons text-zinc-400 text-lg">calendar_today</span>
                                    <p class="text-[10px] text-zinc-500 dark:text-zinc-500">
                                        {{ $challenge->start_date->format('d M') }} a
                                        {{ $challenge->end_date->format('d M, Y') }}
                                    </p>
                                </div>
                                <p class="text-[10px] text-zinc-400 pl-7">1 amigo entrou</p>
                            </div>

                            <button
                                class="w-full border border-[#FC4C02] text-[#FC4C02] bg-white dark:bg-transparent py-2 rounded-lg text-sm font-bold transition-colors">
                                Entrou no Desafio
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
```