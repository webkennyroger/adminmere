<div>
    <x-common.page-breadcrumb pageTitle="Detalhes do Ticket" />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <!-- Ticket Details & Conversation -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Ticket Header -->
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-white/[0.03]">
                <div class="mb-6 flex items-start justify-between">
                    <div>
                        <div class="mb-2 flex items-center gap-3">
                            <h2 class="text-xl font-semibold text-zinc-800 dark:text-white/90">
                                {{ $support->subject }}
                            </h2>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                @if($status === 'solved' || $status === 'resolved') bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500
                                @elseif($status === 'closed') bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500
                                @elseif($status === 'pending') bg-orange-50 text-orange-700 dark:bg-orange-500/15 dark:text-orange-500
                                @else bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-500 @endif">
                                {{ 
                                    match ($status) {
        'open' => 'Aberto',
        'pending' => 'Pendente',
        'resolved', 'solved' => 'Resolvido',
        'closed' => 'Fechado',
        default => ucfirst($status)
    }
                                }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-blue-700 dark:bg-blue-500/15" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                                {{ $support->ticket_id }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-blue-700 dark:bg-blue-500/15" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $support->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('support.index') }}" wire:navigate
                        class="flex items-center gap-2 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-white/[0.03]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar
                    </a>
                </div>

                <div class="prose prose-sm max-w-none text-zinc-600 dark:text-zinc-400">
                    <p class="whitespace-pre-wrap">{!! $support->message !!}</p>
                </div>
            </div>

            <!-- Conversation History -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-zinc-800 dark:text-white/90">Histórico da Conversa</h3>

                @foreach($support->replies as $reply)
                    <div class="flex gap-4 {{ $reply->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                        <div class="flex-shrink-0">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                                {{ substr($reply->user->name, 0, 2) }}
                            </div>
                        </div>
                        <div
                            class="flex max-w-[80%] flex-col {{ $reply->user_id === auth()->id() ? 'items-end' : 'items-start' }}">
                            <div
                                class="rounded-2xl px-6 py-4 {{ $reply->user_id === auth()->id() ? 'bg-brand-500 text-white' : 'bg-white border border-zinc-200 dark:bg-white/[0.03] dark:border-zinc-800' }}">
                                <p
                                    class="whitespace-pre-wrap text-sm {{ $reply->user_id === auth()->id() ? 'text-white' : 'text-zinc-600 dark:text-zinc-300' }}">
                                    {!! $reply->message !!}
                                </p>
                            </div>
                            <span class="mt-1.5 text-xs text-zinc-400">
                                {{ $reply->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Reply Form -->
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-lg font-medium text-zinc-800 dark:text-white/90">
                    Responder
                </h3>
                <form action="{{ route('support.reply', $support->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-form.text-area name="message" :value="old('message')" height="h-32"
                            placeholder="Digite sua resposta..." />
                        @error('message') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="flex items-center justify-center rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                            Enviar Resposta
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="xl:col-span-1">
            <div
                class="sticky top-6 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-lg font-medium text-zinc-800 dark:text-white/90">
                    Informações
                </h3>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
                        Status
                    </label>
                    @if(auth()->user()->is_admin)
                        <form action="{{ route('support.update-status', $support->id) }}" method="POST" class="space-y-2">
                            @csrf
                            @method('PATCH')
                            <div class="relative">
                                <select name="status"
                                    class="h-11 w-full appearance-none rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 text-sm text-zinc-800 focus:border-brand-500 focus:ring-0 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:focus:border-brand-500">
                                    <option value="open" @selected($support->status === 'open')>Aberto</option>
                                    <option value="pending" @selected($support->status === 'pending')>Pendente</option>
                                    <option value="resolved" @selected($support->status === 'resolved')>Resolvido</option>
                                    <option value="closed" @selected($support->status === 'closed')>Fechado</option>
                                </select>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-500 dark:text-zinc-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79199 7.396L10.0003 12.6043L15.2087 7.396" stroke="" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <button type="submit"
                                class="w-full rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                                Salvar Status
                            </button>
                        </form>
                    @else
                                    <span
                                        class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                                                                                @if($status === 'solved' || $status === 'resolved') bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500
                                                                                                @elseif($status === 'closed') bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500
                                                                                                @elseif($status === 'pending') bg-orange-50 text-orange-700 dark:bg-orange-500/15 dark:text-orange-500
                                                                                                @else bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-500 @endif">
                                        {{ 
                                                                                                    match ($status) {
                            'open' => 'Aberto',
                            'pending' => 'Pendente',
                            'resolved', 'solved' => 'Resolvido',
                            'closed' => 'Fechado',
                            default => ucfirst($status)
                        }
                                                                                                }}
                                    </span>
                    @endif
                </div>
                <div>
                    <p class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
                        Prioridade
                    </p>
                    <span class="text-theme-xs rounded-full px-2 py-0.5 font-medium
                            @if($support->priority === 'high') bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-500
                            @elseif($support->priority === 'medium') bg-orange-50 dark:bg-orange-500/15 text-orange-600 dark:text-orange-500
                            @else bg-green-50 dark:bg-green-500/15 text-green-600 dark:text-green-500 @endif">
                        {{ 
                                match ($support->priority) {
        'high' => 'Alta',
        'medium' => 'Média',
        'low' => 'Baixa',
        default => ucfirst($support->priority)
    }
                            }}
                    </span>
                </div>
                <div>
                    <p class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
                        Última Atualização
                    </p>
                    <span class="mt-1 text-sm font-medium text-zinc-800 dark:text-white">
                        {{ $support->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>