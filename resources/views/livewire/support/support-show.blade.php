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
                                @if($support->status === 'open') bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500
                                @elseif($support->status === 'in_progress') bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500
                                @else bg-zinc-50 text-zinc-600 dark:bg-zinc-500/15 dark:text-zinc-400 @endif">
                                {{ ucfirst($support->status) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                                {{ $support->ticket_id }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $support->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('support.index') }}" wire:navigate class="flex items-center gap-2 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-white/[0.03]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar
                    </a>
                </div>

                <div class="prose prose-sm max-w-none text-zinc-600 dark:text-zinc-400">
                    <p class="whitespace-pre-wrap">{{ $support->message }}</p>
                </div>
            </div>

            <!-- Conversation History -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-zinc-800 dark:text-white/90">Histórico da Conversa</h3>
                
                @foreach($support->replies as $reply)
                    <div class="flex gap-4 {{ $reply->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                                {{ substr($reply->user->name, 0, 2) }}
                            </div>
                        </div>
                        <div class="flex max-w-[80%] flex-col {{ $reply->user_id === auth()->id() ? 'items-end' : 'items-start' }}">
                            <div class="rounded-2xl px-6 py-4 {{ $reply->user_id === auth()->id() ? 'bg-brand-500 text-white' : 'bg-white border border-zinc-200 dark:bg-white/[0.03] dark:border-zinc-800' }}">
                                <p class="whitespace-pre-wrap text-sm {{ $reply->user_id === auth()->id() ? 'text-white' : 'text-zinc-600 dark:text-zinc-300' }}">
                                    {{ $reply->message }}
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
                <form wire:submit="submitReply">
                    <div class="mb-4">
                        <textarea wire:model="replyMessage" rows="4" class="w-full rounded-lg border border-zinc-300 bg-transparent px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-400 focus:border-brand-500 focus:ring-0 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder-zinc-500 dark:focus:border-brand-500" placeholder="Digite sua resposta..."></textarea>
                        @error('replyMessage') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="flex items-center justify-center rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                            Enviar Resposta
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="xl:col-span-1">
            <div class="sticky top-6 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-lg font-medium text-zinc-800 dark:text-white/90">
                    Informações
                </h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</dt>
                        <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-white">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                @if($support->status === 'open') bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500
                                @elseif($support->status === 'in_progress') bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500
                                @else bg-zinc-50 text-zinc-600 dark:bg-zinc-500/15 dark:text-zinc-400 @endif">
                                {{ ucfirst($support->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Prioridade</dt>
                        <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-white">
                            {{ ucfirst($support->priority) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Última Atualização</dt>
                        <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-white">
                            {{ $support->updated_at->diffForHumans() }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
