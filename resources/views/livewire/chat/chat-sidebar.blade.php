<div x-show="$store.chatSidebar.isOpen" x-transition:enter="transform transition ease-in-out duration-300"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed right-0 top-0 h-screen w-80 bg-white dark:bg-zinc-900 shadow-2xl z-50 overflow-y-auto border-l border-zinc-200 dark:border-zinc-800"
    style="display: none;">

    <div
        class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center bg-white dark:bg-zinc-900 sticky top-0 z-10">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Mensagens</h2>
        <button @click="$store.chatSidebar.toggle()"
            class="p-2 text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="p-4">
        <h3 class="text-sm font-bold text-zinc-500 uppercase tracking-wider mb-4 px-2">Contatos</h3>
        <div class="space-y-1">
            @forelse($users as $user)
                <div wire:key="sidebar-user-{{ $user->id }}" wire:click="openChat({{ $user->id }})"
                    class="flex items-center gap-3 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer transition-colors group">
                    <div class="relative">
                        <img src="{{ $user->profile?->image ? Storage::url($user->profile->image) : $user->image_url }}"
                            alt="{{ $user->name }}"
                            class="w-10 h-10 rounded-full object-cover ring-2 ring-transparent group-hover:ring-brand-500 transition-all">

                        <!-- Status indicator (Logic can be improved with real presence system) -->
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-zinc-900 rounded-full"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 truncate">{{ $user->name }}
                            </h4>
                            @if($user->unread_count > 0)
                                <span
                                    class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white">
                                    {{ $user->unread_count }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-zinc-500 truncate">
                            {{ $user->last_message ? Str::limit($user->last_message->content ?: 'Enviou um anexo', 25) : 'Inicie uma conversa' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-zinc-500 text-sm">Nenhum contato encontrado.</div>
            @endforelse
        </div>

        <!-- Groups (Static for now as per previous design, or can be dynamic later) -->
        <h3 class="text-sm font-bold text-zinc-500 uppercase tracking-wider mt-6 mb-4 px-2">Grupos</h3>
        <div class="space-y-1">
            @foreach(['Time de Design', 'Desenvolvedores', 'Marketing'] as $group)
                <div
                    class="flex items-center gap-3 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer transition-colors">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-100 text-brand-600 font-bold text-xs">
                        {{ substr($group, 0, 2) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">{{ $group }}</h4>
                        <p class="text-xs text-zinc-500">2 novas mensagens</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>