<div>
    <x-common.page-breadcrumb pageTitle="Suporte e Ajuda" />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <!-- Create Ticket Form -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-white/[0.03]">
            <h3 class="mb-6 text-lg font-medium text-zinc-800 dark:text-white/90">
                Abrir Novo Ticket
            </h3>

            <form action="{{ route('support.store') }}" method="POST" class="space-y-6">
                @csrf

                @if(session('status'))
                    <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-500/10 dark:text-green-500">
                        {{ session('status') }}
                    </div>
                @endif

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
                        Assunto
                    </label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                        class="h-11 w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-400 focus:border-brand-500 focus:ring-0 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder-zinc-500 dark:focus:border-brand-500"
                        placeholder="Ex: Problema com acesso ao sistema" required>
                    @error('subject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
                        Prioridade
                    </label>
                    <div class="relative">
                        <x-form.multiple-select name="priority" :multiple="false" :value="old('priority', 'low')"
                            :options="[
        ['value' => 'low', 'label' => 'Baixa'],
        ['value' => 'medium', 'label' => 'Média'],
        ['value' => 'high', 'label' => 'Alta']
    ]" />
                    </div>
                    @error('priority') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
                        Mensagem
                    </label>
                    <x-form.text-area name="message" :value="old('message')" height="h-32"
                        placeholder="Descreva seu problema detalhadamente..." />
                    @error('message') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                        Enviar Solicitação
                    </button>
                </div>
            </form>
        </div>

        <!-- My Tickets List -->
        <div class="rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-white/[0.03]">
            <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                <h3 class="text-lg font-medium text-zinc-800 dark:text-white/90">
                    Meus Tickets
                </h3>
            </div>

            <div class="p-6">
                @if($tickets->isEmpty())
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <div
                            class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-zinc-50 dark:bg-zinc-800">
                            <svg class="text-zinc-400 dark:text-zinc-500" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-base font-medium text-zinc-800 dark:text-white">Nenhum ticket encontrado</h4>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Você ainda não criou nenhuma solicitação de
                            suporte.</p>
                    </div>
                @else
                    <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($tickets as $ticket)
                                    <a href="{{ route('support.show', $ticket) }}" wire:navigate
                                        class="group block rounded-xl border border-zinc-200 p-4 transition-colors hover:border-brand-500 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:border-brand-500 dark:hover:bg-white/[0.03]">
                                        <div class="mb-2 flex items-center justify-between">
                                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                                {{ $ticket->ticket_id }}
                                            </span>
                                            <span
                                                class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                                                                                            @if($ticket->status === 'solved' || $ticket->status === 'resolved') bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500
                                                                                                            @elseif($ticket->status === 'closed') bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500
                                                                                                            @elseif($ticket->status === 'pending') bg-orange-50 text-orange-700 dark:bg-orange-500/15 dark:text-orange-500
                                                                                                            @else bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-500 @endif">
                                                {{ 
                                                                                                                match ($ticket->status) {
                                'open' => 'Aberto',
                                'pending' => 'Pendente',
                                'resolved', 'solved' => 'Resolvido',
                                'closed' => 'Fechado',
                                default => ucfirst($ticket->status)
                            }
                                                                                                            }}
                                            </span>
                                        </div>
                                        <h4
                                            class="mb-1 text-sm font-medium text-zinc-800 group-hover:text-brand-500 dark:text-white/90 dark:group-hover:text-brand-500">
                                            {{ $ticket->subject }}
                                        </h4>
                                        <div class="flex items-center justify-between">
                                            <p class="line-clamp-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ Str::limit(strip_tags($ticket->message), 60) }}
                                            </p>
                                            <span class="text-xs text-zinc-400">
                                                {{ $ticket->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>