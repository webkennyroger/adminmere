<x-layouts.app >
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12">
                <livewire:dashboard.stats />       
            </div>
            {{-- Tabela de usuários --}}
            <div class="col-span-12 xl:col-span-8">
                <livewire:dashboard.user-growth-chart />
            </div>

            
   
    <div class="col-span-12 xl:col-span-4">
        <div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Meta mensal
                        </h3>
                        <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                            Meta que você definiu para cada mês
                        </p>
                    </div>
                    <!-- Dropdown Menu -->
                    <div x-data="{openDropDown: false}" class="relative h-fit">
                        <button @click="openDropDown = !openDropDown" :class="openDropDown ? 'text-gray-700 dark:text-white' : 'text-gray-400 hover:text-gray-700 dark:hover:text-white'" class="text-gray-400 hover:text-gray-700 dark:hover:text-white">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z" fill=""></path>
                            </svg>
                        </button>
    
    <div x-show="openDropDown" @click.outside="openDropDown = false" class="absolute right-0 z-40 w-40 p-2 space-y-1 bg-white border border-gray-200 shadow-theme-lg dark:bg-gray-dark top-full rounded-2xl dark:border-gray-800" style="display: none;">
                    <button class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                View More
            </button>
                    <button class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                Delete
            </button>
            </div>
</div>            <!-- End Dropdown Menu -->

        </div>
        <div class="relative max-h-[195px]">
            <div id="chartTwo" class="h-full" style="min-height: 229px;"></div>
            <span class="absolute left-1/2 top-[85%] -translate-x-1/2 -translate-y-[85%] rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">+10%</span>
        </div>
        <p class="mx-auto mt-1.5 w-full max-w-[380px] text-center text-sm text-gray-500 sm:text-base">
            You earn $3287 today, it's higher than last month. Keep up your good work!
        </p>
    </div>

    <div class="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Target
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                $20K
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.26816 13.6632C7.4056 13.8192 7.60686 13.9176 7.8311 13.9176C7.83148 13.9176 7.83187 13.9176 7.83226 13.9176C8.02445 13.9178 8.21671 13.8447 8.36339 13.6981L12.3635 9.70076C12.6565 9.40797 12.6567 8.9331 12.3639 8.6401C12.0711 8.34711 11.5962 8.34694 11.3032 8.63973L8.5811 11.36L8.5811 2.5C8.5811 2.08579 8.24531 1.75 7.8311 1.75C7.41688 1.75 7.0811 2.08579 7.0811 2.5L7.0811 11.3556L4.36354 8.63975C4.07055 8.34695 3.59568 8.3471 3.30288 8.64009C3.01008 8.93307 3.01023 9.40794 3.30321 9.70075L7.26816 13.6632Z" fill="#D92D20"></path>
                </svg>
            </p>
        </div>

        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Revenue
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                $20K
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.16475 2.08243 8.16516 2.08243 8.16556 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004L8.91435 13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5L7.41435 4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z" fill="#039855"></path>
                </svg>
            </p>
        </div>

        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Today
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                $20K
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.16475 2.08243 8.16516 2.08243 8.16556 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004L8.91435 13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5L7.41435 4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z" fill="#039855"></path>
                </svg>
            </p>
        </div>
    </div>
