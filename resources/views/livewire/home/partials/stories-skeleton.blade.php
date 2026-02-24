<div class="w-full mb-8">
    <div class="flex items-center space-x-6 overflow-x-hidden pb-6 px-2">
        @foreach(range(1, 10) as $i)
            <div class="flex flex-col items-center flex-shrink-0 animate-pulse">
                <div
                    class="w-[104px] h-[136px] rounded-xl relative bg-zinc-100 dark:bg-zinc-800 shadow-sm border border-zinc-200 dark:border-zinc-700">
                    <div
                        class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-lg border-2 border-white dark:border-zinc-900 bg-zinc-200 dark:bg-zinc-700">
                    </div>
                </div>
                <div class="mt-5 h-2 w-3/4 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
            </div>
        @endforeach
    </div>
</div>