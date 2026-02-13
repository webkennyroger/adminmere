<!-- Lightbox Component for Post Images -->
<div x-data="{
    lightbox: false,
    currentImage: 0,
    images: [],
    openLightbox(images, index) {
        this.images = images;
        this.currentImage = index;
        this.lightbox = true;
        document.body.style.overflow = 'hidden';
    },
    closeLightbox() {
        this.lightbox = false;
        document.body.style.overflow = '';
    },
    nextImage() {
        this.currentImage = (this.currentImage + 1) % this.images.length;
    },
    prevImage() {
        this.currentImage = (this.currentImage - 1 + this.images.length) % this.images.length;
    }
}" @keydown.escape.window="if(lightbox) closeLightbox()" @keydown.arrow-right.window="if(lightbox) nextImage()"
    @keydown.arrow-left.window="if(lightbox) prevImage()"
    @open-lightbox.window="openLightbox($event.detail.images, $event.detail.index)">

    <!-- Lightbox Modal -->
    <div x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/95" @click="closeLightbox()"
        style="display: none;">

        <!-- Close Button -->
        <button @click="closeLightbox()"
            class="absolute top-4 right-4 z-60 p-2 rounded-full bg-white/10 hover:bg-white/20 transition-colors">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Previous Button -->
        <button x-show="images.length > 1" @click.stop="prevImage()"
            class="absolute left-4 z-60 p-3 rounded-full bg-white/10 hover:bg-white/20 transition-colors">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Image -->
        <div @click.stop class="max-w-7xl max-h-[90vh] w-full h-full flex items-center justify-center p-4">
            <img :src="images[currentImage]" class="max-w-full max-h-full object-contain rounded-lg" alt="Post image">
        </div>

        <!-- Next Button -->
        <button x-show="images.length > 1" @click.stop="nextImage()"
            class="absolute right-4 z-60 p-3 rounded-full bg-white/10 hover:bg-white/20 transition-colors">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Image Counter -->
        <div x-show="images.length > 1"
            class="absolute bottom-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded-full bg-black/50 text-white text-sm font-medium">
            <span x-text="currentImage + 1"></span> / <span x-text="images.length"></span>
        </div>
    </div>
</div>