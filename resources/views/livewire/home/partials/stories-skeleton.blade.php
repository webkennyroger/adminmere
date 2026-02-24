<div class="w-full mb-8">
    <div class="flex gap-8 overflow-x-hidden py-8 px-2">
        @foreach(range(1, 10) as $i)
            <div class="flex-none w-[120px] sm:w-[140px] flex flex-col items-center relative animate-pulse">
                <!-- Square Main Box -->
                <div
                    class="w-full aspect-square rounded-2xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                </div>

                <!-- Avatar Overlay Box -->
                <div class="absolute bottom-[-18px] left-1/2 -translate-x-1/2 z-20">
                    <div
                        class="w-12 h-12 bg-zinc-200 dark:bg-zinc-700 rounded-xl border-4 border-white dark:border-zinc-900 shadow-sm">
                    </div>
                </div>

                <!-- Label Line -->
                <div class="h-2.5 w-3/4 bg-zinc-100 dark:bg-zinc-800 rounded mt-7"></div>
            </div>
        @endforeach
    </div>
</div>