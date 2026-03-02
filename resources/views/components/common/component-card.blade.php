@props([
 'title',
 'desc' => '',
])

<div {{ $attributes->merge(['class' => ' border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]']) }}>
 <!-- Card Header -->
 <div class="px-6 py-5">
 <h3 class="text-base font-medium text-zinc-800 dark:text-white/90">
 {{ $title }}
 </h3>
 @if($desc)
 <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
 {{ $desc }}
 </p>
 @endif
 </div>

 <!-- Card Body -->
 <div class="p-4 border-t border-zinc-100 dark:border-zinc-800 sm:p-6">
 <div class="space-y-6">
 {{ $slot }}
 </div>
 </div>
</div>