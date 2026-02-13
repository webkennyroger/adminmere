<div class="space-y-6">
    <!-- Novo Post Card -->
    @if($feed !== 'timeline')
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-4 transition-all hover:shadow-md">
            <form wire:submit.prevent="savePost">
                <div class="flex gap-4">
                    <!-- Avatar Column (Left Side) -->
                    <div class="hidden sm:block shrink-0 pt-1">
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
                    <div class="grow">

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
                                placeholder="O que está em sua mente, {{ auth()->user()->name }}?"></textarea>
                        </div>

                        <!-- Poll Options Area -->
                        @if($isPoll)
                            <div class="mb-4 bg-zinc-100 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                <h4 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Opções da Enquete
                                </h4>
                                <div class="space-y-2.5">
                                    @foreach($pollOptions as $index => $option)
                                        <div class="flex items-center gap-2">
                                            <input type="text" wire:model="pollOptions.{{ $index }}" 
                                                class="flex-1 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm px-3 py-2 focus:ring-purple-500 focus:border-purple-500 dark:text-white"
                                                placeholder="Opção {{ $index + 1 }}">
                                            @if($index > 1)
                                                <button type="button" wire:click="removePollOption({{ $index }})" class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 p-1.5 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            @endif
                                        </div>
                                        @error('pollOptions.'.$index) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    @endforeach
                                </div>
                                @if(count($pollOptions) < 5)
                                    <button type="button" wire:click="addPollOption" class="mt-3 text-xs font-medium text-purple-600 dark:text-purple-400 hover:text-purple-700 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Adicionar Opção
                                    </button>
                                @endif
                                
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="text-xs text-zinc-500">Duração:</span>
                                    <select wire:model="pollDuration" class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-xs rounded-lg py-1 px-2">
                                        <option value="1">1 Dia</option>
                                        <option value="3">3 Dias</option>
                                        <option value="7">1 Semana</option>
                                        <option value="30">1 Mês</option>
                                    </select>
                                </div>
                            </div>
                        @endif

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
                                <input type="file" wire:model="photos" class="hidden" multiple accept="image/*">
                            </label>

                            <!-- Poll Button (Active) -->
                            <button type="button" wire:click="togglePoll"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors group {{ $isPoll ? 'bg-purple-50 dark:bg-purple-900/10' : '' }}">
                                <div
                                    class="p-1 rounded bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 group-hover:bg-purple-200 dark:group-hover:bg-purple-900/50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold {{ $isPoll ? 'text-purple-600 dark:text-purple-400' : 'text-zinc-600 dark:text-zinc-400' }}">Enquete</span>
                            </button>

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

                        <div wire:loading wire:target="photos, savePost"
                            class="mt-3 text-xs text-blue-600 dark:text-blue-400 font-medium flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Carregando fotos...
                        </div>

                        <!-- Multiple Photos Preview -->
                        @if ($photos && count($photos) > 0)
                            <div class="mt-4">
                                <div class="flex items-center justify-between mb-2 px-1">
                                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider">{{ count($photos) }} fotos selecionadas</span>
                                    <button type="button" wire:click="$set('photos', [])" class="text-xs text-red-500 hover:text-red-600 font-bold">REMOVER TODAS</button>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    @foreach($photos as $index => $p)
                                        <div class="relative group aspect-square rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-800 shadow-sm">
                                            <img src="{{ $p->temporaryUrl() }}" class="w-full h-full object-cover">
                                            <button type="button" wire:click="removePhoto({{ $index }})" 
                                                class="absolute top-1 right-1 bg-black/50 hover:bg-red-500 text-white p-1 rounded-full transition-colors backdrop-blur-sm">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                    
                                    @if(count($photos) < 5)
                                        <label class="cursor-pointer aspect-square rounded-xl border-2 border-dashed border-zinc-200 dark:border-zinc-800 flex flex-col items-center justify-center gap-1 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group">
                                            <svg class="w-5 h-5 text-zinc-400 group-hover:text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            <span class="text-[10px] font-bold text-zinc-400 group-hover:text-brand-500">ADICIONAR</span>
                                            <input type="file" wire:model="photos" class="hidden" multiple accept="image/*">
                                        </label>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @error('content') <span class="text-red-500 text-xs block mt-2 font-medium">{{ $message }}</span>
                        @enderror
                        @error('photos') <span class="text-red-500 text-xs block mt-2 font-medium">{{ $message }}</span>
                        @enderror
                        @error('photos.*') <span class="text-red-500 text-xs block mt-2 font-medium">{{ $message }}</span>
                        @enderror

                        @if($errors->any())
                            <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-100 dark:border-red-800">
                                <p class="text-xs text-red-600 dark:text-red-400 font-bold">Por favor, verifique os erros acima.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    @endif

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