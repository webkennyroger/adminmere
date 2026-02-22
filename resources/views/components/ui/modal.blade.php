@props([
    'isOpen' => false,
    'showCloseButton' => true,
    'maxWidth' => 'sm:max-w-lg',
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
    }" 
    {{ $entangle ? '' : 'x-effect=open=' . ($isOpen ? 'true' : 'false') }} 
    x-show="open" 
    x-cloak 
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-[100] overflow-x-hidden overflow-y-auto pointer-events-none" 
    role="dialog" 
    tabindex="-1">
    
    <!-- Backdrop Overlay -->
    <div x-show="open"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm dark:bg-neutral-900/80 pointer-events-auto z-[99]">
    </div>

    <!-- Modal Box (hs-cookies clone) -->
    <div class="fixed inset-0 z-[101] overflow-y-auto overflow-x-hidden flex items-start justify-center p-4 pt-8 sm:pt-14 pointer-events-none">
        <div x-show="open" 
            x-transition:enter="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 ease-out transition-all duration-500" 
            x-transition:enter-start="opacity-0 mt-0"
            x-transition:enter-end="opacity-100 mt-7" 
            x-transition:leave="ease-out transition-all duration-300"
            x-transition:leave-start="opacity-100 mt-7"
            x-transition:leave-end="opacity-0 mt-0"
            class="relative w-full {{ $maxWidth }} flex flex-col bg-white dark:bg-neutral-800 border border-transparent rounded-xl pointer-events-auto shadow-xl {{ $attributes->get('class') }}" 
            @click.stop>
            
            @if ($showCloseButton)
            <div class="absolute top-2 end-2 z-10">
                <button @click="open = false; $wire.dispatch('modal-closed')" type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200 hover:bg-gray-200 dark:hover:bg-neutral-600 focus:outline-hidden focus:bg-gray-200 dark:focus:bg-neutral-600 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none;
    }
</style>