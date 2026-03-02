<div class="flex flex-col bg-blue-50/50 py-5 dark:bg-zinc-800 lg:flex-row">
 <div class="flex min-w-0 flex-col px-4 sm:px-5 lg:w-72 lg:shrink-0 lg:py-3">
 <div class="flex items-center justify-between">
 <h3 class="truncate text-base font-medium tracking-wide text-zinc-700 dark:text-zinc-100 lg:text-lg">
 Canais
 </h3>
 <button wire:click="refreshData"
 class="p-1 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
 title="Atualizar dados">
 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
 stroke="currentColor" class="w-4 h-4 text-zinc-500 dark:text-zinc-400">
 <path stroke-linecap="round" stroke-linejoin="round"
 d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
 </svg>
 </button>
 </div>
 <p class="mt-3 grow text-sm text-zinc-500 dark:text-zinc-400">
 Análises de canais calculadas com base na sua atividade
 </p>
 <div class="mt-3 flex items-center space-x-2">
 <div class="avatar relative inline-flex shrink-0 h-7 w-7">
 <div
 class="flex h-full w-full items-center justify-center bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400">
 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
 stroke="currentColor" class="size-4">
 <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18">
 </path>
 </svg>
 </div>
 </div>
 <p class="text-base font-medium text-zinc-800 dark:text-zinc-100">{{ number_format($overallGrowth, 1) }}%
 </p>
 </div>
 </div>

 <div class="hide-scrollbar flex-1 mt-5 flex space-x-4 overflow-x-auto px-4 sm:px-5 lg:mt-0 lg:pl-0 pb-2">
 @foreach($stats as $stat)
 <div class="relative break-words flex w-36 shrink-0 flex-col items-center group">
 <div
 class="z-10 flex h-12 w-12 items-center justify-center shadow-sm ring-4 ring-white dark:ring-zinc-900 {{ $stat['color_bg'] }} {{ $stat['color_text'] }}">
 <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
 <path d="{{ $stat['path'] }}" />
 </svg>
 </div>
 <div
 class="relative w-full -mt-6 flex flex-col bg-white px-3 py-5 text-center shadow-sm dark:bg-zinc-700/50 pt-9 transition-transform hover:-translate-y-1">
 <p class="mt-1 text-base font-medium text-zinc-800 dark:text-zinc-100">{{ $stat['name'] }}</p>
 <a href="#"
 class="mt-1 text-xs font-medium text-zinc-400 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-blue-400 transition-colors">{{ $stat['handle'] }}</a>
 <div class="mt-4 flex justify-center items-baseline gap-0.5 text-zinc-800 dark:text-zinc-100">
 <p class="text-3xl font-semibold tracking-tight">+{{ $stat['growth'] }}</p>
 <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">%</p>
 </div>
 </div>
 </div>
 @endforeach
 </div>
</div>