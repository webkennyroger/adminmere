<div class="min-h-screen bg-zinc-50 dark:bg-black py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('profile.view', $user) }}">
                    <img src="{{ $user->image_url }}"
                        class="w-16 h-16 rounded-full border-4 border-white dark:border-zinc-800 shadow">
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $user->name }}</h1>
                    <p class="text-zinc-500 dark:text-zinc-400">Ver conexões</p>
                </div>
            </div>

        </div>

        <!-- Tabs -->
        <div class="border-b border-zinc-200 dark:border-zinc-800 mb-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="setTab('following')"
                    class="{{ $activeTab === 'following' ? 'border-[#FC4C02] text-[#FC4C02]' : 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Seguindo
                    <span
                        class="{{ $activeTab === 'following' ? 'bg-orange-100 text-orange-600' : 'bg-zinc-100 text-zinc-900' }} ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium inline-block">
                        {{ $user->following()->count() }}
                    </span>
                </button>

                <button wire:click="setTab('followers')"
                    class="{{ $activeTab === 'followers' ? 'border-[#FC4C02] text-[#FC4C02]' : 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Seguidores
                    <span
                        class="{{ $activeTab === 'followers' ? 'bg-orange-100 text-orange-600' : 'bg-zinc-100 text-zinc-900' }} ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium inline-block">
                        {{ $user->followers()->count() }}
                    </span>
                </button>
            </nav>
        </div>

        <!-- Results Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($users as $relatedUser)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6 flex flex-col items-center text-center transition-transform hover:-translate-y-1 duration-200"
                    wire:key="user-{{ $relatedUser->id }}">

                    <a href="{{ route('profile.view', $relatedUser) }}">
                        <img src="{{ $relatedUser->image_url }}"
                            class="w-24 h-24 rounded-full border-4 border-white dark:border-zinc-800 shadow-md object-cover mb-4 hover:ring-2 hover:ring-brand-500 transition-all">
                    </a>

                    <a href="{{ route('profile.view', $relatedUser) }}">
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white hover:text-brand-600 transition-colors">
                            {{ $relatedUser->name }}
                        </h3>
                    </a>

                    @if($relatedUser->profile && $relatedUser->profile->city)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 flex items-center gap-1 justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $relatedUser->profile->city }}
                        </p>
                    @else
                        <p class="text-sm text-zinc-400 mt-1 italic">Sem localização</p>
                    @endif

                    <div class="mt-6 w-full">
                        @if(Auth::id() !== $relatedUser->id)
                            @if(Auth::user()->isFollowing($relatedUser))
                                <button wire:click="toggleFollow({{ $relatedUser->id }})" wire:loading.attr="disabled"
                                    class="w-full py-2 px-4 border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 rounded-lg text-sm font-bold hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                                    Seguindo
                                </button>
                            @else
                                <button wire:click="toggleFollow({{ $relatedUser->id }})" wire:loading.attr="disabled"
                                    class="w-full py-2 px-4 bg-[#FC4C02] text-white rounded-lg text-sm font-bold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition transform active:scale-95">
                                    Seguir
                                </button>
                            @endif
                        @else
                            <button disabled
                                class="w-full py-2 px-4 border border-transparent text-zinc-400 text-sm font-bold cursor-default">
                                Você
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12">
                    <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">
                        {{ $activeTab === 'following' ? 'Ninguém seguido ainda' : 'Sem seguidores ainda' }}
                    </h3>
                    <p class="text-zinc-500 dark:text-zinc-400 mt-1">Conecte-se com mais atletas!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    </div>
</div>