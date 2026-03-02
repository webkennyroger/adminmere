<x-layouts.fullscreen-layout>
 @php
 $currentYear = date('Y');
 @endphp
 <div class="relative flex flex-col items-center justify-center min-h-screen p-6 overflow-hidden z-1">
 {{-- common grid shape --}}
 <x-common.common-grid-shape />
 <!-- Centered Content -->
 <div class="mx-auto w-full max-w-[242px] text-center sm:max-w-[472px]">
 <h1 class="mb-8 font-bold text-zinc-800 text-title-md dark:text-white/90 xl:text-title-2xl">
 419 | PÁGINA EXPIRADA
 </h1>

 <div class="relative w-full h-48 flex items-center justify-center mb-8">
 <div class="text-[120px] font-bold text-zinc-200 dark:text-zinc-800 select-none">
 419
 </div>
 <div class="absolute inset-0 flex items-center justify-center">
 <svg class="w-24 h-24 text-zinc-400 dark:text-zinc-600" fill="none" stroke="currentColor"
 viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
 </svg>
 </div>
 </div>

 <p class="mt-10 mb-6 text-base text-zinc-700 dark:text-zinc-400 sm:text-lg">
 Sua sessão expirou. Por favor, tente novamente.
 </p>

 <div class="flex flex-col sm:flex-row gap-3 justify-center">
 <button onclick="window.history.back()"
 class="inline-flex items-center justify-center border border-zinc-300 bg-white px-5 py-3.5 text-sm font-medium text-zinc-700 shadow-theme-xs hover:bg-zinc-50 hover:text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white/[0.03] dark:hover:text-zinc-200">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
 </svg>
 Voltar
 </button>
 <a href="/"
 class="inline-flex items-center justify-center bg-brand-600 px-5 py-3.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-700 dark:bg-brand-500 dark:hover:bg-brand-600">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
 </path>
 </svg>
 Página Inicial
 </a>
 </div>
 </div>
 <!-- Footer -->
 <p class="absolute text-sm text-center text-zinc-500 -translate-x-1/2 bottom-6 left-1/2 dark:text-zinc-400">
 &copy; {{ $currentYear }} - Mere
 </p>
 </div>
</x-layouts.fullscreen-layout>