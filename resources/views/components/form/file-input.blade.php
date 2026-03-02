@props(['label' => null, 'id' => null])

<div>
 @if($label)
 <label @if($id) for="{{ $id }}" @endif class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
 {{ $label }}
 </label>
 @endif
 <input type="file" @if($id) id="{{ $id }}" @endif
 {{ $attributes->merge(['class' => 'focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden border border-zinc-300 bg-transparent text-sm text-zinc-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file: file:border-0 file:border-r file:border-solid file:border-zinc-200 file:bg-zinc-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-zinc-700 placeholder:text-zinc-400 hover:file:bg-zinc-100 focus:outline-hidden dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400 dark:text-white/90 dark:file:border-zinc-800 dark:file:bg-white/[0.03] dark:file:text-zinc-400 dark:placeholder:text-zinc-400']) }} />
</div>
