<div class="space-y-6">
    <div
        class="bg-white dark:bg-zinc-900 rounded-3xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-800 animate-fadeIn">
        <form wire:submit.prevent="savePost">
            <div class="flex gap-4">
                <!-- Avatar Column (Left Side) -->
                <div class="hidden sm:block flex-shrink-0 pt-1">
                    @if(auth()->user()->image_url)
                        <img src="{{ auth()->user()->image_url }}"
                            class="w-11 h-11 rounded-full border border-zinc-100 dark:border-zinc-700 object-cover">
                    @else
                        <div
                            class="w-11 h-11 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Input Column (Right Side) -->
                <div class="flex-grow">

                    <!-- Header: Title Input -->
                    <div class="relative mb-3 group">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-green-500 rounded-l-lg"></div>
                        <input type="text" wire:model="title"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-r-lg text-lg font-bold text-zinc-900 dark:text-white placeholder-zinc-400 focus:ring-0 px-4 py-2.5 transition-colors"
                            placeholder="Dê um título para sua publicação...">
                    </div>

                    <!-- Content Input -->
                    <div class="relative group mb-3">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-yellow-500 rounded-l-lg"></div>
                        <textarea wire:model="content"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border-none rounded-r-lg text-base text-zinc-700 dark:text-zinc-300 placeholder-zinc-500 focus:ring-0 px-4 py-3 min-h-[100px] resize-y transition-colors"
                            placeholder="O que está em sua mente, {{ auth()->user()->first_name }}?"></textarea>
                    </div>

                    <!-- Toolbar -->
                    <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-zinc-100 dark:border-zinc-800">

                        <!-- Media Button -->
                        <label
                            class="cursor-pointer flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors group">
                            <div
                                class="p-1 rounded bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Foto/Vídeo</span>
                            <input type="file" wire:model="photo" class="hidden">
                        </label>

                        <!-- Poll Button (Visual) -->
                        <div class="hidden sm:flex items-center gap-2 px-3 py-2 opacity-50 cursor-not-allowed"
                            title="Enquete (Em breve)">
                            <div
                                class="p-1 rounded bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Enquete</span>
                        </div>

                        <div class="ml-auto relative z-20">
                            <select wire:model="feedType"
                                class="bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs font-bold border-none rounded-lg pl-3 pr-8 py-2 focus:ring-0 cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                                <option value="personal">🌎 Feed Geral</option>
                                <option value="community">👥 Comunidade</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-2 px-6 rounded-xl text-sm transition-all shadow-lg hover:shadow-brand-500/30 active:scale-95 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="savePost">PUBLICAR</span>
                            <span wire:loading wire:target="savePost">...</span>
                        </button>
                    </div>

                    <!-- Post Messages -->
                    @if (session()->has('message'))
                        <div class="mt-3 text-xs text-green-600 dark:text-green-400 font-medium animate-pulse">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Photo Upload Progress -->
                    <div wire:loading wire:target="photo"
                        class="mt-3 text-xs text-blue-600 dark:text-blue-400 font-medium flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Carregando foto...
                    </div>

                    <!-- Photo Preview -->
                    @if ($photo)
                        <div class="mt-3 space-y-2">
                            <!-- Photo Info -->
                            <div
                                class="inline-flex items-center gap-2 bg-green-50 dark:bg-green-900/20 px-3 py-1.5 rounded-lg border border-green-100 dark:border-green-800">
                                <span class="text-green-500">✓</span>
                                <span
                                    class="text-xs text-green-700 dark:text-green-300 font-medium truncate max-w-[200px]">{{ $photo->getClientOriginalName() }}</span>
                                <button type="button" wire:click="$set('photo', null)"
                                    class="text-green-400 hover:text-red-500 ml-1 font-bold">✕</button>
                            </div>

                            <!-- Photo Preview Image -->
                            <div class="relative w-full max-w-xs">
                                <img src="{{ $photo->temporaryUrl() }}"
                                    class="w-full h-auto rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm"
                                    alt="Preview">
                            </div>
                        </div>
                    @endif

                    @error('content') <span class="text-red-500 text-xs block mt-2 font-medium">{{ $message }}</span>
                    @enderror
                    @error('photo') <span class="text-red-500 text-xs block mt-2 font-medium">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </form>
    </div>

    <!-- Feed Items -->
    @forelse($items as $item)
        @if($item['type'] === 'post')
            <livewire:home.partials.post-item :post="$item['item']" :key="'post-' . $item['item']->id" />
        @else
            <livewire:home.partials.activity-item :activity="$item['item']" :key="'activity-' . $item['item']->id" />
        @endif
    @empty
        <div class="text-center py-12">
            <p class="text-zinc-500 dark:text-zinc-400">Nenhuma atividade ou publicação recente.</p>
        </div>
    @endforelse

    <!-- Loading Indicator / Scroll Trigger -->
    @if($hasMore)
        <div x-data="{}" x-intersect="$wire.loadMore()" class="w-full py-12 flex justify-center">
            <div wire:loading class="flex items-center justify-center">
                <div
                    class="bg-white dark:bg-zinc-900 rounded-2xl p-4 shadow-sm border border-zinc-100 dark:border-zinc-800 flex items-center justify-center gap-1.5 min-w-[100px]">
                    <div class="w-2.5 h-2.5 bg-brand-600 rounded-full animate-typing" style="animation-delay: 0s"></div>
                    <div class="w-2.5 h-2.5 bg-brand-600 rounded-full animate-typing" style="animation-delay: 0.2s"></div>
                    <div class="w-2.5 h-2.5 bg-brand-600 rounded-full animate-typing" style="animation-delay: 0.4s"></div>
                </div>
            </div>
            {{-- Invisible placeholder to maintain intersection area if needed --}}
            <div wire:loading.remove class="h-10"></div>
        </div>
    @endif
</div>