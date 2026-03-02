@if ($paginator->hasPages())
 <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="w-full">
 
 <!-- Mobile View (Default Laravel Simple - Flex) -->
 <div class="flex justify-between flex-1 sm:hidden">
 @if ($paginator->onFirstPage())
 <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-400 opacity-50 cursor-not-allowed">
 Anterior
 </span>
 @else
 <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 dark:hover:text-white">
 Anterior
 </a>
 @endif

 @if ($paginator->hasMorePages())
 <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 dark:hover:text-white">
 Próxima
 </a>
 @else
 <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-400 opacity-50 cursor-not-allowed">
 Próxima
 </span>
 @endif
 </div>

 <!-- Desktop View (Flex for Left/Right Alignment) -->
 <div class="hidden sm:flex sm:items-center sm:justify-between sm:w-full">
 
 <!-- Left: Showing Entries Info -->
 <div class="text-sm text-zinc-500 dark:text-zinc-400">
 Exibindo de 
 <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $paginator->firstItem() ?? 0 }}</span>
 a 
 <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $paginator->lastItem() ?? 0 }}</span>
 de 
 <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $paginator->total() }}</span>
 entradas
 </div>

 <!-- Right: Pagination Controls -->
 <div class="flex items-center gap-2">
 <!-- Previous Button -->
 @if ($paginator->onFirstPage())
 <button disabled class="flex items-center gap-2 border border-zinc-300 bg-white px-3 py-3 text-theme-sm font-medium text-zinc-700 shadow-theme-xs dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 sm:px-3.5 opacity-50 cursor-not-allowed">
 <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M2.58301 9.99868C2.58272 10.1909 2.65588 10.3833 2.80249 10.53L7.79915 15.5301C8.09194 15.8231 8.56682 15.8233 8.85981 15.5305C9.15281 15.2377 9.15297 14.7629 8.86018 14.4699L5.14009 10.7472L16.6675 10.7472C17.0817 10.7472 17.4175 10.4114 17.4175 9.99715C17.4175 9.58294 17.0817 9.24715 16.6675 9.24715L5.14554 9.24715L8.86017 5.53016C9.15297 5.23717 9.15282 4.7623 8.85983 4.4695C8.56684 4.1767 8.09197 4.17685 7.79917 4.46984L2.84167 9.43049C2.68321 9.568 2.58301 9.77087 2.58301 9.99715C2.58301 9.99766 2.58301 9.99817 2.58301 9.99868Z" fill="currentColor"></path>
 </svg>
 <span class="hidden sm:inline">Anterior</span>
 </button>
 @else
 <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center gap-2 border border-zinc-300 bg-white px-3 py-3 text-theme-sm font-medium text-zinc-700 shadow-theme-xs hover:bg-zinc-50 hover:text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white/[0.03] dark:hover:text-zinc-200 sm:px-3.5">
 <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M2.58301 9.99868C2.58272 10.1909 2.65588 10.3833 2.80249 10.53L7.79915 15.5301C8.09194 15.8231 8.56682 15.8233 8.85981 15.5305C9.15281 15.2377 9.15297 14.7629 8.86018 14.4699L5.14009 10.7472L16.6675 10.7472C17.0817 10.7472 17.4175 10.4114 17.4175 9.99715C17.4175 9.58294 17.0817 9.24715 16.6675 9.24715L5.14554 9.24715L8.86017 5.53016C9.15297 5.23717 9.15282 4.7623 8.85983 4.4695C8.56684 4.1767 8.09197 4.17685 7.79917 4.46984L2.84167 9.43049C2.68321 9.568 2.58301 9.77087 2.58301 9.99715C2.58301 9.99766 2.58301 9.99817 2.58301 9.99868Z" fill="currentColor"></path>
 </svg>
 <span class="hidden sm:inline">Anterior</span>
 </a>
 @endif

 <!-- Page Numbers -->
 <ul class="flex items-center gap-0.5">
 {{-- Pagination Elements --}}
 @foreach ($elements as $element)
 {{-- "Three Dots" Separator --}}
 @if (is_string($element))
 <li>
 <span class="flex h-10 w-10 items-center justify-center text-zinc-500">{{ $element }}</span>
 </li>
 @endif

 {{-- Array Of Links --}}
 @if (is_array($element))
 @foreach ($element as $page => $url)
 <li>
 @if ($page == $paginator->currentPage())
 <span class="flex h-10 w-10 items-center justify-center text-theme-sm font-medium bg-blue-500 text-white">
 {{ $page }}
 </span>
 @else
 <a href="{{ $url }}" class="flex h-10 w-10 items-center justify-center text-theme-sm font-medium text-zinc-700 hover:bg-blue-500/[0.08] hover:text-blue-500 dark:text-zinc-400 dark:hover:text-blue-500">
 {{ $page }}
 </a>
 @endif
 </li>
 @endforeach
 @endif
 @endforeach
 </ul>

 <!-- Next Button -->
 @if ($paginator->hasMorePages())
 <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center gap-2 border border-zinc-300 bg-white px-3 py-3 text-theme-sm font-medium text-zinc-700 shadow-theme-xs hover:bg-zinc-50 hover:text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white/[0.03] dark:hover:text-zinc-200 sm:px-3.5">
 <span class="hidden sm:inline">Próxima</span>
 <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z" fill="currentColor"></path>
 </svg>
 </a>
 @else
 <button disabled class="flex items-center gap-2 border border-zinc-300 bg-white px-3 py-3 text-theme-sm font-medium text-zinc-700 shadow-theme-xs dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 sm:px-3.5 opacity-50 cursor-not-allowed">
 <span class="hidden sm:inline">Próxima</span>
 <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z" fill="currentColor"></path>
 </svg>
 </button>
 @endif
 </div>
 </div>
 </nav>
@endif
