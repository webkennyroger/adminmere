<div>
    <x-common.page-breadcrumb title="Assinaturas" />
    
    <div class="rounded-2xl border border-zinc-200 bg-white pt-4 dark:border-zinc-800 dark:bg-white/3">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="text-zinc-500 dark:text-zinc-400">Mostrar</span>
                <div class="relative z-20 bg-transparent">
                    <select wire:model.live="perPage" class="w-full py-2 pl-3 pr-8 text-sm text-zinc-800 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-zinc-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="-1">Todos</option>
                    </select>
                    <span class="absolute z-30 text-zinc-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-zinc-400">
                        <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <span class="text-zinc-500 dark:text-zinc-400">entradas</span>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form>
                    <div class="relative">
                        <span class="absolute -translate-y-1/2 pointer-events-none left-4 top-1/2">
                            <!-- Search Icon -->
                            <svg class="fill-zinc-500 dark:fill-zinc-400" width="20" height="20"
                                viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                                    fill="" />
                            </svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar..."
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-zinc-200 bg-transparent py-2.5 pl-12 pr-14 text-sm text-zinc-800 shadow-theme-xs placeholder:text-zinc-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-800 dark:bg-white/3 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[430px]" />
                        <button
                            class="absolute right-2.5 top-1/2 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-lg border border-zinc-200 bg-zinc-50 px-[7px] py-[4.5px] text-xs -tracking-[0.2px] text-zinc-500 dark:border-zinc-800 dark:bg-white/3 dark:text-zinc-400">
                            <span> ⌘ </span>
                            <span> K </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="max-w-full px-5 overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-zinc-200 border-y dark:border-zinc-700">
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                            Nome / Detalhes
                        </th>
                        <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-center text-theme-sm dark:text-zinc-400">
                            Plano
                        </th>
                         <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-end text-theme-sm dark:text-zinc-400">
                            Data de Cadastro
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($subscribers as $user)
                        <tr wire:key="{{ $user->id }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="shrink-0 h-10 w-10">
                                         <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->image ? Storage::url($user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $user->name }}" />
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $user->name }}
                                        </div>
                                         <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 capitalize">
                                    {{ $user->plan }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-end text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                Nenhum assinante encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="flex items-center flex-col sm:flex-row justify-between border-t border-zinc-200 px-5 py-4 dark:border-zinc-800">
             {{ $subscribers->links('components.pagination.custom') }}
        </div>
    </div>
</div>