</div>

    </div>

        


                
      
            <!-- Tabela de Eventos -->
            <div class="col-span-12 sm:col-span-6 2xl:col-span-4">
                <x-common.component-card title="Desafios">
                    <div class="flex items-center gap-4 justify-between flex-wrap">
                        <div class="week-item text-center"><span class="text-sm text-zinc-400 font-medium">Fr</span>
                            <h6 class="text-base mb-0">21</h6>
                        </div>
                        <div class="week-item text-center"><span class="text-sm text-zinc-400 font-medium">Sa</span>
                            <h6 class="text-base mb-0">22</h6>
                        </div>
                        <div class="week-item text-center"><span class="text-sm text-zinc-400 font-medium">Su</span>
                            <h6 class="text-base mb-0">23</h6>
                        </div>
                        <div class="week-item text-center"><span class="text-sm text-zinc-400 font-medium">Mo</span>
                            <h6 class="text-base mb-0">24</h6>
                        </div>
                        <div class="week-item text-center bg-purple-500 rounded-[50rem] py-3 px-4"><span
                                class="text-sm text-white font-medium">Tu</span>
                            <h6 class="text-base mb-0 text-white">25</h6>
                        </div>
                        <div class="week-item text-center"><span class="text-sm text-zinc-400 font-medium">We</span>
                            <h6 class="text-base mb-0">26</h6>
                        </div>
                        <div class="week-item text-center"><span class="text-sm text-zinc-400 font-medium">Th</span>
                            <h6 class="text-base mb-0">27</h6>
                        </div>
                        <div class="text-center"><span class="text-sm text-zinc-400 font-medium">Fr</span>
                            <h6 class="text-base mb-0">28</h6>
                        </div>
                        <div class="text-center"><span class="text-sm text-zinc-400 font-medium">Sa</span>
                            <h6 class="text-base mb-0">29</h6>
                        </div>
                        <div class="text-center"><span class="text-sm text-zinc-400 font-medium">Su</span>
                            <h6 class="text-base mb-0">30</h6>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col gap-5">
                        <div
                            class="flex items-center justify-between gap-1 ps-2.5 border-inline-start border-start-width-[3px] border-purple">
                            <div class="">
                                <div class="flex items-center gap-1">
                                    <h6 class="text-lg mb-0">10:20 - 11:00</h6><span
                                        class="text-xs text-zinc-500 dark:text-zinc-300 font-medium">AM</span>
                                </div>
                                <p class="text-sm text-zinc-500 dark:text-zinc-300 font-medium mb-1">UI UX Dashboard Project Meeting</p>
                                <p class="text-xs text-zinc-400 font-medium mb-0">Lead by <span class="text-green-600">Jane
                                        Cooper</span> </p>
                            </div>
                            <div class=""><a
                                    href="#"
                                    class="bg-zinc-200 dark:bg-zinc-600 dark:hover:bg-zinc-500 hover:bg-zinc-600 hover:text-white text-sm text-[#0a0a0a] dark:text-white py-1.5 rounded px-6">View
                                </a></div>
                        </div>
                        <div
                            class="flex items-center justify-between gap-1 ps-2.5 border-inline-start border-start-width-[3px] border-yellow-600">
                            <div class="">
                                <div class="flex items-center gap-1">
                                    <h6 class="text-lg mb-0">10:20 - 11:00</h6><span
                                        class="text-xs text-zinc-500 dark:text-zinc-300 font-medium">AM</span>
                                </div>
                                <p class="text-sm text-zinc-500 dark:text-zinc-300 font-medium mb-1">UI UX Dashboard Project Meeting</p>
                                <p class="text-xs text-zinc-400 font-medium mb-0">Lead by <span class="text-green-600">Jane
                                        Cooper</span> </p>
                            </div>
                            <div class=""><a
                                    href="#"
                                    class="bg-zinc-200 dark:bg-zinc-600 dark:hover:bg-zinc-500 hover:bg-zinc-600 hover:text-white text-sm text-[#0a0a0a] dark:text-white py-1.5 rounded px-6">View
                                </a></div>
                        </div>
                        <div
                            class="flex items-center justify-between gap-1 ps-2.5 border-inline-start border-start-width-[3px] border-cyan-600">
                            <div class="">
                                <div class="flex items-center gap-1">
                                    <h6 class="text-lg mb-0">10:20 - 11:00</h6><span
                                        class="text-xs text-zinc-500 dark:text-zinc-300 font-medium">AM</span>
                                </div>
                                <p class="text-sm text-zinc-500 dark:text-zinc-300 font-medium mb-1">UI UX Dashboard Project Meeting</p>
                                <p class="text-xs text-zinc-400 font-medium mb-0">Lead by <span class="text-green-600">Jane
                                        Cooper</span> </p>
                            </div>
                            <div class=""><a
                                    href="#"
                                    class="bg-zinc-200 dark:bg-zinc-600 dark:hover:bg-zinc-500 hover:bg-zinc-600 hover:text-white text-sm text-[#0a0a0a] dark:text-white py-1.5 rounded px-6">View
                                </a></div>
                        </div>
                    </div>
                </x-common.component-card>
            </div>
            
        </div>
        <!-- Tabela de Desafios -->
        <div class="col-span-12 pt-5">
            <x-common.component-card title="Desafios">
                <livewire:challenges.challenge-index :perPage="5" :isEmbedded="true" />
            </x-common.component-card>
        </div>
     </div>
</x-layouts.app>
