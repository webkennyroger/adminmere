<div class="min-h-screen bg-zinc-50 dark:bg-black">
    <!-- Hero/Cover -->
    <div class="h-48 md:h-64 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative">
            <!-- Profile Info Overlay -->
            <div class="absolute -bottom-16 left-4 sm:left-8 flex items-end gap-6">
                <!-- Avatar with Badge -->
                <div class="relative">
                    <img src="{{ $user->image_url }}"
                        class="w-32 h-32 rounded-2xl border-4 border-white dark:border-zinc-900 shadow-xl object-cover bg-white">
                    @if($user->subscribed() || in_array($user->profile?->plan, ['pro', 'premium']))
                        <div
                            class="absolute -bottom-2 -right-2 bg-gradient-to-r from-orange-400 to-orange-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg border-2 border-white dark:border-zinc-900">
                            Assinante
                        </div>
                    @else
                        <div
                            class="absolute -bottom-2 -right-2 bg-gradient-to-r from-zinc-400 to-zinc-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg border-2 border-white dark:border-zinc-900">
                            Gratuito
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left Header Info (Mobile Stacked, Desktop Inline with Tabs) -->
            <div class="lg:col-span-12 flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $user->name }}</h1>
                    <div class="flex items-center gap-2 text-zinc-500 dark:text-zinc-400 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $user->profile->city ?? 'Localização não definida' }}</span>
                    </div>
                </div>

                <div class="flex gap-4">
                    @if(auth()->id() !== $user->id)
                        <button wire:click="toggleFollow" wire:loading.attr="disabled"
                            class="group px-6 py-2 rounded-lg font-semibold transition-all shadow-sm flex items-center justify-center gap-2 min-w-[120px] {{ auth()->user()->isFollowing($user) ? 'bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-zinc-300 dark:border-zinc-700 hover:bg-yellow-500 hover:text-white hover:border-yellow-500' : 'bg-green-600 text-white hover:bg-green-700 shadow-green-900/20' }}">
                            @if(auth()->user()->isFollowing($user))
                                <span class="block group-hover:hidden">Seguindo</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block group-hover:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="hidden group-hover:block">Deixar de seguir</span>
                            @else
                                <span>Seguir</span>
                            @endif
                        </button>
                    @else
                        <a href="{{ route('profile.edit') }}" wire:navigate
                            class="px-6 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white rounded-lg font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors shadow-sm inline-block">
                            Editar Perfil
                        </a>
                    @endif
                </div>
            </div>

            <!-- Dashboard Stats & Tabs Area -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Stats Overview Card -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-8">

                        <!-- Main Counter -->
                        <div class="text-center sm:text-left">
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
                                Últimas 4 semanas</p>
                            <div class="flex items-baseline justify-center sm:justify-start gap-2 mt-1">
                                <span
                                    class="text-5xl font-black text-zinc-900 dark:text-white tracking-tight">{{ $stats['total_activities_last_4_weeks'] }}</span>
                                <span class="text-sm font-medium text-zinc-500">atividades</span>
                            </div>
                        </div>

                        <!-- Mini Calendar Visualization (Mockup for Visual) -->
                        <div class="flex-1 w-full max-w-sm">
                            <div class="flex justify-between text-xs text-zinc-400 mb-2 font-mono">
                                <span>SEG</span><span>QUA</span><span>SEX</span><span>DOM</span>
                            </div>
                            <div class="grid grid-cols-7 gap-1.5">
                                @for($i = 0; $i < 28; $i++)
                                    <div
                                        class="aspect-square rounded-sm {{ rand(0, 3) > 1 ? 'bg-green-500' : 'bg-zinc-100 dark:bg-zinc-800' }}">
                                    </div>
                                @endfor
                            </div>
                            <div class="flex justify-between items-center mt-2 text-[10px] text-zinc-400">
                                <span>Menos</span>
                                <div class="flex gap-1">
                                    <div class="w-2 h-2 rounded-sm bg-zinc-100 dark:bg-zinc-800"></div>
                                    <div class="w-2 h-2 rounded-sm bg-green-500"></div>
                                </div>
                                <span>Mais</span>
                            </div>
                        </div>

                        <!-- Activity Bars -->
                        <div class="space-y-3 w-full sm:w-auto min-w-[140px]">
                            <!-- Run -->
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-zinc-500"><i class="fas fa-running mr-1"></i> Corrida</span>
                                    <span
                                        class="font-bold text-zinc-900 dark:text-white">{{ $stats['recent_run_km'] }}km</span>
                                </div>
                                <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full"
                                        style="width: {{ $stats['recent_run_km'] > 0 ? '70%' : '5%' }}"></div>
                                </div>
                            </div>
                            <!-- Cycle -->
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-zinc-500"><i class="fas fa-bicycle mr-1"></i> Pedal</span>
                                    <span
                                        class="font-bold text-zinc-900 dark:text-white">{{ $stats['recent_ride_km'] }}km</span>
                                </div>
                                <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full"
                                        style="width: {{ $stats['recent_ride_km'] > 0 ? '50%' : '5%' }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-zinc-200 dark:border-zinc-800 overflow-x-auto">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        @foreach(['Visão geral', 'Coleção de troféus', 'Seguindo', 'Publicações'] as $tab)
                            <a href="#"
                                class="{{ $loop->first ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                {{ $tab }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <!-- Feed/Content Area -->
                <div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Conquistas Recentes</h3>
                    <!-- Mock Achievements -->
                    <div class="flex gap-4 overflow-x-auto pb-4 mb-8">
                        <div
                            class="flex items-center gap-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-900/30 p-3 rounded-lg min-w-[250px]">
                            <div
                                class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-500">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-900 dark:text-white">Recorde Pessoal 5k</p>
                                <p class="text-xs text-zinc-500">22:30 • Há 2 dias</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Fotos Recentes</h3>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-8">
                        @for($i = 0; $i < 6; $i++)
                            <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                <img src="https://picsum.photos/seed/{{ $user->id + $i }}/200"
                                    class="w-full h-full object-cover hover:scale-110 transition-transform cursor-pointer">
                            </div>
                        @endfor
                    </div>

                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Atividades</h3>
                    <!-- Re-use Activity Feed Component logic manually loop for now to avoid nesting active component issues if any -->
                    <!-- Or just include the partial view if possible, but data is different. Let's loop manually simply -->
                    <div class="space-y-6">
                        @forelse($activities as $activity)
                            <livewire:home.partials.activity-item :activity="$activity"
                                :key="'profile-activity-' . $activity->id" />
                        @empty
                            <div class="text-center py-8 text-zinc-500 text-sm">Nenhuma atividade recente para exibir.</div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Social Stats -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
                    <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Estatísticas sociais</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl">
                            <span class="block text-2xl font-bold text-zinc-900 dark:text-white">12</span>
                            <span class="text-xs text-zinc-500">Seguindo</span>
                        </div>
                        <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl">
                            <span class="block text-2xl font-bold text-zinc-900 dark:text-white">450</span>
                            <span class="text-xs text-zinc-500">Seguidores</span>
                        </div>
                    </div>
                </div>

                <!-- Clubs -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
                    <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Clubes</h3>
                    <div class="space-y-3">
                        <div
                            class="flex items-center gap-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 p-2 rounded-lg transition-colors cursor-pointer">
                            <img src="https://ui-avatars.com/api/?name=Run+Club&background=random"
                                class="w-10 h-10 rounded-lg">
                            <div>
                                <p class="text-sm font-bold text-zinc-900 dark:text-white">Clube de Corrida</p>
                                <p class="text-xs text-zinc-500">12k membros</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comparison (Side by Side) -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-800/50">
                    <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Comparação lado a lado</h3>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex -space-x-2">
                            <img src="{{ auth()->user()->image_url }}"
                                class="w-8 h-8 rounded-full border-2 border-white dark:border-zinc-900">
                            <img src="{{ $user->image_url }}"
                                class="w-8 h-8 rounded-full border-2 border-white dark:border-zinc-900">
                        </div>
                        <span class="text-xs font-semibold text-brand-600 cursor-pointer">Ver detalhado</span>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                            <span class="text-zinc-500">Atividades (4 sem)</span>
                            <div class="flex gap-4 font-mono text-xs">
                                <span>{{ auth()->user()->activities()->count() }}</span>
                                <span class="text-zinc-300">|</span>
                                <span class="font-bold">{{ $stats['total_activities_last_4_weeks'] }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                            <span class="text-zinc-500">Tempo (4 sem)</span>
                            <div class="flex gap-4 font-mono text-xs">
                                <span>12h</span>
                                <span class="text-zinc-300">|</span>
                                <span class="font-bold">14h</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>