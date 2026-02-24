<div class="w-full mb-8">
    <div class="flex gap-4 overflow-x-hidden py-4 px-2">
        @foreach(range(1, 10) as $i)
            <div
                class="flex-none w-[128px] h-[180px] rounded-[14px] bg-zinc-100 dark:bg-zinc-800 relative animate-pulse overflow-hidden">
                <!-- Avatar Placeholder -->
                <div
                    class="absolute bottom-[36px] left-1/2 -translate-x-1/2 w-[36px] h-[36px] rounded-full bg-zinc-200 dark:bg-zinc-700 border-2 border-white dark:border-zinc-900">
                </div>

                <!-- Name Placeholder -->
                <div
                    class="absolute bottom-[12px] left-1/2 -translate-x-1/2 w-3/4 h-2 bg-zinc-200 dark:bg-zinc-700 rounded">
                </div>
            </div>
        @endforeach
    </div>
</div>