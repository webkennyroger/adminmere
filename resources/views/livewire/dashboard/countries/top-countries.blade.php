<div
 class="relative break-words print:border card border border-gray-200 dark:border-dark-600 print:border-0 px-4 pb-5 sm:px-5">
 <div class="flex h-14 min-w-0 items-center justify-between py-3">
 <h2 class="truncate font-medium tracking-wide text-gray-800 dark:text-dark-100">
 Principais países
 </h2>
 <a href="##"
 class="border-b border-dotted border-current pb-0.5 text-xs-plus font-medium text-primary-600 outline-hidden transition-colors duration-300 hover:text-primary-600/70 focus:text-primary-600/70 dark:text-primary-400 dark:hover:text-primary-400/70 dark:focus:text-primary-400/70">Ver
 todos
 </a>
 </div>
 <div>
 <p><span class="text-2xl text-gray-800 dark:text-dark-100">{{ count($countries) }}</span></p>
 <p class="text-xs-plus">Países</p>
 </div>
 <div class="mt-5 max-h-[350px] overflow-y-auto custom-scrollbar pr-2">
 <div class="space-y-4">
 @foreach($countries as $country)
 <div class="flex items-center justify-between gap-2">
 <div class="flex min-w-0 items-center gap-2">
 <img class="size-6 object-cover" alt="{{ $country['name'] }}"
 src="/assets/images/countries/{{ $country['flag'] }}">
 <a href="##"
 class="truncate transition-opacity hover:opacity-80 text-sm font-medium text-gray-700 dark:text-gray-300">
 {{ $country['name'] }}
 </a>
 </div>
 <div class="flex items-center gap-2">
 <p class="text-sm-plus text-gray-800 dark:text-dark-100">
 {{ number_format($country['users'], 0, ',', '.') }}
 </p>

 @if($country['trend'] === 'up')
 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
 stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-4 text-green-500">
 <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18">
 </path>
 </svg>
 @else
 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
 stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-4 text-red-500">
 <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3">
 </path>
 </svg>
 @endif
 </div>
 </div>
 @endforeach
 </div>
 </div>
</div>