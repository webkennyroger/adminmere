<div>
    <x-common.page-breadcrumb title="Tickets de Suporte" />

    <div class="rounded-2xl border border-zinc-200 bg-white pt-4 dark:border-zinc-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-4 px-4 py-4">
            <!-- First Row: Tabs -->
            <div class="flex items-center gap-2">
                <button wire:click="setFilter('all')" class="rounded-lg px-4 py-2 text-sm font-medium transition-colors {{ $status === 'all' ? 'bg-brand-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                    Todos
                </button>
                <button wire:click="setFilter('solved')" class="rounded-lg px-4 py-2 text-sm font-medium transition-colors {{ $status === 'solved' ? 'bg-brand-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                    Resolvidos
                </button>
                <button wire:click="setFilter('pending')" class="rounded-lg px-4 py-2 text-sm font-medium transition-colors {{ $status === 'pending' ? 'bg-brand-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                    Pendentes
                </button>
            </div>

            <!-- Second Row: Controls -->
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-zinc-500 dark:text-zinc-400">Mostrar</span>
                    <div class="relative z-20 bg-transparent">
                        <select wire:model.live="perPage" class="w-full py-2 pl-3 pr-8 text-sm text-zinc-800 bg-transparent border border-zinc-300 rounded-lg appearance-none h-9 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:focus:border-brand-800">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
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
                    <div class="relative">
                        <button class="absolute text-zinc-500 -translate-y-1/2 left-4 top-1/2 dark:text-zinc-400">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z" fill=""></path>
                            </svg>
                        </button>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar..." class="h-11 w-full rounded-lg border border-zinc-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-zinc-800 shadow-theme-xs placeholder:text-zinc-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                    </div>

                    @if (count($selected) > 0)
                    <button wire:click="deleteSelected" class="flex w-full items-center justify-center gap-2 rounded-lg border border-red-300 bg-red-200 px-4 py-[11px] text-sm font-medium text-red-700 shadow-theme-xs dark:border-red-700 dark:bg-red-800 dark:text-zinc-400 sm:w-auto">
                        Deletar Selecionados ({{ count($selected) }})
                    </button>
                    @endif

                    <a href="{{ route('support.index') }}" class="bg-green-600 hover:bg-green-500 text-white rounded-lg h-11 px-4 py-2.5 text-sm font-medium transition-colors flex items-center justify-center">
                        Novo Ticket
                    </a>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden">
            <div class="max-w-full px-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-zinc-200 border-y dark:border-zinc-700">
                            <th scope="col" class="px-4 py-3 w-12">
                                <div class="flex items-center justify-center">
                                    <input type="checkbox" wire:model.live="selectAll" class="h-4 w-4 rounded border-zinc-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 focus:ring-offset-0" />
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400 w-32">
                                Ticket ID
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400">
                                Assunto
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400 w-48">
                                Solicitado Por
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400 w-32">
                                Status
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400 w-32">
                                Prioridade
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-start text-theme-sm dark:text-zinc-400 w-40">
                                Criado em
                            </th>
                            <th scope="col" class="px-4 py-3 font-normal text-zinc-500 text-center text-theme-sm dark:text-zinc-400 w-24">
                                Ação
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse ($tickets as $ticket)
                            <tr wire:key="{{ $ticket->id }}">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <input type="checkbox" wire:model.live="selected" value="{{ $ticket->id }}" class="h-4 w-4 rounded border-zinc-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 focus:ring-offset-0" />
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <a href="{{ route('support.show', $ticket) }}" class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                                        {{ $ticket->ticket_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-4 ">
                                    <div class="text-sm text-zinc-900 dark:text-white">
                                        {{ Str::limit($ticket->subject, 40) }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="font-medium text-zinc-800 dark:text-white/90">{{ optional($ticket->user)->name ?? 'Desconhecido' }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ optional($ticket->user)->email ?? 'Sem Email' }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($ticket->status === 'solved' || $ticket->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-500/15 dark:text-green-500
                                        @elseif($ticket->status === 'closed') bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-500
                                        @elseif($ticket->status === 'pending') bg-orange-100 text-orange-800 dark:bg-orange-500/15 dark:text-orange-500
                                        @else bg-blue-100 text-blue-800 dark:bg-blue-500/15 dark:text-blue-500 @endif">
                                        {{ 
                                            match($ticket->status) {
                                                'open' => 'Aberto',
                                                'pending' => 'Pendente',
                                                'resolved', 'solved' => 'Resolvido',
                                                'closed' => 'Fechado',
                                                default => ucfirst($ticket->status)
                                            }
                                        }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($ticket->priority === 'high') bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-500
                                        @elseif($ticket->priority === 'medium') bg-orange-100 text-orange-800 dark:bg-orange-500/15 dark:text-orange-500
                                        @else bg-green-100 text-green-800 dark:bg-green-500/15 dark:text-green-500 @endif">
                                        {{ 
                                            match($ticket->priority) {
                                                'high' => 'Alta',
                                                'medium' => 'Média',
                                                'low' => 'Baixa',
                                                default => ucfirst($ticket->priority)
                                            }
                                        }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('support.show', $ticket) }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 shrink-0 outline-none focus-visible:ring-ring/50 focus-visible:ring-[3px] active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-blue-500 bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-5 h-5">
                                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                        <button wire:click="delete({{ $ticket->id }})" wire:confirm="Tem certeza que deseja deletar este ticket?" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 shrink-0 outline-none focus-visible:ring-ring/50 focus-visible:ring-[3px] active:scale-[.95] cursor-pointer hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-[50%] text-red-500 bg-red-500/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-5 h-5">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                                <line x1="14" x2="14" y1="11" y2="17"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    Nenhum ticket encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            {{ $tickets->links() }}
        </div>
    </div>
</div>