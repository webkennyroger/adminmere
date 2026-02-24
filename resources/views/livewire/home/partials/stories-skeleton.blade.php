<div class="w-full mb-8">
    <div class="flex gap-4 overflow-x-hidden pb-4">
        @foreach(range(1, 10) as $i)
            <div
                class="flex-none w-[110px] sm:w-[130px] md:w-[145px] lg:w-[155px] aspect-3/4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-3 flex flex-col justify-between animate-pulse">
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