<div
    class="bg-white dark:bg-zinc-900 shadow-sm overflow-hidden rounded-xl border border-zinc-200/80 dark:border-zinc-800 mb-5">
    <!-- Cover Banner -->
    <div class="h-24 bg-linear-to-r from-blue-500 via-brand-500 to-emerald-500 relative">
        @if($user->cover_url)
            <img src="{{ $user->cover_url }}" class="w-full h-full object-cover" alt="">
        @endif
    </div>

    <!-- Avatar centered (overlaps banner) -->
    <div class="flex flex-col items-center -mt-10 pb-4 px-4 relative z-10">
        <div class="relative mb-3">
            <img src="{{ $user->image_url }}"
                class="w-20 h-20 rounded-full object-cover border-4 border-white dark:border-zinc-900 shadow-lg"
                alt="{{ $user->name }}">
            @if($user->isManager() || $user->isAdmin())
                <div
                    class="absolute bottom-1 right-1 bg-blue-500 text-white rounded-full p-0.5 border-2 border-white dark:border-zinc-900 shadow-sm">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                </div>
            @endif
        </div>

        <!-- Name & Handle -->
        <h3 class="text-lg font-bold text-zinc-900 dark:text-white leading-tight">
            {{ $user->name }}
        </h3>
        <span class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
            {{ '@' . ($user->handle ?? $user->id) }}
        </span>
    </div>

    <!-- Divider -->
    <div class="mx-6 border-t border-zinc-100 dark:border-zinc-800"></div>

    <!-- Stats row -->
    <div class="flex items-center justify-between py-4 px-6 text-center">
        <div>
            <div class="text-lg font-bold text-zinc-900 dark:text-white">
                {{ $followingCount }}
            </div>
            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 tracking-wider font-medium mt-0.5">
                Seguindo</div>
        </div>
        <div class="w-px h-8 bg-zinc-100 dark:bg-zinc-800"></div>
        <div>
            <div class="text-lg font-bold text-zinc-900 dark:text-white">
                {{ $followersCount }}
            </div>
            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 tracking-wider font-medium mt-0.5">
                Seguidores</div>
        </div>
        <div class="w-px h-8 bg-zinc-100 dark:bg-zinc-800"></div>
        <div>
            <div class="text-lg font-bold text-zinc-900 dark:text-white">
                {{ $activitiesCount }}
            </div>
            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 tracking-wider font-medium mt-0.5">
                Atividades</div>
        </div>
    </div>

    <!-- Profile Action -->
    <div class="p-4 pt-0">
        <a href="{{ profile_url($user) }}"
            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Meu perfil
        </a>
    </div>
</div>