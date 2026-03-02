<div x-data="{
        isOpen: false,
        images: [],
        currentIndex: 0,
        handleOpen(e) {
            this.images = e.detail.images;
            this.currentIndex = e.detail.index || 0;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },
        next() {
            if (this.currentIndex < this.images.length - 1) {
                this.currentIndex++;
            }
        },
        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            }
        }
    }" x-show="isOpen" @open-lightbox.window="handleOpen($event)" @keydown.escape.window="close()"
    @keydown.right.window="next()" @keydown.left.window="prev()"
    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm" x-transition.opacity
    style="display: none;">

    <!-- Close Button -->
    <button @click="close()"
        class="absolute top-4 right-4 text-white hover:text-zinc-300 transition-colors p-2 z-50 rounded-full bg-black/20 hover:bg-black/40">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Prev Button -->
    <button x-show="images.length > 1 && currentIndex > 0" @click="prev()"
        class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-zinc-300 transition-colors p-2 rounded-full bg-black/20 hover:bg-black/40 z-50">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Next Button -->
    <button x-show="images.length > 1 && currentIndex < images.length - 1" @click="next()"
        class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-zinc-300 transition-colors p-2 rounded-full bg-black/20 hover:bg-black/40 z-50">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Image / Video -->
    <div class="max-w-7xl max-h-screen p-4 flex items-center justify-center w-full h-full" @click.self="close()">
        <template
            x-if="images[currentIndex] && typeof images[currentIndex] === 'string' && images[currentIndex].includes('.mp4')">
            <video :src="images[currentIndex]" controls
                class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" autoplay></video>
        </template>
        <template
            x-if="images[currentIndex] && (typeof images[currentIndex] !== 'string' || !images[currentIndex].includes('.mp4'))">
            <img :src="images[currentIndex]" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">
        </template>
    </div>

    <!-- Counters -->
    <div x-show="images.length > 1"
        class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white text-sm font-medium bg-black/40 px-4 py-1.5 rounded-full z-50">
        <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
    </div>
</div>