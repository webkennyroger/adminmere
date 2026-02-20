<div
    class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-sm">
    <!-- Cover -->
    <div class="h-20 bg-linear-to-r from-brand-500 via-brand-400 to-emerald-500 relative">
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMiIgZmlsbD0id2hpdGUiIG9wYWNpdHk9IjAuMyIvPjwvc3ZnPg=='); background-repeat: repeat;">
        </div>
    </div>

    <!-- Profile Info -->
    <div class="px-5 pb-5 text-center relative">
        <!-- Avatar -->
        <div class="relative -mt-8 mb-3 inline-block">
            <a href="{{ profile_url($user) }}">
                <img src="{{ $user->image_url }}" alt="{{ $user->name }}"
                    class="w-16 h-16 rounded-full border-4 border-white dark:border-zinc-900 shadow-md object-cover hover:ring-2 hover:ring-brand-500 transition-all cursor-pointer">
            </a>
            @if($user->isManager() || $user->isAdmin())
                <span
                    class="absolute -bottom-0.5 -right-0.5 p-0.5 bg-blue-500 rounded-full border-2 border-white dark:border-zinc-900"
                    title="Verificado">
                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </span>
            @endif
        </div>

        <a href="{{ profile_url($user) }}" class="hover:text-brand-600 transition-colors">
            <h3 class="text-base font-bold text-zinc-900 dark:text-white">{{ $user->name }}</h3>
        </a>
        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-3">{{ '@' . ($user->handle ?? $user->id) }}</p>

        <!-- Stats Row -->
        <div class="flex justify-center items-center gap-6 py-3 border-t border-zinc-200/80 dark:border-zinc-800">
            <a href="{{ route('users.following', $user) }}" class="group text-center cursor-pointer">
                <span
                    class="block text-lg font-bold text-zinc-900 dark:text-white group-hover:text-brand-600 transition-colors">{{ $user->following()->count() }}</span>
                <span
                    class="text-[11px] text-zinc-500 dark:text-zinc-400 group-hover:text-brand-600 transition-colors">Seguindo</span>
            </a>
            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-800"></div>
            <a href="{{ route('users.followers', $user) }}" class="group text-center cursor-pointer">
                <span
                    class="block text-lg font-bold text-zinc-900 dark:text-white group-hover:text-brand-600 transition-colors">{{ $user->followers()->count() }}</span>
                <span
                    class="text-[11px] text-zinc-500 dark:text-zinc-400 group-hover:text-brand-600 transition-colors">Seguidores</span>
            </a>
            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-800"></div>
            <div class="text-center">
                <span class="block text-lg font-bold text-zinc-900 dark:text-white">{{ $challengesCount }}</span>
                <span class="text-[11px] text-zinc-500 dark:text-zinc-400">Atividades</span>
            </div>
        </div>

        <!-- Action -->
        <a href="{{ route('profile') }}"
            class="mt-3 flex items-center justify-center gap-2 w-full py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold rounded-lg transition-all shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Meu perfil
        </a>
    </div>
</div>