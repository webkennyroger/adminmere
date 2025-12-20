<!-- Toast Container - All toasts in top center -->
<div x-data="toastManager()" @toast.window="addToast($event.detail)">
    <div class="fixed top-4 right-4 z-[999999] space-y-4 pointer-events-none w-full max-w-sm px-4 sm:px-0">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" x-transition:leave-end="opacity-0"
                class="pointer-events-auto w-full overflow-hidden rounded-lg shadow-lg bg-white dark:bg-zinc-800 ring-1 ring-black ring-opacity-5">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <div class="rounded-lg p-2" :class="toast.bgClass">
                                <!-- Success Icon -->
                                <svg x-show="toast.type === 'success'" class="h-5 w-5 text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <!-- Info Icon -->
                                <svg x-show="toast.type === 'info'" class="h-5 w-5 text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <!-- Warning/Custom Icon -->
                                <svg x-show="toast.type === 'warning' || toast.type === 'custom'"
                                    class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <!-- Error Icon -->
                                <svg x-show="toast.type === 'error'" class="h-5 w-5 text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium" :class="toast.textClass" x-text="toast.title"></p>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300" x-text="toast.message"></p>
                        </div>
                        <button @click="removeToast(toast.id)"
                            class="ml-4 shrink-0 text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>