@props(['label' => null])

<label {{ $attributes->merge(['class' => 'flex cursor-pointer items-center text-sm font-medium text-zinc-700 select-none dark:text-zinc-400']) }}>
    <div class="relative">
        <input type="checkbox" {{ $attributes->except('class') }} class="peer sr-only" />

        <div class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px] 
            bg-transparent border-zinc-300 dark:border-zinc-700
            hover:border-brand-500 dark:hover:border-brand-500
            peer-checked:border-brand-500 peer-checked:bg-brand-500
            peer-disabled:opacity-50 peer-disabled:cursor-not-allowed
            text-transparent peer-checked:text-white transition-all duration-200">

            <span>
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>

        </div>
    </div>
    @if($label)
        {{ $label }}
    @endif
</label>