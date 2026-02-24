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
        }, 50);
    },

    stopProgress() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }
}" class="relative w-full mb-2">

    <!-- Stories List — Premium Grid Style -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">

        <!-- Add Story Card -->
        <div class="flex flex-col items-center gap-2">
            <div
                class="relative w-full aspect-3/4 rounded-xl overflow-hidden shadow-sm group cursor-pointer border-2 border-dashed border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors flex flex-col items-center justify-center gap-2 text-zinc-400">
                <div
                    class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                </div>
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2">
                    <div
                        class="p-1 bg-white dark:bg-zinc-950 rounded-lg shadow-md border border-zinc-100 dark:border-zinc-800">
                        <img src="{{ auth()->user()->image_url }}" class="w-8 h-8 rounded-md object-cover">
                    </div>
                </div>
            </div>
            <span class="text-[11px] font-bold text-zinc-700 dark:text-zinc-300 mt-3 truncate w-full text-center">Seu
                story</span>
        </div>

        <!-- Rendered Stories -->
        @foreach($stories->where('is_own', false)->take(6) as $story)
            <div @click="openStory({{ json_encode($story) }})" class="flex flex-col items-center gap-2">
                <div class="relative w-full aspect-3/4 rounded-xl overflow-hidden shadow-sm group cursor-pointer">
                    <img src="{{ $story['story_image'] }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/10 transition-colors group-hover:bg-black/20"></div>

                    <!-- Avatar overlapping bottom center -->
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2">
                        <div
                            class="p-1 bg-white dark:bg-zinc-950 rounded-lg shadow-md border border-zinc-100 dark:border-zinc-800">
                            <img src="{{ $story['avatar'] }}" class="w-8 h-8 rounded-md object-cover">
                        </div>
                    </div>
                </div>
                <span
                    class="text-[11px] font-bold text-zinc-700 dark:text-zinc-300 mt-3 truncate w-full text-center">{{ $story['name'] }}</span>
            </div>
        @endforeach

        {{-- Fallback empty slots to keep grid full if less than 6 stories --}}
        @if($stories->where('is_own', false)->count() < 6)
            @foreach(range(1, 6 - $stories->where('is_own', false)->count()) as $i)
                <div class="flex flex-col items-center gap-2 opacity-40">
                    <div
                        class="relative w-full aspect-3/4 rounded-xl overflow-hidden shadow-sm border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50">
                    </div>
                    <span class="text-[11px] font-bold text-zinc-400 mt-3 truncate w-full text-center">Disponível</span>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Modal Full Screen Viewer -->
    <template x-teleport="body">
        <div x-show="activeStory"
            class="fixed inset-0 z-9999 bg-black/95 flex items-center justify-center backdrop-blur-sm"
            @click.self="closeStory" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            <template x-if="activeStory">
                <div
                    class="relative w-full max-w-md h-full md:h-[80vh] bg-black md:rounded-2xl overflow-hidden shadow-2xl flex flex-col">

                    <!-- Progress Bar -->
                    <div class="absolute top-0 left-0 right-0 z-20 px-2 pt-2 flex gap-1">
                        <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden">
                            <div class="h-full bg-white transition-all duration-100 ease-linear"
                                :style="'width: ' + progress + '%'"></div>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="absolute top-6 left-0 right-0 z-20 px-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img :src="activeStory.avatar" class="w-10 h-10 rounded-full border-2 border-white/50">
                            <span class="text-white font-semibold text-sm drop-shadow-md"
                                x-text="activeStory.name"></span>
                        </div>
                        <button @click="closeStory" class="text-white/80 hover:text-white transition">
                            <svg class="w-8 h-8 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Story Image -->
                    <div class="flex-1 flex items-center justify-center bg-zinc-900 relative">
                        <img :src="activeStory.story_image" class="max-w-full max-h-full object-contain">
                    </div>

                    <!-- Footer -->
                    <div class="absolute bottom-0 left-0 right-0 z-20 p-4 bg-linear-to-t from-black/80 to-transparent">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-1 h-12 rounded-full border border-white/30 bg-white/10 flex items-center px-4 text-white/70 text-sm backdrop-blur-md">
                                Responder a <span x-text="activeStory.name" class="ml-1"></span>...
                            </div>
                            <button class="text-white hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                            <button class="text-white hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>
</div>