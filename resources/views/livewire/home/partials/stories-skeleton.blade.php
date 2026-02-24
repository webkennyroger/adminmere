<div class="w-full">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4">
        @foreach(range(1, 7) as $i)
            <div
                class="aspect-3/4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-3 flex flex-col justify-between animate-pulse">
                <!-- Circle top left -->
                <div class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-800"></div>

                <!-- Lines at bottom -->
                <div class="space-y-2">
                    <div class="h-2 w-3/4 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                    <div class="h-2 w-1/2 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>