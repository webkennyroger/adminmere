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

    <!-- Backdrop -->
    <div x-show="open"
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm dark:bg-black/60 pointer-events-auto transition-opacity z-[80]">
    </div>

    <!-- Modal Content -->
    <div x-show="open" 
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mt-7 sm:mt-10 ease-out transition-all {{ $maxWidth }} sm:w-full m-3 sm:mx-auto z-[90] relative">
        
        <div class="relative w-full max-h-full flex flex-col bg-white dark:bg-neutral-800 border border-transparent sm:border-gray-200 dark:sm:border-neutral-700 rounded-xl pointer-events-auto shadow-xl {{ $attributes->get('class') }}" @click.stop>
            
            <!-- Close Button -->
            @if ($showCloseButton)
                <div class="absolute top-2 end-2 z-10">
                    <button @click="open = false; $wire.dispatch('modal-closed')" type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200 hover:bg-gray-200 dark:hover:bg-neutral-600 focus:outline-hidden focus:bg-gray-200 dark:focus:bg-neutral-600 disabled:opacity-50 disabled:pointer-events-none transition-colors" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
            @endif

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
