<div class="bg-white dark:bg-zinc-950 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
    <!-- Cover -->
    <div class="h-24 bg-linear-to-r from-brand-500 to-brand-600 relative">
        <div class="absolute inset-0 opacity-20 pattern-grid-lg"></div>
    </div>

    <!-- Profile Info -->
    <div class="px-5 pb-5 text-center relative">
        <!-- Avatar -->
        <div class="relative -mt-10 mb-3 inline-block">
            <a href="{{ profile_url($user) }}">
                <img src="{{ $user->image_url }}" alt="{{ $user->name }}"
                    class="w-20 h-20 rounded-full border-4 border-white dark:border-zinc-900 shadow-md object-cover hover:ring-2 hover:ring-brand-500 transition-all cursor-pointer">
            </a>

            @if($user->isManager() || $user->isAdmin())
                <span
                    class="absolute bottom-0 right-0 p-1 bg-blue-500 rounded-full border-2 border-white dark:border-zinc-900"
                    title="Verificado">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </span>
            @endif
        </div>

        <a href="{{ profile_url($user) }}" class="hover:text-brand-600 transition-colors">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $user->name }}</h3>
        </a>
        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-4">{{ $user->email }}</p>

        <div class="border-t border-zinc-200 dark:border-zinc-800 my-4"></div>

        <!-- Stats -->
        <div class="flex justify-between items-center text-center py-2">
            <div class="flex-1 border-r border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('users.following', $user) }}"
                    class="group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 block rounded-lg transition-colors">
                    <span
                        class="text-xs text-zinc-500 dark:text-zinc-400 block pb-1 group-hover:text-brand-600 transition-colors">Seguindo</span>
                    <span
                        class="block text-xl font-bold text-zinc-900 dark:text-white group-hover:text-brand-600 transition-colors">{{ $user->following()->count() }}</span>
                </a>
            </div>
            <div class="flex-1 border-r border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('users.followers', $user) }}"
                    class="group cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 block rounded-lg transition-colors">
                    <span
                        class="text-xs text-zinc-500 dark:text-zinc-400 block pb-1 group-hover:text-brand-600 transition-colors">Seguidores</span>
                    <span
                        class="block text-xl font-bold text-zinc-900 dark:text-white group-hover:text-brand-600 transition-colors">{{ $user->followers()->count() }}</span>
                </a>
            </div>
            <div class="flex-1">
                <span class="text-xs text-zinc-500 dark:text-zinc-400 block pb-1">Atividades</span>
                <span class="block text-xl font-bold text-zinc-900 dark:text-white">{{ $challengesCount }}</span>
            </div>
        </div>

        <div class="border-t border-zinc-200 dark:border-zinc-800 my-4"></div>

        <!-- Recent Activity -->
        <div class="text-left px-1">
            <h4 class="text-xs font-medium text-zinc-500 mb-1">Atividade mais recente</h4>
            <div class="text-sm font-bold text-zinc-900 dark:text-white">
                Corrida matinal <span class="font-normal text-zinc-500">• 17 de dez. de 2025</span>
            </div>
        </div>

        <div class="border-t border-zinc-200 dark:border-zinc-800 my-4"></div>

        <!-- Streak -->
        <div class="text-left px-1 mb-6">
            <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 mb-4">Sua sequência</h4>

            <div class="flex items-end gap-3">
                <!-- Fire Icon Box -->
                <div class="flex flex-col items-center shrink-0">
                    <div class="relative flex items-center justify-center">
                        <svg class="w-10 h-10 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z" />
                        </svg>
                        <span class="absolute text-white text-[10px] font-bold mt-2">20</span>
                    </div>
                    <span class="text-[10px] text-orange-500 font-bold uppercase mt-1">Semanas</span>
                </div>

                <!-- Days -->
                <div class="flex-1 flex justify-between text-center pb-1 gap-1">
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-zinc-400 font-medium">S</span>
                        <div
                            class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            15</div>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-zinc-400 font-medium">Q</span>
                        <div
                            class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            16
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-zinc-400 font-medium">O</span>
                        <div
                            class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            17
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-zinc-400 font-medium">Q</span>
                        <div
                            class="w-7 h-7 rounded-full border border-zinc-900 dark:border-white flex items-center justify-center text-xs font-bold text-zinc-900 dark:text-white">
                            18</div>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-zinc-400 font-medium">S</span>
                        <div
                            class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            19</div>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-zinc-400 font-medium">S</span>
                        <div
                            class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            20</div>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-zinc-400 font-medium">D</span>
                        <div
                            class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-500">
                            21</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-zinc-200 dark:border-zinc-800 mb-4"></div>

        <!-- Action -->
        <a href="{{ route('profile') }}"
            class="block w-full py-2 px-4 bg-green-300 dark:bg-green-300 hover:bg-green-400 dark:hover:bg-green-400 text-zinc-700 dark:text-zinc-200 text-sm font-medium rounded-lg transition-colors border border-zinc-200 dark:border-zinc-700">
            Meu Perfil Completo
        </a>
    </div>
</div>