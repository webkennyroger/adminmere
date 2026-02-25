<div x-data="{
    activeStory: null,
    progress: 0,
    timer: null,
    canScrollLeft: false,
    canScrollRight: false,

    get scrollContainer() { return this.$refs.storyList },

    checkScroll() {
        const el = this.scrollContainer;
        if (!el) return;
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
        setTimeout(() => this.checkScroll(), 500);
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
    class="relative w-full max-w-5xl mx-auto p-4 md:p-8 overflow-hidden transition-all duration-300">

    <div x-ref="storyList" @scroll.debounce.100ms="checkScroll()"
        class="flex items-center space-x-6 overflow-x-auto pb-4 scrollbar-hide no-scrollbar scroll-smooth">

        <!-- Auth User Story (Add Story) -->
        <div class="flex flex-col items-center flex-shrink-0 min-w-0">
            <div class="w-28 h-36 flex-none rounded-xl relative shadow-sm cursor-pointer group"
                @click="{{ auth()->user()->stories()->where('expires_at', '>', now())->exists() ? 'openStory(JSON.parse($el.querySelector(\'.myStoryData\').value))' : '$refs.photoInput.click()' }}">

                <!-- Hidden File Input -->
                <input type="file" x-ref="photoInput" wire:model="photo" class="hidden"
                    accept="image/*,video/mp4,video/quicktime,video/webm">

                <div
                    class="w-full h-full overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800 ring-2 {{ auth()->user()->stories()->where('expires_at', '>', now())->exists() ? 'ring-green-500' : 'ring-transparent' }} group-hover:ring-green-400 transition-all">
                    <!-- Conditional Rendering Based on whether the user has a story -->
                    @if(auth()->user()->stories()->where('expires_at', '>', now())->exists())
                        @php
                            $latest = auth()->user()->stories()->latest()->first();
                            $isVideo = preg_match('/\.(mp4|mov|avi|webm)$/i', $latest->image_url);

                            $myStoryJson = json_encode([
                                'id' => $latest->id,
                                'name' => 'Meu Story',
                                'avatar' => auth()->user()->image_url,
                                'story_image' => $latest->image_url,
                                'profile_url' => profile_url(auth()->user()),
                                'type' => $isVideo ? 'video' : 'image',
                            ]);
                        @endphp

                        @if($isVideo)
                            <video src="{{ $latest->image_url }}"
                                class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform duration-700"
                                autoplay muted loop playsinline></video>
                        @else
                            <img src="{{ $latest->image_url }}" alt="Background"
                                class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform duration-700" />
                        @endif

                        <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 z-10 w-full flex justify-center pb-2 pointer-events-none"
                            style="pointer-events: none;">
                            <input type="hidden" class="myStoryData" value="{{ $myStoryJson }}">
                        </div>
                    @else
                        <img src="{{ auth()->user()->image_url }}" alt="Background"
                            class="w-full h-full object-cover rounded-xl opacity-60 dark:opacity-40 group-hover:scale-110 transition-transform duration-500" />

                        <!-- Center Plus Icon -->
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div
                                class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white shadow-lg group-hover:bg-green-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Bottom avatar, always present over background -->
                <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 z-10">
                    <img src="{{ auth()->user()->image_url }}" alt="{{ auth()->user()->name }}"
                        class="w-10 h-10 rounded-lg border-2 border-white dark:border-zinc-900 object-cover bg-zinc-200 dark:bg-zinc-700 shadow-sm pointer-events-auto" />

                    @if(auth()->user()->stories()->where('expires_at', '>', now())->exists())
                        <!-- Overlaid plus floating button to add MORE stories, separate from the rest of the div which triggers open modal -->
                        <div class="absolute -right-2 -bottom-2 pointer-events-auto" @click.stop="$refs.photoInput.click()">
                            <div class="w-6 h-6 rounded-full bg-green-600 border border-white dark:border-zinc-800 flex items-center justify-center text-white shadow-md hover:bg-green-700 transition-colors cursor-pointer"
                                title="Add another story">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Loading State overlay -->
                <div wire:loading wire:target="photo"
                    class="absolute inset-0 bg-black/50 rounded-xl flex items-center justify-center z-20">
                    <div class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
            <span class="mt-5 text-[11px] font-semibold text-zinc-700 dark:text-zinc-300">Meu Story</span>
        </div>

        <!-- Followers Stories -->
        @foreach($stories as $story)
            @continue($story['is_own'])
            <div class="flex flex-col items-center flex-shrink-0 min-w-0">
                <div class="w-28 h-36 flex-none rounded-xl relative shadow-sm cursor-pointer group"
                    @click="{{ $story['has_story'] ? 'openStory(' . json_encode($story) . ')' : 'window.location.href=\'' . $story['profile_url'] . '\'' }}">

                    <div
                        class="w-full h-full overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800 ring-2 {{ $story['has_story'] ? 'ring-green-500' : 'ring-transparent' }} group-hover:ring-green-400 transition-all">
                        @if(preg_match('/\.(mp4|mov|avi|webm)$/i', $story['story_image']))
                            <video src="{{ $story['story_image'] }}"
                                class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform duration-700 {{ $story['has_story'] ? '' : 'opacity-70 grayscale-[0.3]' }}"
                                autoplay muted loop playsinline></video>
                        @else
                            <img src="{{ $story['story_image'] }}" alt="Background"
                                class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform duration-700 {{ $story['has_story'] ? '' : 'opacity-70 grayscale-[0.3]' }}" />
                        @endif
                    </div>

                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 z-10">
                        <img src="{{ $story['avatar'] }}" alt="{{ $story['name'] }}"
                            class="w-10 h-10 rounded-lg border-2 border-white dark:border-zinc-900 object-cover shadow-sm bg-zinc-200 dark:bg-zinc-700 pointer-events-none" />

                        <div
                            class="absolute opacity-0 group-hover:opacity-100 transition-opacity bottom-full left-1/2 transform -translate-x-1/2 mb-2 bg-zinc-900 text-white text-[10px] px-2 py-0.5 rounded-md shadow-xl whitespace-nowrap z-10 pointer-events-none">
                            {{ $story['name'] }}
                        </div>
                    </div>
                </div>
                <span
                    class="mt-5 text-[11px] font-medium text-zinc-600 dark:text-zinc-400 truncate w-28 text-center">{{ $story['name'] }}</span>
            </div>
        @endforeach

    </div>

    <!-- Navigation Buttons -->
    <button x-cloak x-show="canScrollLeft" @click="scroll('left')"
        class="absolute left-4 top-[40%] transform -translate-y-1/2 w-8 h-8 bg-white/90 dark:bg-zinc-800/90 rounded-full flex items-center justify-center shadow-lg text-zinc-800 dark:text-white hover:bg-white dark:hover:bg-zinc-700 z-10 transition-all backdrop-blur-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <button x-cloak x-show="canScrollRight" @click="scroll('right')"
        class="absolute right-4 top-[40%] transform -translate-y-1/2 w-8 h-8 bg-white/90 dark:bg-zinc-800/90 rounded-full flex items-center justify-center shadow-lg text-zinc-800 dark:text-white hover:bg-white dark:hover:bg-zinc-700 z-10 transition-all backdrop-blur-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <!-- Modal Viewer -->
    <template x-teleport="body">
        <div x-show="activeStory" x-transition.opacity
            class="fixed inset-0 z-[9999] bg-zinc-950/95 flex items-center justify-center backdrop-blur-md"
            @click.self="closeStory" @keydown.escape.window="closeStory">

            <template x-if="activeStory">
                <div
                    class="relative w-full max-w-md h-full md:h-[85vh] bg-black md:rounded-3xl overflow-hidden shadow-2xl flex flex-col mx-auto transition-all transform scale-100">

                    <!-- Progress Bar -->
                    <div class="absolute top-0 left-0 right-0 z-20 px-2 pt-2 flex gap-1">
                        <div class="h-1 flex-1 bg-white/20 rounded-full overflow-hidden">
                            <div class="h-full bg-white transition-all duration-100 ease-linear"
                                :style="'width: ' + progress + '%'"></div>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="absolute top-6 left-0 right-0 z-30 px-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img :src="activeStory.avatar"
                                class="w-10 h-10 rounded-full border-2 border-green-500 shadow-lg">
                            <div class="flex flex-col">
                                <span class="text-white font-bold text-sm drop-shadow-md"
                                    x-text="activeStory.name"></span>
                                <span class="text-white/60 text-[10px]" x-text="'Story'"></span>
                            </div>
                        </div>
                        <button @click="closeStory"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/40 text-white transition backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Main Image / Video -->
                    <div class="flex-1 flex items-center justify-center bg-zinc-900/50">
                        <template x-if="activeStory.story_image.match(/\.(mp4|mov|avi|webm)$/i)">
                            <video :src="activeStory.story_image" class="w-full h-full object-contain" autoplay
                                playsinline loop></video>
                        </template>
                        <template x-if="!activeStory.story_image.match(/\.(mp4|mov|avi|webm)$/i)">
                            <img :src="activeStory.story_image" class="w-full h-full object-contain">
                        </template>
                    </div>

                    <!-- Footer / Interaction Placeholder -->
                    <div class="absolute bottom-10 left-0 right-0 p-6 flex justify-center">
                        <a :href="activeStory.profile_url"
                            class="px-6 py-2 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-full text-xs font-semibold border border-white/20 transition-all">
                            Ver Perfil
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </template>
</div>