<x-layouts.app >
    <div class="min-h-screen rounded-2xl border border-zinc-200 bg-white px-5 py-7 dark:border-zinc-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5 gap-6">
            <div class="flex flex-col gap-6 bg-gradient-to-r from-cyan-600/10 to-white dark:to-zinc-700 p-0 border border-zinc-200 dark:border-zinc-700 rounded-md shadow-none">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                Total de usuários
                            </p>
                            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">
                                20.000
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-cyan-600 rounded-full flex items-center justify-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-users-round text-white">
                                <path d="M18 21a8 8 0 0 0-16 0"></path>
                                <circle cx="10" cy="8" r="5"></circle>
                                <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm mt-4">
                        <span class="flex items-center gap-1 text-green-600 dark:text-green-400">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="currentColor" stroke="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-up">
                                <path d="m5 12 7-7 7 7"></path>
                                <path d="M12 19V5"></path>
                            </svg>
                            +4000
                        </span>
                        <span class="text-zinc-500 dark:text-zinc-400 text-[13px]">
                            Usuários dos últimos 30 dias
                        </span>
                    </div>
                </div>
            </div>
            {{--  --}}
            <div class="flex flex-col gap-6 bg-gradient-to-r from-purple-600/10 to-white dark:to-zinc-700 p-0 border border-zinc-200 dark:border-zinc-700 rounded-md shadow-none">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                Assinatura total
                            </p>
                            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">
                                15.000
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-medal text-white">
                                <path
                                    d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15">
                                </path>
                                <path d="M11 12 5.12 2.2"></path>
                                <path d="m13 12 5.88-9.8"></path>
                                <path d="M8 7h8"></path>
                                <circle cx="12" cy="17" r="5"></circle>
                                <path d="M12 18v-2h-.5"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm mt-4">
                        <span class="flex items-center gap-1 text-red-600 dark:text-red-400">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="currentColor" stroke="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-down">
                                <path d="M12 5v14"></path>
                                <path d="m19 12-7 7-7-7"></path>
                            </svg>
                            -800
                        </span>
                        <span class="text-zinc-500 dark:text-zinc-400 text-[13px]">
                            Assinatura dos últimos 30 dias
                        </span>
                    </div>
                </div>
            </div>
            {{--  --}}
            <div class="flex flex-col gap-6 bg-gradient-to-r from-zinc-600/10 to-white dark:to-zinc-700 p-0 border border-zinc-200 dark:border-zinc-700 rounded-md shadow-none">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                Total de usuários gratuitos
                            </p>
                            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">
                                5.000
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-zinc-200 rounded-full flex items-center justify-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-users-round text-white">
                                <path d="M18 21a8 8 0 0 0-16 0"></path>
                                <circle cx="10" cy="8" r="5"></circle>
                                <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm mt-4">
                        <span
                            class="flex items-center gap-1 text-green-600 dark:text-green-400">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="currentColor" stroke="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-up">
                                <path d="m5 12 7-7 7 7"></path>
                                <path d="M12 19V5"></path>
                            </svg>
                            +200
                            
                        </span>
                        <span class="text-zinc-500 dark:text-zinc-400 text-[13px]">
                            Usuários dos últimos 30 dias
                        </span>
                    </div>
                </div>
            </div>
            {{--  --}}
            <div class="flex flex-col gap-6 bg-gradient-to-r from-green-600/10 to-white dark:to-zinc-700 p-0 border border-zinc-200 dark:border-zinc-700 rounded-md shadow-none">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                Renda total
                            </p>
                            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">
                                R$ 42.000
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-wallet text-white">
                                <path
                                    d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1">
                                </path>
                                <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm mt-4">
                        <span class="flex items-center gap-1 text-green-600 dark:text-green-400">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="currentColor" stroke="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-up">
                                <path d="m5 12 7-7 7 7"></path>
                                <path d="M12 19V5"></path>
                            </svg>
                            +US$ 20.000
                        </span>
                        <span class="text-zinc-500 dark:text-zinc-400 text-[13px]">
                            Renda dos últimos 30 dias
                        </span>
                    </div>
                </div>
            </div>
                {{--  --}}
            <div class="flex flex-col gap-6 bg-gradient-to-r from-red-600/10 to-white dark:to-zinc-700 p-0 border border-zinc-200 dark:border-zinc-700 rounded-md shadow-none">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                Despesa total
                            </p>
                            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">
                                $ 30.000
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-file-text text-white">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                <path d="M10 9H8"></path>
                                <path d="M16 13H8"></path>
                                <path d="M16 17H8"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm mt-4">
                        <span
                            class="flex items-center gap-1 text-green-600 dark:text-green-400">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="currentColor" stroke="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-up">
                                <path d="m5 12 7-7 7 7"></path>
                                <path d="M12 19V5"></path>
                            </svg>
                            +$5.000
                        </span>
                        <span class="text-zinc-500 dark:text-zinc-400 text-[13px]">
                            Despesas dos últimos 30 dias
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards de estatísticas -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 mt-6">
            <!-- Cards apexchar venda -->
            <div class="col-span-12 sm:col-span-6 2xl:col-span-4">
         
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <h6 class="mb-0">R$ 27.200</h6>
                        <span class="text-sm font-semibold rounded-full bg-green-100 dark:bg-green-600/25 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-600/50 px-2 py-1.5 flex items-center gap-1">
                            100%
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-up">
                                <path d="m5 12 7-7 7 7"></path>
                                <path d="M12 19V5"></path>
                            </svg>
                        </span>
                        <span class="text-xs font-medium">+ R$ 1400 por dia</span>
                    </div>
               
            </div>
            <!-- Cards apexchar assinatura-->
            <div class="col-span-12 sm:col-span-6 2xl:col-span-4">
          
                    <div class="flex items-center gap-2 mb-5">
                        <h6 class="font-semibold mb-0">5.000</h6>
                        <span class="text-sm font-semibold rounded-full bg-red-100 dark:bg-red-600/25 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-600/50 px-2 py-1.5 line-height-1 flex items-center gap-1">
                            100%
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-down">
                                <path d="M12 5v14"></path>
                                <path d="m19 12-7 7-7-7"></path>
                            </svg>
                        </span>
                        <span class="text-xs font-medium">- 20 por dia</span>
                    </div>
                

            </div>
            <!-- Cards apexchar usuarios-->
            <div class="col-span-12 sm:col-span-6 2xl:col-span-4">

             

                    
                
            </div>
            <!-- Tabela de usuários recentes -->
            <div class="col-span-12 2xl:col-span-8">
      

                
            </div>
            <!-- Tabela de Desafios -->
            <div class="col-span-12 sm:col-span-6 2xl:col-span-4">
   
                    
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
                    
               
            </div>
            
        </div>
        <x-common.component-card title="">
            <x-tables.basic-tables.basic-tables-three />
        </x-common.component-card>
       
       
 
     </div>
</x-layouts.app>
