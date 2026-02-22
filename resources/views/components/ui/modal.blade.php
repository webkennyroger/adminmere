@props([
    'isOpen' => false,
    'showCloseButton' => true,
    'maxWidth' => 'sm:max-w-xl',
])

@php
    $wireModel = $attributes->wire('model');
    $entangle = $wireModel->value() ? "\$wire.entangle('".$wireModel->value()."')" : null;
@endphp

<div x-data="{
    open: {{ $entangle ?? '@js($isOpen)' }},
    init() {
        this.$watch('open', value => {
            if (value) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'unset';
            }
        });
    }
}" {{ $entangle ? '' : 'x-effect=open=' . ($isOpen ? 'true' : 'false') }} x-show="open" x-cloak @keydown.escape.window="open = false"
    class="size-full fixed top-0 start-0 z-[100] overflow-x-hidden overflow-y-auto pointer-events-none" aria-labelledby="modal-title" role="dialog" aria-modal="true"
    {{ $attributes->whereDoesntStartWith('wire:model')->except('class') }}>

    <!-- Backdrop Overlay -->
    <div x-show="open"
        x-transition.opacity.duration.300ms
        @click="open = false"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm dark:bg-black/60 pointer-events-auto transition-opacity z-[99]">
    </div>

    <!-- Modal Content Window mimicking the requested style snippet -->
    <div class="fixed inset-0 z-[100] overflow-y-auto overflow-x-hidden flex items-start justify-center pt-8 sm:pt-10 px-4 pb-4 pointer-events-none">
        <div x-show="open" 
            x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full {{ $maxWidth }} flex flex-col bg-white dark:bg-neutral-800 border border-transparent sm:border-gray-200 dark:sm:border-neutral-700 rounded-xl pointer-events-auto shadow-xl {{ $attributes->get('class') }}" @click.stop>
            
            <!-- Close Button -->
            @if ($showCloseButton)
                <div class="absolute top-2 end-2 z-10">
                    <button @click="open = false" type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200 hover:bg-gray-200 dark:hover:bg-neutral-600 focus:outline-hidden focus:bg-gray-200 dark:focus:bg-neutral-600 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Modal Body (The injected content handles its own padding to replicate the Vercel Alert style if needed) -->
            <div class="overflow-y-auto">
                {{ $slot }}
            </div>
            
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none;
    }
</style>
