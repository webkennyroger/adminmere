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

    <!-- Navigation Buttons -->
    <button x-cloak x-show="canScrollLeft" @click="scroll('left')"
        class="absolute left-[-20px] top-[40%] -translate-y-1/2 z-30 w-10 h-10 bg-white dark:bg-zinc-900 rounded-full shadow-lg border border-zinc-100 dark:border-zinc-800 flex items-center justify-center text-zinc-600 hover:text-brand-600 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <button x-cloak x-show="canScrollRight" @click="scroll('right')"
        class="absolute right-[-20px] top-[40%] -translate-y-1/2 z-30 w-10 h-10 bg-white dark:bg-zinc-900 rounded-full shadow-lg border border-zinc-100 dark:border-zinc-800 flex items-center justify-center text-zinc-600 hover:text-brand-600 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <!-- Stories List -->
    <div x-ref="storyList" @scroll.debounce.100ms="checkScroll()"
        class="flex gap-4 overflow-x-auto snap-x snap-mandatory no-scrollbar py-4 px-2"
        style="scrollbar-width: none; -ms-overflow-style: none;">

        <!-- Add Story Card -->
        <div class="flex-none snap-start">
            <div class="story-card group">
                <!-- Placeholder background or blurred user avatar -->
                <div class="absolute inset-0 bg-zinc-100 dark:bg-zinc-800">
                    <img src="{{ auth()->user()->image_url }}" class="w-full h-full object-cover blur-sm opacity-50">
                </div>

                <!-- Center Add Icon -->
                <div class="absolute inset-0 flex flex-col items-center justify-center z-10">
                    <div
                        class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-white drop-shadow-md">Criar Story</span>
                </div>

                <!-- Own Avatar at bottom -->
                <img src="{{ auth()->user()->image_url }}" class="story-avatar">
            </div>
        </div>

        <!-- Rendered Stories -->
        @foreach($stories as $story)
            <div class="flex-none snap-start">
                <div @click="openStory({{ json_encode($story) }})" class="story-card group">
                    <!-- Background Image -->
                    <img src="{{ $story['story_image'] }}" class="story-bg">

                    <!-- Avatar Box Overlay -->
                    <img src="{{ $story['avatar'] }}" class="story-avatar">

                    <!-- Name Label -->
                    <span class="story-name">
                        {{ $story['name'] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Viewer -->
    <template x-teleport="body">
        <div x-show="activeStory"
            class="fixed inset-0 z-[9999] bg-black/95 flex items-center justify-center backdrop-blur-sm"
            @click.self="closeStory" @keydown.escape.window="closeStory">
            <template x-if="activeStory">
                <div
                    class="relative w-full max-w-md h-full md:h-[80vh] bg-black md:rounded-2xl overflow-hidden shadow-2xl flex flex-col">
                    <div class="absolute top-0 left-0 right-0 z-20 px-2 pt-2 flex gap-1">
                        <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden">
                            <div class="h-full bg-white transition-all duration-100 ease-linear"
                                :style="'width: ' + progress + '%'"></div>
                        </div>
                    </div>
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
                    <div class="flex-1 flex items-center justify-center bg-zinc-900"><img :src="activeStory.story_image"
                            class="max-w-full max-h-full object-contain"></div>
                </div>
            </template>
        </div>
    </template>
</div>