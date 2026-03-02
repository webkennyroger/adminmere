@props([
 'type' => 'success', // success, info, warning, error
 'message' => '',
 'title' => '',
 'duration' => 5000,
])

@php
$config = [
 'success' => [
 'bg' => 'bg-green-500',
 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
 'title' => $title ?: 'Sucesso!',
 ],
 'info' => [
 'bg' => 'bg-blue-500',
 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
 'title' => $title ?: 'Informação',
 ],
 'warning' => [
 'bg' => 'bg-yellow-500',
 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
 'title' => $title ?: 'Atenção!',
 ],
 'error' => [
 'bg' => 'bg-red-500',
 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
 'title' => $title ?: 'Erro!',
 ],
];

$currentConfig = $config[$type] ?? $config['success'];
@endphp

<div 
 x-data="{ show: false }"
 x-init="
 setTimeout(() => show = true, 100);
 setTimeout(() => show = false, {{ $duration }});
 "
 x-show="show"
 x-transition:enter="transform ease-out duration-300 transition"
 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
 x-transition:leave="transition ease-in duration-100"
 x-transition:leave-start="opacity-100"
 x-transition:leave-end="opacity-0"
 class="pointer-events-auto w-full max-w-sm overflow-hidden bg-zinc-900 shadow-lg ring-1 ring-black ring-opacity-5"
 style="display: none;"
>
 <div class="p-4">
 <div class="flex items-start">
 <div class="flex-shrink-0">
 <div class="{{ $currentConfig['bg'] }} p-2">
 <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 {!! $currentConfig['icon'] !!}
 </svg>
 </div>
 </div>
 <div class="ml-3 w-0 flex-1 pt-0.5">
 <p class="text-sm font-medium text-white">{{ $currentConfig['title'] }}</p>
 <p class="mt-1 text-sm text-zinc-400">{{ $message }}</p>
 </div>
 <div class="ml-4 flex flex-shrink-0">
 <button 
 @click="show = false"
 class="inline-flex text-zinc-400 hover:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-zinc-900"
 >
 <span class="sr-only">Fechar</span>
 <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
 </svg>
 </button>
 </div>
 </div>
 <div class="mt-3 w-full {{ $currentConfig['bg'] }} h-1 "></div>
 </div>
</div>
