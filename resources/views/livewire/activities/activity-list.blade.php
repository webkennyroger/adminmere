<div class="p-6">
    <!-- Feedback Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Create Post Section (App Style) -->
    <div class="bg-zinc-900 rounded-xl shadow-lg border border-zinc-800 p-5 mb-8">
        <div class="flex gap-4">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                @if(auth()->user()->image_url)
                    <img class="h-12 w-12 rounded-full object-cover border-2 border-zinc-700"
                        src="{{ auth()->user()->image_url }}" alt="">
                @else
                    <div
                        class="h-12 w-12 rounded-full bg-zinc-700 flex items-center justify-center text-white font-bold border-2 border-zinc-600">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
            </div>

            <!-- Form Area -->
            <div class="flex-grow">
                <form wire:submit.prevent="savePost">

                    <!-- Campo Título (Barra Verde) -->
                    <div class="relative mb-3 group">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500 rounded-l"></div>
                        <input type="text" wire:model="title"
                            class="w-full bg-zinc-800 border-none rounded-r text-lg font-bold text-white placeholder-zinc-500 focus:ring-0 px-4 py-2"
                            placeholder="Título da publicação...">
                    </div>

                    <!-- Campo Descrição (Barra Amarela) -->
                    <div class="relative mb-3 group">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-500 rounded-l"></div>
                        <textarea wire:model="content"
                            class="w-full bg-zinc-800 border-none rounded-r text-base text-zinc-300 placeholder-zinc-500 focus:ring-0 px-4 py-3 min-h-[100px] resize-y"
                            placeholder="O que está em sua mente?"></textarea>
                    </div>

                    <!-- Toolbar de Ações -->
                    <div class="flex flex-wrap items-center gap-3 mt-4 border-t border-zinc-700 pt-4">

                        <!-- Botão Foto/Vídeo -->
                        <label
                            class="cursor-pointer flex items-center gap-2 bg-zinc-800 hover:bg-zinc-700 px-3 py-1.5 rounded-full transition-colors border border-zinc-700 select-none">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-xs font-semibold text-zinc-300">Foto/Vídeo</span>
                            <input type="file" wire:model="photo" class="hidden">
                        </label>

                        <!-- Botão Sentimento (Visual) -->
                        <button type="button"
                            class="flex items-center gap-2 bg-zinc-800 hover:bg-zinc-700 px-3 py-1.5 rounded-full transition-colors border border-zinc-700 select-none opacity-60 cursor-not-allowed">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <span class="text-xs font-semibold text-zinc-300">Sentimento</span>
                        </button>

                        <!-- Botão Enquete (Visual) -->
                        <button type="button"
                            class="flex items-center gap-2 bg-zinc-800 hover:bg-zinc-700 px-3 py-1.5 rounded-full transition-colors border border-zinc-700 select-none opacity-60 cursor-not-allowed">
                            <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="text-xs font-semibold text-zinc-300">Enquete</span>
                        </button>

                        <div class="flex-grow"></div>

                        <!-- Seleção de Destino (Comunidade vs Feed) -->
                        <div class="relative">
                            <select wire:model="feedType"
                                class="bg-zinc-800 text-zinc-300 text-xs font-semibold border border-zinc-600 rounded-lg pl-3 pr-8 py-1.5 focus:ring-1 focus:ring-green-500 focus:border-green-500 cursor-pointer appearance-none">
                                <option value="personal">🌎 Feed Geral</option>
                                <option value="community">👥 Comunidade</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Botão Publicar -->
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg text-sm transition-all shadow-lg hover:shadow-green-500/30 active:scale-95 flex items-center gap-2">
                            <span>PUBLICAR</span>
                            <svg wire:loading wire:target="savePost" class="animate-spin h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    @if ($photo)
                        <div
                            class="mt-3 bg-zinc-800 p-2 rounded-lg inline-flex items-center gap-2 border border-zinc-700 animate-fadeIn">
                            <span class="text-xs text-green-400 font-bold">✓ Imagem carregada:</span>
                            <span
                                class="text-xs text-zinc-300 truncate max-w-xs">{{ $photo->getClientOriginalName() }}</span>
                            <button type="button" wire:click="$set('photo', null)"
                                class="text-zinc-500 hover:text-red-400 ml-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="mt-2 p-2 bg-red-500/20 border border-red-500/50 rounded text-red-200 text-xs">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Atividades & Posts</h2>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar posts..."
            class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Postagem
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Local &
                        Feed</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mídia
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($activities as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($activity->user->image_url)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $activity->user->image_url }}"
                                            alt="">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">
                                            {{ substr($activity->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $activity->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $activity->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $activity->title ?? 'Sem título' }}</div>
                            <div class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($activity->description, 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 flex items-center gap-1">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $activity->location ?? $activity->user->profile->city ?? 'N/A' }}
                            </div>
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity->feed_type === 'community' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $activity->feed_type === 'community' ? 'Comunidade' : 'Geral' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($activity->media && count($activity->media) > 0)
                                <div class="flex -space-x-2 overflow-hidden">
                                    @foreach(array_slice($activity->media, 0, 3) as $media)
                                        <div class="w-8 h-8 rounded-lg border-2 border-white bg-gray-200 bg-cover bg-center"
                                            style="background-image: url('{{ $media }}')"></div>
                                    @endforeach
                                    @if(count($activity->media) > 3)
                                        <div
                                            class="w-8 h-8 rounded-lg border-2 border-white bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                            +{{ count($activity->media) - 3 }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex gap-3">
                                <span class="flex items-center gap-1"><svg class="h-4 w-4 text-red-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd" />
                                    </svg> {{ $activity->likes_count ?? $activity->likes->count() }}</span>
                                <span class="flex items-center gap-1"><svg class="h-4 w-4 text-blue-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                            clip-rule="evenodd" />
                                    </svg> {{ $activity->comments_count ?? $activity->comments->count() }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $activity->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
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