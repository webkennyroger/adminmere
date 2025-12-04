<div {{ $attributes->merge(['class' => "bg-white dark:bg-zinc-900 shadow-md rounded-lg overflow-hidden " . $widthClass . " " . $heightClass]) }}>
    
    @if ($title || $showTimeFilter)
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
            
            @if ($title)
                <h6 class="h6 text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ $title }}
                </h6>
            @endif

            @if ($showTimeFilter)
                <div class="ml-4">
                    <select class="block py-1.5 px-3 border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200 rounded-md shadow-sm text-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="today">Hoje</option>
                        <option value="weekly">Semanal</option>
                        <option value="monthly">Mensal</option>
                        <option value="yearly">Anual</option>
                    </select>
                </div>
            @endif

        </div>
    @endif

    <div class="p-6">
        {{ $slot }} 
    </div>

    @if (isset($footer) || isset($attributes->footer))
        <div class="px-6 py-3 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-500 dark:text-zinc-400">
            @if(isset($footer))
                {{ $footer }}
            @else
                {{ $attributes->footer }}
            @endif
        </div>
    @endif
</div>