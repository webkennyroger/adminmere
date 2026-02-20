<div wire:poll.10s>
    <div class="bg-white dark:bg-zinc-950 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex flex-col gap-6">
        <section>
            <h2 class="text-xl font-extrabold text-zinc-900 dark:text-white mb-5">Amigos sugeridos</h2>

            <div class="space-y-6">
                @forelse($suggestions as $user)
                    <div class="flex gap-4 group relative" wire:key="suggestion-{{ $user->id }}">
                        
                        <!-- Dismiss Button (Hover) -->
                        <button wire:click="dismiss({{ $user->id }})" 
                            class="absolute top-0 right-0 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 opacity-0 group-hover:opacity-100 transition-opacity bg-white dark:bg-zinc-900 rounded-full shadow-sm border border-zinc-100 dark:border-zinc-800"
                            title="Dispensar">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="relative flex-shrink-0">
                            <a href="{{ profile_url($user) }}">
                                <img src="{{ $user->image_url }}"
                                    class="w-12 h-12 rounded-full border border-zinc-200 dark:border-zinc-800 object-cover hover:ring-2 hover:ring-brand-500 transition-all">
                            </a>
                        </div>
                        
                        <div class="flex-1 pr-6"> <!-- Added padding right for dismiss button space -->
                            <a href="{{ profile_url($user) }}">
                                <p class="text-sm font-bold text-zinc-900 dark:text-zinc-100 leading-none hover:text-brand-600 transition-colors">{{ $user->name }}</p>
                            </a>
                            
                            @if($user->profile && $user->profile->city)
                                <p class="text-[10px] text-zinc-500 mt-1 truncate">{{ $user->profile->city }}</p>
                            @else
                                <p class="text-[10px] text-zinc-500 mt-1">Atleta Mere App</p>
                            @endif

                            <button wire:click="follow({{ $user->id }})" wire:loading.attr="disabled"
                                class="mt-2.5 px-6 py-1.5 border border-brand-500 text-brand-600 dark:text-brand-400 rounded-lg text-xs font-bold hover:bg-brand-50 dark:hover:bg-brand-900/20 transition">
                                <span wire:loading.remove wire:target="follow({{ $user->id }})">Seguir</span>
                                <span wire:loading wire:target="follow({{ $user->id }})">...</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-zinc-500 text-xs py-4">
                        Nenhuma sugestão no momento.
                    </div>
                @endforelse
            </div>

            <a href="{{ route('users.find') }}"
                class="block w-full text-center mt-8 py-2.5 border border-zinc-200 dark:border-zinc-700 rounded-xl text-xs font-bold text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                Encontre e convide seus amigos
            </a>
        </section>
    </div>
</div>
