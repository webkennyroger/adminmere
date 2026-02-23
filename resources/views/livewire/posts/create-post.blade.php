<div x-data="{ modalFoto: false, modalVideo: false, modalEvento: false, modalEnquete: false }"
    class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-4 transition-all hover:shadow-md">

    {{-- Avatar + placeholder clicável --}}
    <div class="flex items-center gap-3 mb-4">
        @if(auth()->user()->image_url)
            <img src="{{ auth()->user()->image_url }}"
                class="w-10 h-10 rounded-full border border-zinc-100 dark:border-zinc-700 object-cover shrink-0">
        @else
            <div
                class="w-10 h-10 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        @endif
        <button type="button" @click="modalFoto = true"
            class="flex-1 text-left bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-full px-5 py-2.5 text-sm text-zinc-400 transition-colors cursor-pointer">
            O que você está pensando, {{ auth()->user()->name }}?
        </button>
    </div>

    {{-- Toolbar com 4 botões --}}
    <div class="flex flex-wrap items-center gap-1 pt-3 border-t border-zinc-100 dark:border-zinc-800">

        {{-- FOTO --}}
        <button type="button" @click="modalFoto = true"
            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
            <div class="p-1 rounded bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Foto</span>
        </button>

        {{-- VÍDEO --}}
        <button type="button" @click="modalVideo = true"
            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
            <div class="p-1 rounded bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M4 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Vídeo</span>
        </button>

        {{-- EVENTO --}}
        <button type="button" @click="modalEvento = true"
            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
            <div class="p-1 rounded bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Evento</span>
        </button>

        {{-- ENQUETE --}}
        <button type="button" @click="modalEnquete = true"
            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
            <div class="p-1 rounded bg-brand-100 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Enquete</span>
        </button>

    </div>

    {{-- ═══════════════════ MODAL FOTO ════════════════════════ --}}
    <div x-show="modalFoto" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/50" @click="modalFoto = false"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="font-bold text-lg text-zinc-900 dark:text-white">Adicionar foto à publicação</h3>
                <button @click="modalFoto = false"
                    class="text-zinc-400 hover:text-zinc-600 p-1 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Título</label>
                    <input type="text" wire:model="postForm.title"
                        placeholder="Dê um título para sua publicação (opcional)"
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Conteúdo</label>
                    <textarea wire:model="postForm.content" rows="3" placeholder="Compartilhe seus pensamentos..."
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent resize-none"></textarea>
                </div>
                {{-- Upload --}}
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Enviar foto</label>
                    <label class="cursor-pointer block">
                        <div
                            class="border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-xl p-10 flex flex-col items-center gap-3 hover:border-green-400 hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors">
                            <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-zinc-400">Arraste aqui ou clique para enviar foto.</span>
                        </div>
                        <input type="file" wire:model="postForm.photos" class="hidden" multiple accept="image/*">
                    </label>
                </div>
                {{-- Preview --}}
                @if ($postForm->photos && count($postForm->photos) > 0)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($postForm->photos as $photo)
                            @if(method_exists($photo, 'temporaryUrl'))
                                <div class="aspect-square rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                <div wire:loading wire:target="postForm.photos" class="text-xs text-blue-500 flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    Carregando fotos...
                </div>
            </div>
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">
                <button type="button" @click="modalFoto = false"
                    class="px-5 py-2 rounded-xl text-sm font-semibold text-red-500 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 transition-colors">Cancelar</button>
                <button type="button" wire:click="save" @click="modalFoto = false"
                    class="px-5 py-2 rounded-xl text-sm font-semibold text-green-600 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 transition-colors">Publicar</button>
            </div>
        </div>
    </div>

    {{-- ═══════════════════ MODAL VÍDEO ═══════════════════════ --}}
    <div x-show="modalVideo" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/50" @click="modalVideo = false"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="font-bold text-lg text-zinc-900 dark:text-white">Adicionar vídeo à publicação</h3>
                <button @click="modalVideo = false"
                    class="text-zinc-400 hover:text-zinc-600 p-1 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                {{-- Title Field --}}
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Título</label>
                    <input type="text" wire:model="postForm.title"
                        placeholder="Dê um título para sua publicação (opcional)"
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Conteúdo</label>
                    <textarea wire:model="postForm.content" rows="3" placeholder="Compartilhe seus pensamentos..."
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Enviar vídeo</label>
                    <label class="cursor-pointer block">
                        <div
                            class="border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-xl p-10 flex flex-col items-center gap-3 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                            <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M4 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8z" />
                            </svg>
                            <span class="text-sm text-zinc-400">Arraste aqui ou clique para enviar vídeo.</span>
                        </div>
                        <input type="file" wire:model="postForm.videos" class="hidden" accept="video/*">
                    </label>
                </div>
                {{-- Video Preview --}}
                @if ($postForm->videos && count($postForm->videos) > 0)
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($postForm->videos as $video)
                            @if(method_exists($video, 'temporaryUrl'))
                                <div
                                    class="aspect-video rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-black">
                                    <video src="{{ $video->temporaryUrl() }}" class="w-full h-full object-cover" controls></video>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                <div wire:loading wire:target="postForm.videos" class="text-xs text-blue-500 flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    Carregando vídeo...
                </div>
            </div>
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">
                <button type="button" @click="modalVideo = false"
                    class="px-5 py-2 rounded-xl text-sm font-semibold text-red-500 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 transition-colors">Cancelar</button>
                <button type="button" wire:click="save" @click="modalVideo = false"
                    class="px-5 py-2 rounded-xl text-sm font-semibold text-green-600 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 transition-colors">Publicar</button>
            </div>
        </div>
    </div>

    {{-- ═══════════════════ MODAL EVENTO ══════════════════════ --}}
    {{-- TODO: Implement Event creation in CreatePost component if needed --}}

    {{-- ═══════════════════ MODAL ENQUETE ═════════════════════ --}}
    <div x-show="modalEnquete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/50" @click="modalEnquete = false"></div>
        <div
            class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden max-h-[90vh] overflow-y-auto">
            <div
                class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 sticky top-0 bg-white dark:bg-zinc-900 z-10">
                <h3 class="font-bold text-lg text-zinc-900 dark:text-white">Criar enquete</h3>
                <button type="button" @click="modalEnquete = false"
                    class="text-zinc-400 hover:text-zinc-600 p-1 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                {{-- Title Field --}}
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Título</label>
                    <input type="text" wire:model="pollForm.title"
                        placeholder="Dê um título para sua enquete (opcional)"
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>

                {{-- Pergunta --}}
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Pergunta</label>
                    <textarea wire:model="pollForm.content" rows="2" placeholder="Qual a sua pergunta?"
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent resize-none"></textarea>
                </div>
                {{-- Opções --}}
                <div
                    class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 space-y-2.5">
                    <h4 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Opções da Enquete
                    </h4>
                    @foreach($pollForm->options as $index => $option)
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model="pollForm.options.{{ $index }}"
                                class="flex-1 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm px-3 py-2 focus:ring-brand-500 focus:border-brand-500 dark:text-white"
                                placeholder="Opção {{ $index + 1 }}">
                            @if($index > 1)
                                <button type="button" wire:click="removePollOption({{ $index }})"
                                    class="text-red-500 p-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                        @error('pollForm.options.' . $index) <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    @endforeach
                    @if(count($pollForm->options) < 5)
                        <button type="button" wire:click="addPollOption"
                            class="text-xs font-medium text-brand-600 dark:text-brand-400 flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Adicionar opção
                        </button>
                    @endif
                </div>
                {{-- Múltipla Escolha --}}
                <div class="flex items-center gap-2 mb-2">
                    <input type="checkbox" wire:model="pollForm.isMultiple" id="isMultiple"
                        class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500 border-zinc-300">
                    <label for="isMultiple" class="text-sm text-zinc-600 dark:text-zinc-400 cursor-pointer">Permitir
                        múltiplas escolhas</label>
                </div>

                {{-- Duração --}}
                <div class="flex items-center gap-3">
                    <span class="text-sm text-zinc-500">Duração:</span>
                    <select wire:model="pollForm.duration"
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-sm rounded-lg py-1.5 px-3">
                        <option value="1">1 Dia</option>
                        <option value="3">3 Dias</option>
                        <option value="7">1 Semana</option>
                        <option value="30">1 Mês</option>
                    </select>
                </div>
            </div>
            <div
                class="flex justify-end gap-3 px-6 py-4 border-t border-zinc-100 dark:border-zinc-800 sticky bottom-0 bg-white dark:bg-zinc-900">
                <button type="button" @click="modalEnquete = false"
                    class="px-5 py-2 rounded-xl text-sm font-semibold text-red-500 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 transition-colors">Cancelar</button>
                <button type="button"
                    x-on:click="$wire.set('isPoll', true); setTimeout(() => { $wire.save(); modalEnquete = false; }, 100)"
                    class="px-5 py-2 rounded-xl text-sm font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 dark:bg-brand-900/20 transition-colors">Publicar
                    enquete</button>
            </div>
        </div>
    </div>

</div>