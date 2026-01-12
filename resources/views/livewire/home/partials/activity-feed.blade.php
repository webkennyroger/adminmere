<div class="space-y-6">
    <!-- Create Post Section -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="w-10 h-10 rounded-full bg-brand-50 dark:bg-brand-900/20 flex items-center justify-center text-brand-600 dark:text-brand-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                </svg>
            </div>
            <span class="font-medium text-zinc-500 dark:text-zinc-400">Criar Post</span>
        </div>

        <div class="flex gap-4 mb-4">
            <img src="{{ auth()->user()->image_url }}"
                class="w-10 h-10 rounded-full border border-zinc-100 dark:border-zinc-700">
            <div
                class="flex-1 bg-zinc-50 dark:bg-zinc-800 rounded-xl px-4 py-3 text-zinc-500 dark:text-zinc-400 cursor-text hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                O que está em sua mente?
            </div>
        </div>

        <div
            class="flex items-center justify-between sm:justify-start sm:gap-8 pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <button
                class="flex items-center gap-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-1.5 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium">Vídeo ao vivo</span>
            </button>
            <button
                class="flex items-center gap-2 text-green-500 hover:bg-green-50 dark:hover:bg-green-900/20 px-3 py-1.5 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium">Foto/Vídeo</span>
            </button>
            <button
                class="flex items-center gap-2 text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 px-3 py-1.5 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">Sentimento/Atividade</span>
            </button>
        </div>
    </div>

    <!-- Feed Items -->
    @forelse($activities as $activity)
        <livewire:home.partials.activity-item :activity="$activity" :key="'activity-' . $activity->id" />
    @empty
        <div class="text-center py-12">
            <p class="text-zinc-500 dark:text-zinc-400">Nenhuma atividade recente.</p>
        </div>
    @endforelse

    <!-- Loading Indicator -->
    <div class="flex justify-center py-8">
        <div class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5 text-brand-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-sm text-zinc-500 dark:text-zinc-400">Carregando mais posts...</span>
        </div>
    </div>
</div>