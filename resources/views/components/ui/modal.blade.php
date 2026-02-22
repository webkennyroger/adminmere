@props([
    'isOpen' => false,
    'showCloseButton' => true,
    'maxWidth' => 'sm:max-w-xl',
    'padding' => 'p-6 sm:p-8',
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
    class="relative z-[99999]" aria-labelledby="modal-title" role="dialog" aria-modal="true"
    {{ $attributes->whereDoesntStartWith('wire:model')->except('class') }}>

    <!-- Backdrop -->
    <div x-show="open"
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm dark:bg-black/60 transition-opacity">
    </div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Content -->
            <div x-show="open" @click.away="open = false"
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full {{ $maxWidth }} transform overflow-hidden rounded-[2rem] bg-white dark:bg-zinc-900 text-left shadow-2xl ring-1 ring-zinc-200/50 dark:ring-zinc-800 transition-all sm:my-8 {{ $padding }} {{ $attributes->get('class') }}">

                <!-- Close Button -->
                @if ($showCloseButton)
                    <div class="absolute right-0 top-0 pr-5 pt-5 sm:pr-6 sm:pt-6 z-10">
                        <button @click="open = false" type="button"
                            class="rounded-full bg-zinc-50 dark:bg-zinc-800 p-2.5 text-zinc-400 hover:text-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-700 dark:hover:text-zinc-200 transition-all focus:outline-none focus:ring-2 focus:ring-zinc-200">
                            <span class="sr-only">Fechar</span>
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Modal Body -->
                <div class="relative">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none;
    }
</style>
