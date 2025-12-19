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
                ERROR
            </h1>

            <img src="assets/images/error/500.svg" alt="500" class="dark:hidden" />
            <img src="assets/images/error/500-dark.svg" alt="500" class="hidden dark:block" />

            <p class="mt-10 mb-6 text-base text-zinc-700 dark:text-zinc-400 sm:text-lg">
                Não conseguimos encontrar a página que você está procurando!
            </p>

            <a href="/"
                class="inline-flex items-center justify-center rounded-lg border border-zinc-300 bg-white px-5 py-3.5 text-sm font-medium text-zinc-700 shadow-theme-xs hover:bg-zinc-50 hover:text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white/[0.03] dark:hover:text-zinc-200">
                Voltar à página inicial
            </a>
        </div>
        <!-- Footer -->
        <p class="absolute text-sm text-center text-zinc-500 -translate-x-1/2 bottom-6 left-1/2 dark:text-zinc-400">
            &copy; {{ $currentYear }} - TailAdmin
        </p>
    </div>
</x-layouts.fullscreen-layout>