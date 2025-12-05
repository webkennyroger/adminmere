<div>
    <x-common.page-breadcrumb pageTitle="Lista de Tickets" />

    <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
        <article class="flex gap-5 rounded-xl border border-zinc-200 bg-white p-4 shadow-xs dark:border-zinc-800 dark:bg-white/[0.03]">
            <div class="bg-brand-500/10 text-brand-500 inline-flex h-14 w-14 items-center justify-center rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <path d="M4.95833 6.125C3.99183 6.125 3.20833 6.9085 3.20833 7.875V11.2998C4.69996 11.2998 5.9098 12.509 5.9098 14.0006C5.9098 15.4923 4.7006 16.7015 3.20897 16.7015L3.20833 20.125C3.20833 21.0915 3.99183 21.875 4.95833 21.875H23.0417C24.0082 21.875 24.7917 21.0915 24.7917 20.125V16.7015C23.3003 16.7011 22.0915 15.4921 22.0915 14.0006C22.0915 12.5092 23.3003 11.3001 24.7917 11.2998V7.875C24.7917 6.9085 24.0082 6.125 23.0417 6.125H4.95833Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-title-xs mb-1 font-semibold text-zinc-800 dark:text-white/90">{{ $totalTickets }}</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total de tickets</p>
            </div>
        </article>
        <article class="flex gap-5 rounded-xl border border-zinc-200 bg-white p-4 shadow-xs dark:border-zinc-800 dark:bg-white/[0.03]">
            <div class="bg-warning-500/10 text-warning-500 inline-flex h-14 w-14 items-center justify-center rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                    <path d="M5.33333 4.66675H24M5.33333 23.3334L24 23.3334M21.6667 4.66675V7.0001C21.6667 10.8661 18.5327 14.0001 14.6667 14.0001M7.66666 4.66675V7.0001C7.66666 10.8661 10.8007 14.0001 14.6667 14.0001M14.6667 14.0001C18.5327 14.0001 21.6667 17.1341 21.6667 21.0001V23.3334M14.6667 14.0001C10.8007 14.0001 7.66666 17.1341 7.66666 21.0001L7.66666 23.3334" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-title-xs mb-1 font-semibold text-zinc-800 dark:text-white/90">{{ $pendingTickets }}</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Tickets Pendentes
                </p>
            </div>
        </article>
        <article class="flex gap-5 rounded-xl border border-zinc-200 bg-white p-4 shadow-xs dark:border-zinc-800 dark:bg-white/[0.03]">
            <div class="bg-success-500/10 text-success-500 inline-flex h-14 w-14 items-center justify-center rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                    <path d="M17.8062 11.6598L13.1257 16.3403L10.8605 14.0751M25.125 13.9999C25.125 19.96 20.2934 24.7916 14.3334 24.7916C8.37328 24.7916 3.54169 19.96 3.54169 13.9999C3.54169 8.03985 8.37328 3.20825 14.3334 3.20825C20.2934 3.20825 25.125 8.03985 25.125 13.9999Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-title-xs mb-1 font-semibold text-zinc-800 dark:text-white/90">{{ $solvedTickets }}</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Tickets Resolvidos
                </p>
            </div>
        </article>
    </div>
    
    <!-- Table -->
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]">
        <div class="flex flex-col gap-4 border-b border-zinc-200 px-5 py-4 lg:flex-row lg:items-center lg:justify-between dark:border-zinc-800">
            <div>
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white/90">
                    Tickets de Suporte
                </h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Lista de tickets mais recentes
                </p>
            </div>
            <div class="flex flex-col gap-3.5 lg:flex-row lg:items-center">

                <div class="hidden h-11 items-center gap-0.5 rounded-lg bg-zinc-100 p-0.5 lg:inline-flex dark:bg-zinc-900">
                    <button wire:click="setFilter('all')" class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors {{ $status === 'all' ? 'shadow-theme-xs text-zinc-900 dark:text-white bg-white dark:bg-zinc-800' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white' }}">
                        Todos
                    </button>
                    <button wire:click="setFilter('solved')" class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors {{ $status === 'solved' ? 'shadow-theme-xs text-zinc-900 dark:text-white bg-white dark:bg-zinc-800' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white' }}">
                        Resolvidos
                    </button>
                    <button wire:click="setFilter('pending')" class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors {{ $status === 'pending' ? 'shadow-theme-xs text-zinc-900 dark:text-white bg-white dark:bg-zinc-800' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white' }}">
                        Pendentes
                    </button>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative">
                        <span class="absolute top-1/2 left-4 -translate-y-1/2 text-zinc-500 dark:text-zinc-400">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z" fill=""></path>
                            </svg>
                        </span>

                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar..." class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-zinc-300 bg-transparent py-2.5 pr-4 pl-11 text-sm text-zinc-800 placeholder:text-zinc-400 focus:ring-3 focus:outline-hidden xl:w-[300px] dark:border-zinc-700 dark:bg-zinc-900 dark:text-white/90 dark:placeholder:text-white/30">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800">
                        <th class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                            Ticket ID
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                             <div class="flex cursor-pointer items-center justify-between gap-3" wire:click="setSort('subject')">
                                <p class="text-theme-xs font-medium text-zinc-700 dark:text-zinc-400">
                                    Assunto
                                </p>
                                <span class="flex flex-col gap-0.5">
                                    <svg class="{{ $sortBy === 'subject' && $sortAsc ? 'text-zinc-500 dark:text-zinc-300' : 'text-zinc-300 dark:text-zinc-400' }}" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z" fill="currentColor"></path>
                                    </svg>
                                    <svg class="{{ $sortBy === 'subject' && !$sortAsc ? 'text-zinc-500 dark:text-zinc-300' : 'text-zinc-300 dark:text-zinc-400' }}" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                            Solicitado Por
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                            <div class="flex cursor-pointer items-center justify-between gap-3" wire:click="setSort('created_at')">
                                <p class="text-theme-xs font-medium text-zinc-700 dark:text-zinc-400">
                                    Data de Criação
                                </p>
                                <span class="flex flex-col gap-0.5">
                                    <svg class="{{ $sortBy === 'created_at' && $sortAsc ? 'text-zinc-500 dark:text-zinc-300' : 'text-zinc-300 dark:text-zinc-400' }}" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z" fill="currentColor"></path>
                                    </svg>
                                    <svg class="{{ $sortBy === 'created_at' && !$sortAsc ? 'text-zinc-500 dark:text-zinc-300' : 'text-zinc-300 dark:text-zinc-400' }}" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                            Prioridade
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                            Ação
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($tickets as $ticket)
                        <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="{{ route('support.show', $ticket) }}" class="text-brand-500 hover:underline" wire:navigate>
                                    {{ $ticket->ticket_id }}
                                </a>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-zinc-700 dark:text-zinc-400">
                                    {{ \Illuminate\Support\Str::limit($ticket->subject, 30) }}
                                </p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white/90">{{ optional($ticket->user)->name ?? 'Desconhecido' }}</span>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ optional($ticket->user)->email ?? 'Sem Email' }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-sm text-zinc-700 dark:text-zinc-400">
                                    {{ $ticket->created_at->format('d M, Y') }}
                                </p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-theme-xs rounded-full px-2 py-0.5 font-medium
                                    @if($ticket->status === 'solved') bg-success-50 dark:bg-success-500/15 text-success-700 dark:text-success-500
                                    @elseif($ticket->status === 'pending') bg-warning-50 dark:bg-warning-500/15 text-warning-600 dark:text-warning-500
                                    @elseif($ticket->status === 'open') bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-500
                                    @else bg-zinc-50 dark:bg-zinc-500/15 text-zinc-600 dark:text-zinc-400 @endif">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                             <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-theme-xs rounded-full px-2 py-0.5 font-medium
                                    @if($ticket->priority === 'high') bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-500
                                    @elseif($ticket->priority === 'medium') bg-orange-50 dark:bg-orange-500/15 text-orange-600 dark:text-orange-500
                                    @else bg-green-50 dark:bg-green-500/15 text-green-600 dark:text-green-500 @endif">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                     <a href="{{ route('support.show', $ticket) }}" wire:navigate class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                     </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                Nenhum ticket encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-zinc-200 dark:border-zinc-800">
             {{ $tickets->links() }}
        </div>
    </div>
</div>