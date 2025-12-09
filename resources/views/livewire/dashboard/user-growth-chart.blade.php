<div class="rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
    <div class="flex flex-col gap-5 mb-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Usuários
            </h3>
            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                Meta definida para crescimento de usuários
            </p>
        </div>

        <div x-data="{ selected: 'monthly' }" class="inline-flex items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900">
            <button @click="selected = 'monthly'" :class="selected === 'monthly' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'" class="px-3 py-2 font-medium rounded-md text-theme-sm hover:text-gray-900 hover:shadow-theme-xs dark:hover:bg-gray-800 dark:hover:text-white">
                Mensal
            </button>

            <button @click="selected = 'quarterly'" :class="selected === 'quarterly' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'" class="px-3 py-2 font-medium rounded-md text-theme-sm hover:text-gray-900 hover:shadow-theme-xs dark:hover:text-white">
                Trimestral
            </button>

            <button @click="selected = 'yearly'" :class="selected === 'yearly' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'" class="px-3 py-2 font-medium rounded-md text-theme-sm hover:text-gray-900 hover:shadow-theme-xs dark:hover:text-white">
                Anual
            </button>
        </div>
    </div>

    <!-- Stats Display based on selection (using Alpine for switching visibility for immediate feeling, though data is pre-loaded) -->
    <div x-data="{ currentTab: 'monthly' }" x-on:click.window="$data.currentTab = $event.target.innerText === 'Mensal' ? 'monthly' : ($event.target.innerText === 'Trimestral' ? 'quarterly' : 'yearly')">
       
        <!-- Monthly Stats -->
        <div class="flex gap-4 sm:gap-9">
            <div class="flex items-start gap-2">
                <div>
                    <h4 class="mb-0.5 text-base font-bold text-gray-800 dark:text-white/90 sm:text-theme-xl">
                        {{ number_format($usersThisMonth, 0, ',', '.') }}
                    </h4>
                    <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                        Total Usuários (Mês Atual)
                    </span>
                </div>
                <span class="mt-1.5 flex items-center gap-1 rounded-full {{ $monthlyGrowth >= 0 ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} px-2 py-0.5 text-theme-xs font-medium">
                    {{ $monthlyGrowth >= 0 ? '+' : '' }}{{ number_format($monthlyGrowth, 1) }}%
                </span>
            </div>
            
            <div class="flex items-start gap-2">
                <div>
                    <h4 class="mb-0.5 text-base font-bold text-gray-800 dark:text-white/90 sm:text-theme-xl">
                         {{ number_format($totalUsers, 0, ',', '.') }}
                    </h4>
                    <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                        Total Geral
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar mt-6">
        <div id="userGrowthChart" class="-ml-4 min-w-[650px] pl-2 xl:min-w-full" style="min-height: 265px;">
            <!-- Chart will be rendered here via JS -->
        </div>
    </div>
</div>
