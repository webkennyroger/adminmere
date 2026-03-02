@props([
 'id',
 'name',
 'value',
 'checked' => false,
 'label',
 'disabled' => false,
])

<label for="{{ $id }}"
 @class([
 'relative flex cursor-pointer select-none items-center gap-3 text-sm font-medium',
 'text-zinc-300 dark:text-zinc-600 cursor-not-allowed' => $disabled,
 'text-zinc-700 dark:text-zinc-400' => !$disabled,
 $attributes->get('class'),
 ])>
 
 <input 
 id="{{ $id }}"
 name="{{ $name }}"
 type="radio"
 value="{{ $value }}"
 {{ $checked ? 'checked' : '' }}
 {{ $disabled ? 'disabled' : '' }}
 class="sr-only"
 {{ $attributes->except(['class', 'label']) }}
 />
 
 <span @class([
 'flex h-5 w-5 items-center justify-center border-[1.25px]',
 'border-brand-500 bg-brand-500' => $checked && !$disabled,
 'bg-transparent border-zinc-300 dark:border-zinc-700' => !$checked && !$disabled,
 'bg-zinc-100 dark:bg-zinc-700 border-zinc-200 dark:border-zinc-700' => $disabled,
 ])>
 <span @class([
 'h-2 w-2 bg-white',
 'block' => $checked,
 'hidden' => !$checked,
 ])></span>
 </span>
 
 {{ $label }}
</label>