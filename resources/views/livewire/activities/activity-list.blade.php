<div class="p-6">
    <!-- Feedback Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Atividades & Posts</h2>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar posts..."
            class="px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>

    <div
        class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Usuário
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Postagem
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Local &
                        Feed</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Mídia
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Info</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Data</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($activities as $activity)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($activity->user->image_url)
                                        <img class="h-10 w-10 rounded-full object-cover border border-zinc-100 dark:border-zinc-700"
                                            src="{{ $activity->user->image_url }}" alt="">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 font-bold">
                                            {{ substr($activity->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ $activity->user->name }}</div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $activity->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-zinc-900 dark:text-zinc-100">
                                {{ $activity->title ?? 'Sem título' }}</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                                {{ Str::limit($activity->description, 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-zinc-900 dark:text-zinc-300 flex items-center gap-1">
                                <svg class="h-4 w-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $activity->location ?? $activity->user->profile->city ?? 'N/A' }}
                            </div>
                            <span
                                class="px-2 inline-flex text-[10px] leading-4 font-bold rounded-full uppercase {{ $activity->feed_type === 'community' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                {{ $activity->feed_type === 'community' ? 'Comunidade' : 'Geral' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($activity->media && count($activity->media) > 0)
                                <div class="flex -space-x-2 overflow-hidden">
                                    @foreach(array_slice($activity->media, 0, 3) as $media)
                                        <div class="w-8 h-8 rounded-lg border-2 border-white dark:border-zinc-900 bg-zinc-200 dark:bg-zinc-800 bg-cover bg-center shadow-sm"
                                            style="background-image: url('{{ $media }}')"></div>
                                    @endforeach
                                    @if(count($activity->media) > 3)
                                        <div
                                            class="w-8 h-8 rounded-lg border-2 border-white dark:border-zinc-900 bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-[10px] font-bold text-zinc-500 dark:text-zinc-400">
                                            +{{ count($activity->media) - 3 }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-zinc-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                            <div class="flex gap-3">
                                <span class="flex items-center gap-1"><svg class="h-4 w-4 text-red-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd" />
                                    </svg> {{ $activity->likes_count ?? $activity->likes->count() }}</span>
                                <span class="flex items-center gap-1"><svg class="h-4 w-4 text-blue-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                            clip-rule="evenodd" />
                                    </svg> {{ $activity->comments_count ?? $activity->comments->count() }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $activity->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400 py-12">
                            Nenhuma atividade encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="mt-4">
        {{ $activities->links() }}
    </div>
</div>