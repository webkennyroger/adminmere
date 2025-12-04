<!-- Toast Container - Add this to your main layout -->
<div 
    x-data="toastManager()"
    @toast.window="addToast($event.detail)"
    class="fixed top-4 right-4 z-50 space-y-4 pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div 
            x-show="toast.show"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-zinc-900 shadow-lg ring-1 ring-black ring-opacity-5"
        >
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div 
                            class="rounded-lg p-2"
                            :class="{
                                'bg-green-500': toast.type === 'success',
                                'bg-blue-500': toast.type === 'info',
                                'bg-yellow-500': toast.type === 'warning',
                                'bg-red-500': toast.type === 'error'
                            }"
                        >
                            <!-- Success Icon -->
                            <svg x-show="toast.type === 'success'" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <!-- Info Icon -->
                            <svg x-show="toast.type === 'info'" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <!-- Warning Icon -->
                            <svg x-show="toast.type === 'warning'" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <!-- Error Icon -->
                            <svg x-show="toast.type === 'error'" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-white" x-text="toast.title"></p>
                        <p class="mt-1 text-sm text-zinc-400" x-text="toast.message"></p>
                    </div>
                    <div class="ml-4 flex flex-shrink-0">
                        <button 
                            @click="removeToast(toast.id)"
                            class="inline-flex rounded-md text-zinc-400 hover:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-900"
                        >
                            <span class="sr-only">Fechar</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div 
                    class="mt-3 w-full h-1 rounded-full"
                    :class="{
                        'bg-green-500': toast.type === 'success',
                        'bg-blue-500': toast.type === 'info',
                        'bg-yellow-500': toast.type === 'warning',
                        'bg-red-500': toast.type === 'error'
                    }"
                ></div>
            </div>
        </div>
    </template>
</div>

<script>
function toastManager() {
    return {
        toasts: [],
        
        addToast(data) {
            const id = Date.now();
            const titles = {
                success: 'Sucesso!',
                info: 'Informação',
                warning: 'Atenção!',
                error: 'Erro!'
            };
            
            const toast = {
                id,
                type: data.type || 'success',
                title: data.title || titles[data.type] || 'Notificação',
                message: data.message || '',
                show: false
            };
            
            this.toasts.push(toast);
            
            // Show toast with slight delay for animation
            setTimeout(() => {
                const toastIndex = this.toasts.findIndex(t => t.id === id);
                if (toastIndex !== -1) {
                    this.toasts[toastIndex].show = true;
                }
            }, 100);
            
            // Auto remove after duration
            setTimeout(() => {
                this.removeToast(id);
            }, data.duration || 5000);
        },
        
        removeToast(id) {
            const toastIndex = this.toasts.findIndex(t => t.id === id);
            if (toastIndex !== -1) {
                this.toasts[toastIndex].show = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300);
            }
        }
    }
}

// Global toast function
window.showToast = function(type, message, title = null, duration = 5000) {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { type, message, title, duration }
    }));
}
</script>
