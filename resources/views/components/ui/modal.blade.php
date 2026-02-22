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
        class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm dark:bg-black/60 pointer-events-auto transition-opacity">
    </div>

    <!-- Modal Content Window -->
    <div x-show="open" 
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mt-7 sm:mt-10 ease-out transition-all {{ $maxWidth }} sm:w-full m-3 sm:mx-auto">
        
        <div class="relative w-full max-h-full flex flex-col bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl pointer-events-auto shadow-2xl {{ $attributes->get('class') }}" @click.stop>
            
            <!-- Close Button -->
            @if ($showCloseButton)
                <div class="absolute top-2 end-2 z-10">
                    <button @click="open = false" type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-transparent text-zinc-500 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200 focus:outline-none disabled:opacity-50 disabled:pointer-events-none transition-colors">
                        <span class="sr-only">Fechar</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Modal Body -->
            <div class="p-4 sm:p-6 overflow-y-auto">
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
