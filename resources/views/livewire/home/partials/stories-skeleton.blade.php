<div class="w-full mb-8">
    <div class="flex gap-4 overflow-x-hidden pb-6">
        @foreach(range(1, 10) as $i)
            <div
                class="flex-none w-[130px] sm:w-[155px] md:w-[175px] lg:w-[190px] aspect-[1/1.55] rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 flex flex-col justify-between animate-pulse">
                <!-- Circle top left -->
                <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800"></div>

                <!-- Lines at bottom -->
                <div class="space-y-3">
                    <div class="h-2.5 w-3/4 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                    <div class="h-2.5 w-1/2 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>