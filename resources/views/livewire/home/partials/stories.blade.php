<div x-data="{ 
    activeStory: null, 
    progress: 0,
    timer: null,
    
    openStory(story) { 
        this.activeStory = story; 
        this.startProgress();
        document.body.style.overflow = 'hidden';
    },
    
    closeStory() { 
        this.activeStory = null; 
        this.stopProgress();
        document.body.style.overflow = 'auto';
    },

    startProgress() {
        this.progress = 0;
        this.stopProgress();
        this.timer = setInterval(() => {
            this.progress += 1;
            if (this.progress >= 100) {
                this.closeStory();
            }
        }, 50); // 50ms * 100 = 5000ms (5 segundos)
    },

    stopProgress() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }
}" class="relative w-full mb-6">

    <!-- Lista de Stories -->
    <div class="flex gap-4 overflow-x-auto pb-2 no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
        <!-- Add Story Card -->
        <div
            class="shrink-0 w-32 h-48 relative rounded-xl overflow-hidden cursor-pointer group transition-transform hover:scale-105">
            <div class="absolute inset-0 bg-zinc-800"></div>
            <!-- User Image as Background -->
            <img src="{{ auth()->user()->image_url }}"
                class="w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity duration-500">

            <div class="absolute inset-0 flex flex-col items-center justify-center pt-8">
                <div
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="text-white font-medium text-xs mt-8">Criar Story</span>
            </div>
        </div>

        <!-- Rendered Stories -->
        @foreach($stories as $story)
            <div @click="openStory({{ json_encode($story) }})"
                class="shrink-0 w-32 h-48 relative rounded-xl overflow-hidden cursor-pointer group transition-transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 z-10"></div>
                <img src="{{ $story['story_image'] }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                <div class="absolute top-3 left-0 right-0 flex justify-center z-20">
                    <div class="w-10 h-10 rounded-full border-2 border-brand-500 p-0.5 bg-white">
                        <img src="{{ $story['avatar'] }}" class="w-full h-full rounded-full object-cover">
                    </div>
                </div>

                <div class="absolute bottom-3 left-0 right-0 text-center z-20 px-1">
                    <span class="text-white font-medium text-xs truncate block">{{ $story['name'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Full Screen Viewer -->
    <template x-teleport="body">
        <div x-show="activeStory"
            class="fixed inset-0 z-[9999] bg-black bg-opacity-95 flex items-center justify-center backdrop-blur-sm"
            @click.self="closeStory" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            <div
                class="relative w-full max-w-md h-full md:h-[80vh] bg-black md:rounded-2xl overflow-hidden shadow-2xl flex flex-col">

                <!-- Barra de Progresso -->
                <div class="absolute top-0 left-0 right-0 z-20 px-2 pt-2 flex gap-1">
                    <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full bg-white transition-all duration-100 ease-linear"
                            :style="'width: ' + progress + '%'"></div>
                    </div>
                </div>

                <!-- Header (Avatar + Nome + Fechar) -->
                <div class="absolute top-6 left-0 right-0 z-20 px-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img :src="activeStory.avatar" class="w-10 h-10 rounded-full border-2 border-white/50">
                        <span class="text-white font-semibold text-sm drop-shadow-md" x-text="activeStory.name"></span>
                    </div>
                    <button @click="closeStory" class="text-white/80 hover:text-white">
                        <svg class="w-8 h-8 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Imagem do Story -->
                <div class="flex-1 flex items-center justify-center bg-zinc-900 relative">
                    <img :src="activeStory.story_image" class="max-w-full max-h-full object-contain">
                </div>

                <!-- Footer (Input fictício para resposta) -->
                <div class="absolute bottom-0 left-0 right-0 z-20 p-4 bg-gradient-to-t from-black/80 to-transparent">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex-1 h-12 rounded-full border border-white/30 bg-white/10 flex items-center px-4 text-white/70 text-sm backdrop-blur-md">
                            Responder a <span x-text="activeStory.name" class="ml-1"></span>...
                        </div>
                        <button class="text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                        <button class="text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>