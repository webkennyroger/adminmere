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
}" x-init="setTimeout(() => checkScroll(), 100)"
    class="relative w-full max-w-5xl mx-auto bg-[#F8F9FA] p-8 overflow-hidden">

    <div x-ref="storyList" @scroll.debounce.100ms="checkScroll()"
        class="flex items-center space-x-6 overflow-x-auto pb-4 scrollbar-hide">

        <!-- Add Story Card -->
        <div class="flex flex-col items-center flex-shrink-0">
            <div
                class="w-[104px] h-[136px] rounded-xl relative shadow-sm bg-gray-100 group cursor-pointer overflow-hidden">
                <img src="{{ auth()->user()->image_url }}" alt="Background"
                    class="w-full h-full object-cover rounded-xl blur-sm opacity-50" />

                <div class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 group">
                    <img src="{{ auth()->user()->image_url }}" alt="{{ auth()->user()->name }}"
                        class="w-8 h-8 rounded-lg border-2 border-white object-cover bg-gray-200" />
                </div>
            </div>
            <span class="mt-5 text-[11px] font-medium text-gray-700">Criar Story</span>
        </div>

        <!-- Followers Stories -->
        @foreach($stories as $story)
            <div class="flex flex-col items-center flex-shrink-0" @click="openStory({{ json_encode($story) }})">
                <div class="w-[104px] h-[136px] rounded-xl relative shadow-sm cursor-pointer group">
                    <img src="{{ $story['story_image'] }}" alt="Background" class="w-full h-full object-cover rounded-xl" />

                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 group">
                        <img src="{{ $story['avatar'] }}" alt="{{ $story['name'] }}"
                            class="w-8 h-8 rounded-lg border-2 border-white object-cover shadow-sm bg-gray-200" />

                        <div
                            class="absolute opacity-0 group-hover:opacity-100 transition-opacity bottom-full left-1/2 transform -translate-x-1/2 mb-1.5 bg-white text-gray-600 text-[10px] px-2 py-0.5 border border-gray-200 shadow-sm whitespace-nowrap z-10">
                            {{ $story['name'] }}
                        </div>
                    </div>
                </div>
                <span
                    class="mt-5 text-[11px] font-medium text-gray-700 truncate w-[104px] text-center">{{ $story['name'] }}</span>
            </div>
        @endforeach

    </div>

    <button x-cloak x-show="canScrollRight" @click="scroll('right')"
        class="absolute right-4 top-[40%] transform -translate-y-1/2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md text-gray-800 hover:bg-gray-50 z-10 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

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
                    <div class="flex-1 flex items-center justify-center bg-zinc-900">
                        <img :src="activeStory.story_image" class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            </template>
        </div>
    </template>

</div>