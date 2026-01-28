<div class="min-h-screen bg-zinc-50 dark:bg-black py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header & Filters -->
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6 mb-8">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Encontrar Amigos</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Pesquisar por nome..."
                        class="block w-full pl-10 pr-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-shadow">
                </div>

                <!-- City Filter -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="city" placeholder="Filtrar por cidade..."
                        class="block w-full pl-10 pr-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-shadow">
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($this->users as $user)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6 flex flex-col items-center text-center transition-transform hover:-translate-y-1 duration-200"
                    wire:key="user-{{ $user->id }}">

                    <a href="{{ profile_url($user) }}">
                        <img src="{{ $user->image_url }}"
                            class="w-24 h-24 rounded-full border-4 border-white dark:border-zinc-800 shadow-md object-cover mb-4 hover:ring-2 hover:ring-brand-500 transition-all">
                    </a>

                    <a href="{{ profile_url($user) }}">
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white hover:text-brand-600 transition-colors">
                            {{ $user->name }}
                        </h3>
                    </a>

                    @if($user->profile && $user->profile->city)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 flex items-center gap-1 justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $user->profile->city }}
                        </p>
                    @else
                        <p class="text-sm text-zinc-400 mt-1 italic">Sem localização</p>
                    @endif

                    <div class="mt-6 w-full">
                        @if(Auth::user()->isFollowing($user))
                            <button wire:click="unfollow({{ $user->id }})" wire:loading.attr="disabled"
                                class="w-full py-2 px-4 border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 rounded-lg text-sm font-bold hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                                Seguindo
                            </button>
                        @else
                            <button wire:click="follow({{ $user->id }})" wire:loading.attr="disabled"
                                class="w-full py-2 px-4 bg-[#FC4C02] text-white rounded-lg text-sm font-bold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition transform active:scale-95">
                                Seguir
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12">
                    <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Nenhum usuário encontrado</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 mt-1">Tente ajustar seus filtros de busca.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $this->users->links() }}
        </div>
    </div>
</div>