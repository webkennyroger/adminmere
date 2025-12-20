<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Featured Challenge Banner -->
    <div class="relative w-full rounded-3xl overflow-hidden shadow-2xl bg-brand-600">
        <!-- Background Pattern/Graphic -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-700 to-brand-500"></div>
            <!-- Abstract Shapes representing the reference design -->
            <div class="absolute top-0 right-0 w-2/3 h-full bg-brand-600 opacity-50 transform skew-x-12 translate-x-20">
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
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>1 de dez. de 2025 a 31 de dez. de 2025</span>
                    </div>
                </div>

                <button
                    class="bg-white text-brand-600 hover:bg-zinc-50 font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
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
        <button wire:click="setCategory('all')"
            class="px-6 py-2 border rounded-lg text-sm font-bold whitespace-nowrap transition-colors shadow-sm {{ $selectedCategory === 'all' ? 'border-brand-600 text-brand-600 bg-brand-50 dark:bg-brand-900/10' : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-200 hover:border-zinc-400 dark:hover:border-zinc-500' }}">
            Todos
        </button>

        @foreach($categories as $category)
            <button wire:click="setCategory('{{ $category->slug }}')"
                class="px-6 py-2 border rounded-lg text-sm font-bold whitespace-nowrap transition-colors shadow-sm flex items-center gap-2 {{ $selectedCategory === $category->slug ? 'border-brand-600 text-brand-600 bg-brand-50 dark:bg-brand-900/10' : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-200 hover:border-zinc-400 dark:hover:border-zinc-500' }}">
                @if($category->icon)
                    <span class="material-icons text-base">{{ $category->icon }}</span>
                @endif
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <!-- Challenges Grid -->
    <section>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($challenges as $challenge)
                @php
                    $userChallenge = $challenge->users->where('id', auth()->id())->first();
                    $isJoined = $userChallenge !== null;
                @endphp
                <div
                    class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full group relative">
                    <a href="{{ route('challenges.demo') }}" class="absolute inset-0 z-0"></a>
                    <!-- Card Image Header -->
                    <div class="h-32 bg-zinc-100 dark:bg-zinc-800 relative overflow-hidden pointer-events-none">
                        @if($challenge->image)
                            <img src="{{ Storage::url($challenge->image) }}"
                                class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/10"></div>
                        @else
                            <!-- Abstract Background -->
                            <div class="absolute inset-0 bg-brand-600 opacity-10 group-hover:opacity-20 transition-opacity">
                            </div>
                            <!-- Logo Badge -->
                            <div
                                class="absolute top-3 left-3 bg-white dark:bg-zinc-900 px-2 py-1 rounded shadow-sm border border-zinc-100 dark:border-zinc-700">
                                <span class="text-[10px] font-black tracking-tighter text-brand-600 uppercase">MERE</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-4 flex flex-col flex-1 pointer-events-none">
                        <h3 class="font-bold text-zinc-900 dark:text-white mb-2 leading-tight min-h-[40px]">
                            {{ $challenge->title }}
                        </h3>

                        <div class="space-y-3 mb-4 flex-1">
                            <div class="flex items-start gap-2">
                                <!-- Activity Icon -->
                                <svg class="w-4 h-4 text-zinc-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    <!-- Using lightning/activity icon as generic fallback for 'shoe_prints' -->
                                </svg>
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($challenge->description), 60) }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Calendar Icon -->
                                <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-[10px] text-zinc-500 dark:text-zinc-500">
                                    {{ $challenge->start_date->format('d M') }} a
                                    {{ $challenge->end_date->format('d M, Y') }}
                                </p>
                            </div>

                            @if($isJoined)
                                @php
                                    $progress = $userChallenge->pivot->progress ?? 0;
                                    $percent = $challenge->goal_km > 0 ? min(100, ($progress / $challenge->goal_km) * 100) : 0;
                                @endphp
                                <div class="pl-6">
                                    <div class="flex justify-between text-[10px] mb-1 text-zinc-500">
                                        <span>{{ number_format($progress, 1) }} km</span>
                                        <span>{{ number_format($percent, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-brand-600 h-1.5 rounded-full transition-all duration-500"
                                            style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @else
                                <p class="text-[10px] text-zinc-400 pl-6">0 amigos entraram</p>
                            @endif
                        </div>

                        <div class="pointer-events-auto mt-auto relative z-10">
                            @if($isJoined)
                                <button
                                    class="w-full border border-brand-600/30 text-brand-600 bg-brand-50 dark:bg-brand-900/10 py-2 rounded-lg text-sm font-bold transition-colors cursor-default">
                                    Entrou no Desafio
                                </button>
                            @else
                                <button wire:click.stop="join({{ $challenge->id }})"
                                    class="w-full bg-brand-600 hover:bg-brand-700 text-white py-2 rounded-lg text-sm font-bold shadow-md shadow-brand-900/10 transition-colors">
                                    Participar do Desafio
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Nenhum desafio encontrado</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 mt-1">Tente selecionar outra categoria.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>