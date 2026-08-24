<x-layouts.app>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4 p-6 bg-white rounded-2xl shadow dark:bg-zinc-800">
            <img src="{{ $user->image_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
            <div>
                <h1 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $user->name }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $user->email }}</p>
                <div class="flex gap-2 mt-2">
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-brand-100 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                        {{ ucfirst($user->profile?->role ?? 'user') }}
                    </span>
                    @if($user->profile?->plan)
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                            {{ ucfirst($user->profile->plan) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="p-6 bg-white rounded-2xl shadow dark:bg-zinc-800">
                <h2 class="mb-4 font-semibold text-zinc-900 dark:text-white">Dados do Perfil</h2>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">Apelido</dt>
                        <dd class="text-zinc-900 dark:text-zinc-100">{{ $user->profile?->nickname ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">Telefone</dt>
                        <dd class="text-zinc-900 dark:text-zinc-100">{{ $user->profile?->phone ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">Cidade/Estado</dt>
                        <dd class="text-zinc-900 dark:text-zinc-100">{{ $user->profile?->city ?? '—' }}{{ $user->profile?->state ? '/'.$user->profile->state : '' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">Membro desde</dt>
                        <dd class="text-zinc-900 dark:text-zinc-100">{{ $user->created_at->format('d/m/Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="p-6 bg-white rounded-2xl shadow dark:bg-zinc-800">
                <h2 class="mb-4 font-semibold text-zinc-900 dark:text-white">Atividades</h2>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $user->activities()->count() }}</p>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">atividades registradas</p>
                <a href="{{ route('activities.index') }}" class="inline-block mt-4 text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400">
                    Ver gestão de atividades &rarr;
                </a>
            </div>
        </div>

        <a href="{{ route('users.index') }}" class="inline-block text-sm font-medium text-zinc-500 hover:text-zinc-700 dark:text-zinc-400">
            &larr; Voltar para gestão de usuários
        </a>
    </div>
</x-layouts.app>
