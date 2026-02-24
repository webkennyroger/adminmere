<div x-data="{
    activeStory: null,
    progress: 0,
    timer: null,
    canScrollLeft: false,
    canScrollRight: false,

    get scrollContainer() { return this.$refs.storyList },

    checkScroll() {
        const el = this.scrollContainer;
        this.canScrollLeft = el.scrollLeft > 5;
        this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 5);
    },

    scroll(direction) {
        const el = this.scrollContainer;
        const scrollAmount = el.clientWidth * 0.8;
        el.scrollBy({
            left: direction === 'right' ? scrollAmount : -scrollAmount,
            behavior: 'smooth'
        });
    },

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
}" x-init="setTimeout(() => checkScroll(), 100)" class="relative w-full mb-8 group/parent">

    <!-- Navigation Buttons (Desktop Only) -->
    <button x-cloak x-show="canScrollLeft" @click="scroll('left')"
        class="absolute left-[-24px] top-[45%] -translate-y-1/2 z-30 w-12 h-12 bg-white dark:bg-zinc-900 rounded-full shadow-xl border border-zinc-100 dark:border-zinc-800 hidden lg:flex items-center justify-center text-zinc-600 hover:text-brand-600 transition-all opacity-0 group-hover/parent:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <button x-cloak x-show="canScrollRight" @click="scroll('right')"
        class="absolute right-[-24px] top-[45%] -translate-y-1/2 z-30 w-12 h-12 bg-white dark:bg-zinc-900 rounded-full shadow-xl border border-zinc-100 dark:border-zinc-800 hidden lg:flex items-center justify-center text-zinc-600 hover:text-brand-600 transition-all opacity-0 group-hover/parent:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <!-- Stories List — SocialV Premium Carousel -->
    <div x-ref="storyList" @scroll.debounce.100ms="checkScroll()"
        class="flex gap-4 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-10"
        style="scrollbar-width: none; -ms-overflow-style: none;">
        <!-- Add Story Card -->
        <div class="flex-none w-[130px] sm:w-[155px] md:w-[175px] lg:w-[190px] snap-start">
            <div class="flex flex-col items-center gap-3">
                <div
                    class="relative w-full aspect-[1/1.55] rounded-2xl overflow-hidden shadow-sm group cursor-pointer border-2 border-dashed border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all duration-300 flex flex-col items-center justify-center gap-3 text-zinc-400">
                    <div
                        class="w-12 h-12 rounded-full bg-brand-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>

                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2">
                        <div
                            class="p-1 px-1 bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-100 dark:border-zinc-800">
                            <img src="{{ auth()->user()->image_url }}" class="w-12 h-12 rounded-lg object-cover">
                        </div>
                    </div>
                </div>
                <span
                    class="text-[13px] font-bold text-zinc-800 dark:text-zinc-200 mt-5 truncate w-full text-center">Criar
                    Story</span>
            </div>
        </div>

        <!-- Rendered Stories -->
        @foreach($stories->where('is_own', false) as $story)
            <div class="flex-none w-[130px] sm:w-[155px] md:w-[175px] lg:w-[190px] snap-start">
                <div @click="openStory({{ json_encode($story) }})" class="flex flex-col items-center gap-3 group">
                    <div
                        class="relative w-full aspect-[1/1.55] rounded-2xl overflow-hidden shadow-md cursor-pointer border border-zinc-100/50 dark:border-zinc-800">
                        <img src="{{ $story['story_image'] }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                        <div
                            class="absolute inset-0 bg-linear-to-b from-black/5 via-transparent to-black/50 transition-opacity group-hover:opacity-80">
                        </div>

                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2">
                            <div
                                class="p-1.5 bg-white dark:bg-zinc-950 rounded-xl shadow-xl border border-zinc-100 dark:border-zinc-800">
                                <img src="{{ $story['avatar'] }}" class="w-12 h-12 rounded-lg object-cover">
                            </div>
                        </div>
                    </div>
                    <span
                        class="text-[13px] font-bold text-zinc-700 dark:text-zinc-300 mt-5 truncate w-full text-center group-hover:text-brand-600 transition-colors">{{ $story['name'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Full Screen Viewer -->
    <template x-teleport="body">
        <div x-show="activeStory"
            class="fixed inset-0 z-9999 bg-black/95 flex items-center justify-center backdrop-blur-sm"
            @click.self="closeStory" @keydown.escape.window="closeStory"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">

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
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>
</div>