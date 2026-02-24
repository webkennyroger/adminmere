<div class="w-full mb-8">
    <div class="flex gap-6 overflow-x-hidden py-4">
        @foreach(range(1, 10) as $i)
            <div
                class="flex-none w-[130px] h-[180px] rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 p-4 flex flex-col justify-between animate-pulse shadow-sm">
                <!-- Circle top left -->
                <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800"></div>

                <!-- Lines at bottom -->
                <div class="space-y-3">
                    <div class="h-2 w-3/4 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                    <div class="h-2 w-1/2 bg-zinc-100 dark:bg-zinc-800 rounded"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>