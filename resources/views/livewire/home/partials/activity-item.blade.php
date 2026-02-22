<div x-data="{ 
    showMenu: false,
    editingActivity: @entangle('editingActivity'),
    confirmingActivityDeletion: @entangle('confirmingActivityDeletion'),
    confirmingCommentDeletion: @entangle('confirmingCommentDeletion')
}" class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
    @if (session()->has('error'))
        <div class="p-4 bg-red-50 border-b border-red-100 text-red-600 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border-b border-green-100 text-green-600 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('message') }}
        </div>
    @endif
    <!-- Post Header -->
    <div class="flex justify-between items-start p-4 pb-3">
        <div class="flex items-center gap-3 flex-1">
            <a href="{{ profile_url($activity->user) }}" class="block shrink-0">
                <img src="{{ $activity->user->image_url }}"
                    class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-zinc-800 hover:ring-2 hover:ring-brand-500 transition-all">
            </a>
            <div class="flex-1 min-w-0">
                <a href="{{ profile_url($activity->user) }}"
                    class="font-bold text-zinc-900 dark:text-white hover:text-brand-600 transition-colors block leading-tight truncate">
                    {{ $activity->user->name }}
                </a>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                    {{ $activity->start_time->diffForHumans() }}
                </p>
            </div>
        </div>

        <!-- Three Dots Menu -->
        <div class="relative" @click.away="showMenu = false">
            <button @click="showMenu = !showMenu"
                class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full transition-colors">
                <svg class="w-5 h-5 text-zinc-500" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="showMenu" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 z-10"
                style="display: none;">
                <div class="py-1">
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                        Salvar atividade
                    </button>
                    @if(auth()->id() == $activity->user_id || auth()->user()->isAdmin())
                        <button @click="showMenu = false; $wire.startEditingActivity()"
                            class="w-full text-left px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                            Editar atividade
                        </button>
                        <button @click="showMenu = false; $wire.confirmDeleteActivity()"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                            Excluir atividade
                        </button>
                    @else
                        <button
                            class="w-full text-left px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                            Denunciar atividade
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Post Content -->
    @if($activity->description)
        <div class="px-4 pb-3">
            <p class="text-sm text-zinc-700 dark:text-zinc-300 whitespace-pre-line">
                {{ Str::limit($activity->description, 200) }}
            </p>
            @if(strlen($activity->description) > 200)
                <button class="text-brand-600 hover:text-brand-700 text-sm font-medium mt-1">Ver mais</button>
            @endif
        </div>
    @endif

    <!-- Media Section -->
    @php
        // Filter out local Android/iOS paths that won't load on web
        $mediaItems = collect($activity->media ?? [])->filter(function ($path) {
            return str_starts_with($path, 'http') || str_starts_with($path, '/storage') || str_starts_with($path, 'storage/');
        })->values()->all();

        $hasMedia = !empty($mediaItems) || !empty($activity->polylines);
        $mediaCount = count($mediaItems);
    @endphp

    @if($hasMedia)
        <!-- Map Display -->
        @if(!empty($activity->polylines))
            @php
                $poly = null;
                if (is_array($activity->polylines)) {
                    // Extract summary_polyline from the polylines array
                    $poly = $activity->polylines['summary_polyline'] ?? null;
                } else {
                    // If it's a string, use it directly
                    $poly = $activity->polylines;
                }
            @endphp

            @if($poly)
                <div class="w-full aspect-video bg-zinc-100 dark:bg-zinc-800 relative overflow-hidden">
                    <img src="https://maps.googleapis.com/maps/api/staticmap?size=800x450&maptype=roadmap&path=enc:{{ $poly }}&key={{ config('services.google.maps_key') }}"
                        class="w-full h-full object-cover" alt="Mapa da atividade" loading="lazy">
                </div>
            @else
                <div class="w-full aspect-video bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 003 16.382V5.618a1 1 0 011.553-.894L9 7m0 0v10m0-10L5.553 2.894A1 1 0 005 2h14a1 1 0 011 1v14a1 1 0 01-1.553.894L15 13m0 0v10m0-10l4.447 2.724A1 1 0 0021 20.382V9.618a1 1 0 00-1.553-.894L15 11" />
                        </svg>
                        <p class="text-sm text-zinc-400">Mapa indisponível</p>
                    </div>
                </div>
            @endif
        @endif

        <!-- Media Grid -->
        @if($mediaCount > 0)
            @if($mediaCount === 1)
                <!-- Single Image/Video - Full Width -->
                <div class="w-full aspect-4/5 bg-zinc-100 dark:bg-zinc-800 relative">
                    @if(str_contains($mediaItems[0], '.mp4'))
                        <video src="{{ $mediaItems[0] }}" controls class="w-full h-full object-cover"></video>
                    @else
                        <img src="{{ $mediaItems[0] }}" class="w-full h-full object-cover" alt="Post image">
                    @endif
                </div>
            @elseif($mediaCount === 2)
                <!-- Two Images Side by Side -->
                <div class="grid grid-cols-2 gap-0.5">
                    @foreach($mediaItems as $media)
                        <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 relative">
                            @if(str_contains($media, '.mp4'))
                                <video src="{{ $media }}" controls class="w-full h-full object-cover"></video>
                            @else
                                <img src="{{ $media }}" class="w-full h-full object-cover" alt="Post image">
                            @endif
                        </div>
                    @endforeach
                </div>
            @elseif($mediaCount === 3)
                <!-- Three Images Grid -->
                <div class="grid grid-cols-2 gap-0.5">
                    <div class="row-span-2 aspect-square bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ $mediaItems[0] }}" class="w-full h-full object-cover" alt="Post image">
                    </div>
                    <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ $mediaItems[1] }}" class="w-full h-full object-cover" alt="Post image">
                    </div>
                    <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ $mediaItems[2] }}" class="w-full h-full object-cover" alt="Post image">
                    </div>
                </div>
            @else
                <!-- 4+ Images Grid with Counter -->
                <div class="grid grid-cols-2 gap-0.5">
                    @foreach($mediaItems as $index => $media)
                        @if($index < 4)
                            <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 relative">
                                <img src="{{ $media }}" class="w-full h-full object-cover" alt="Post image">
                                @if($index === 3 && $mediaCount > 4)
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                        <span class="text-white text-3xl font-bold">+{{ $mediaCount - 4 }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
    @endif

    <!-- Activity Stats (if sports activity) -->
    <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800">
        <div class="flex items-center justify-around text-center">
            <div>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">
                    {{ number_format(($activity->distance ?? 0) / 1000, 2, ',', '.') }}
                </p>
                <p class="text-[10px] uppercase font-bold tracking-wider text-zinc-500 dark:text-zinc-400">Distância</p>
            </div>

            @php
                $pace = 0;
                if (($activity->distance ?? 0) > 0 && ($activity->duration ?? 0) > 0) {
                    $pace = ($activity->duration / 60) / ($activity->distance / 1000);
                }
                $paceMin = floor($pace);
                $paceSec = round(($pace - $paceMin) * 60);
            @endphp
            <div>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">
                    {{ $paceMin }}:{{ str_pad($paceSec, 2, '0', STR_PAD_LEFT) }}
                </p>
                <p class="text-[10px] uppercase font-bold tracking-wider text-zinc-500 dark:text-zinc-400">Ritmo</p>
            </div>

            <div>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">
                    {{ $activity->duration ? gmdate($activity->duration >= 3600 ? "H:i:s" : "i:s", $activity->duration) : '00:00' }}
                </p>
                <p class="text-[10px] uppercase font-bold tracking-wider text-zinc-500 dark:text-zinc-400">Tempo</p>
            </div>

            <div>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">
                    {{ number_format($activity->calories ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-[10px] uppercase font-bold tracking-wider text-zinc-500 dark:text-zinc-400">Calorias</p>
            </div>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <!-- Like Button -->
                <button wire:click="toggleLike" class="flex items-center gap-2 group">
                    @if($activity->likes->contains('user_id', auth()->id()))
                        <svg class="w-6 h-6 text-red-500 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-zinc-500 group-hover:text-red-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    @endif
                    <span
                        class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $activity->likes->count() }}</span>
                </button>

                <!-- Comment Button -->
                <button @click="$wire.showComments = !$wire.showComments" class="flex items-center gap-2 group">
                    <svg class="w-6 h-6 text-zinc-500 group-hover:text-brand-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span
                        class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $activity->comments->count() }}</span>
                </button>
            </div>

            <!-- Share Button -->
            <button class="flex items-center gap-2 group">
                <svg class="w-6 h-6 text-zinc-500 group-hover:text-brand-600 transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Comments Section -->
    <div x-data="{ showComments: @entangle('showComments') }" x-show="showComments" x-transition
        class="border-t border-zinc-100 dark:border-zinc-800 px-4 py-3">

        <!-- Comments List -->
        <div class="space-y-3 mb-4 max-h-96 overflow-y-auto">
            @foreach($activity->comments as $comment)
                @if(is_null($comment->parent_id))
                    <div x-data="{ showReplies: false }" class="group/comment" wire:key="comment-{{ $comment->id }}">
                        <div class="flex gap-2">
                            <a href="{{ profile_url($comment->user) }}">
                                <img src="{{ $comment->user->image_url }}"
                                    class="w-8 h-8 rounded-full border border-zinc-100 dark:border-zinc-800 shrink-0">
                            </a>
                            <div class="flex-1 min-w-0">
                                <div class="bg-zinc-100 dark:bg-zinc-800 rounded-2xl px-3 py-2 inline-block">
                                    <a href="{{ profile_url($comment->user) }}"
                                        class="font-semibold text-sm text-zinc-900 dark:text-white hover:underline">
                                        {{ $comment->user->name }}
                                    </a>
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {!! $this->formatComment($comment->body) !!}
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 mt-1 ml-3 text-xs text-zinc-500">
                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                    <button wire:click="toggleCommentLike({{ $comment->id }})"
                                        class="flex items-center gap-1 hover:scale-110 transition-transform">
                                        <span
                                            class="{{ $comment->likes->contains('user_id', auth()->id()) ? 'text-red-500' : 'text-zinc-400' }}">❤️</span>
                                        <span
                                            class="text-[10px] font-semibold {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-red-500' : 'text-zinc-500' }}">{{ $comment->likes->count() }}</span>
                                    </button>
                                    <button
                                        @click="$wire.set('replyingToCommentId', {{ $comment->id }}); $refs.commentInput.focus(); $wire.set('newComment', '@' + '{{ $comment->user->name }} ' );"
                                        class="font-semibold hover:underline">
                                        Responder
                                    </button>
                                    @if(auth()->id() === $comment->user_id || auth()->id() === $activity->user_id)
                                        <button wire:click="confirmDelete({{ $comment->id }})"
                                            class="opacity-0 group-hover/comment:opacity-100 transition-opacity text-red-600 hover:underline">
                                            Excluir
                                        </button>
                                    @endif
                                </div>

                                <!-- Replies -->
                                @if($comment->replies->count() > 0)
                                    <button @click="showReplies = !showReplies"
                                        class="text-xs text-zinc-500 font-semibold mt-2 ml-3 hover:underline">
                                        <span
                                            x-text="showReplies ? 'Ocultar respostas' : 'Ver {{ $comment->replies->count() }} resposta(s)'"></span>
                                    </button>

                                    <div x-show="showReplies" style="display: none;" class="mt-2 ml-8 space-y-2">
                                        @foreach($comment->replies as $reply)
                                            <div class="flex gap-2 group/reply" wire:key="reply-{{ $reply->id }}">
                                                <img src="{{ $reply->user->image_url }}" class="w-6 h-6 rounded-full">
                                                <div class="flex-1">
                                                    <div class="bg-zinc-100 dark:bg-zinc-800 rounded-2xl px-3 py-1.5 inline-block">
                                                        <a href="{{ profile_url($reply->user) }}"
                                                            class="font-semibold text-xs text-zinc-900 dark:text-white hover:underline">
                                                            {{ $reply->user->name }}
                                                        </a>
                                                        <p class="text-xs text-zinc-700 dark:text-zinc-300">
                                                            {!! $this->formatComment($reply->body) !!}
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center gap-3 mt-1 ml-2 text-[10px] text-zinc-500">
                                                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                        <button wire:click="toggleCommentLike({{ $reply->id }})"
                                                            class="flex items-center gap-1 hover:scale-110 transition-transform">
                                                            <span
                                                                class="{{ $reply->likes->contains('user_id', auth()->id()) ? 'text-red-500' : 'text-zinc-400' }}">❤️</span>
                                                            <span
                                                                class="text-[10px] font-semibold {{ $reply->likes->contains('user_id', auth()->id()) ? 'text-red-500' : 'text-zinc-500' }}">{{ $reply->likes->count() }}</span>
                                                        </button>
                                                        @if(auth()->id() === $reply->user_id || auth()->id() === $activity->user_id)
                                                            <button wire:click="confirmDelete({{ $reply->id }})"
                                                                class="opacity-0 group-hover/reply:opacity-100 transition-opacity text-red-600 hover:underline">
                                                                Excluir
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Comment Input -->
        <div class="flex gap-2 items-center relative">
            <img src="{{ auth()->user()->image_url }}" class="w-8 h-8 rounded-full object-cover">
            <div class="flex-1 relative">
                <input type="text" x-ref="commentInput" wire:model.live="newComment" wire:keydown.enter="postComment"
                    placeholder="Escreva um comentário..."
                    class="w-full bg-zinc-100 dark:bg-zinc-800 border-none rounded-full px-4 py-2 text-sm focus:ring-2 focus:ring-brand-500 text-zinc-700 dark:text-zinc-200 placeholder-zinc-400">

                <!-- Mentions Dropdown -->
                @if($showMentions && count($filteredUsers) > 0)
                    <div
                        class="absolute bottom-full left-0 mb-2 w-64 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden z-20">
                        <ul>
                            @foreach($filteredUsers as $user)
                                <li wire:click="selectUser({{ json_encode($user) }})"
                                    class="flex items-center gap-3 px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700 cursor-pointer">
                                    <img src="{{ $user['image_url'] }}" class="w-8 h-8 rounded-full">
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $user['name'] }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal wire:model="confirmingCommentDeletion" :maxWidth="'sm:max-w-[700px]'" :showCloseButton="false"
        wire:key="delete-comment-modal-activity-{{ $activity->id }}">
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/20">
                    <svg class="h-5 w-5 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Apagar Comentário</h3>
                </div>
            </div>

            <p class="text-sm text-gray-500 dark:text-neutral-400 pl-14">
                Tem certeza que deseja remover este comentário? Esta ação não pode ser desfeita.
            </p>

            <div class="mt-6 border-t border-gray-100 dark:border-neutral-800 pt-6">
                <div class="flex items-center justify-start gap-3 pl-14">
                    <button type="button" wire:click="cancelDelete"
                        class="inline-flex justify-center items-center rounded-lg bg-yellow-400 dark:bg-yellow-500 px-5 py-2 text-sm font-bold text-white shadow-sm hover:bg-yellow-500 dark:hover:bg-yellow-600 transition-all">
                        Cancelar
                    </button>
                    <button type="button" wire:click="deleteComment"
                        class="inline-flex justify-center items-center rounded-lg bg-red-600 dark:bg-red-500 px-5 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-700 dark:hover:bg-red-600 transition-all">
                        Apagar Comentário
                    </button>
                </div>
            </div>
        </div>
    </x-ui.modal>

    <!-- Edit Activity Modal -->
    <x-ui.modal wire:model="editingActivity" :showCloseButton="true" wire:key="edit-activity-modal-{{ $activity->id }}"
        :maxWidth="'sm:max-w-lg'">
        <div class="p-4 sm:p-6 pb-2 sm:pb-4">
            <h3 class="text-xl font-bold text-gray-800 dark:text-neutral-200 mb-6">Editar Atividade</h3>

            <div class="space-y-4">
                <!-- Title Input -->
                <div class="border border-gray-200 dark:border-neutral-700 rounded-lg p-3">
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Título</label>
                    <input type="text" wire:model="editTitle"
                        class="w-full bg-transparent border-none p-0 text-sm text-gray-800 dark:text-neutral-200 focus:ring-0 placeholder-gray-400"
                        placeholder="Insira o título da atividade">
                </div>
                @error('editTitle') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

                <!-- Content Input -->
                <div class="border border-gray-200 dark:border-neutral-700 rounded-lg p-3">
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Descrição</label>
                    <textarea wire:model="editContent" rows="4"
                        class="w-full bg-transparent border-none p-0 text-sm text-gray-800 dark:text-neutral-200 focus:ring-0 placeholder-gray-400 resize-none"
                        placeholder="Detalhes da atividade..."></textarea>
                </div>
                @error('editContent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mt-8 flex items-center justify-start gap-3">
                <button type="button" wire:click="cancelEditingActivity"
                    class="inline-flex justify-center items-center rounded-lg bg-yellow-400 dark:bg-yellow-500 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-yellow-500 dark:hover:bg-yellow-600 transition-all">
                    Cancelar
                </button>
                <button type="button" wire:click="updateActivity"
                    class="inline-flex justify-center items-center rounded-lg bg-green-600 dark:bg-green-500 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-green-700 dark:hover:bg-green-600 transition-all">
                    Salvar Alterações
                </button>
            </div>
        </div>
    </x-ui.modal>

    <!-- Delete Activity Confirmation Modal -->
    <x-ui.modal wire:model="confirmingActivityDeletion" :maxWidth="'sm:max-w-[700px]'" :showCloseButton="false"
        wire:key="delete-activity-modal-{{ $activity->id }}">
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div
                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/20">
                    <svg class="h-5 w-5 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-neutral-200">Apagar Atividade</h3>
                </div>
            </div>

            <p class="text-sm text-gray-500 dark:text-neutral-400 pl-14">
                Tem certeza que deseja remover esta atividade? Esta ação não pode ser desfeita e todos os comentários e
                curtidas serão perdidos.
            </p>

            <div class="mt-6 border-t border-gray-100 dark:border-neutral-800 pt-6">
                <div class="flex items-center justify-start gap-3 pl-14">
                    <button type="button" @click="showMenu = false; $wire.cancelDeleteActivity()"
                        class="inline-flex justify-center items-center rounded-lg bg-yellow-400 dark:bg-yellow-500 px-5 py-2 text-sm font-bold text-white shadow-sm hover:bg-yellow-500 dark:hover:bg-yellow-600 transition-all">
                        Cancelar
                    </button>
                    <button type="button" wire:click="deleteActivity"
                        class="inline-flex justify-center items-center rounded-lg bg-red-600 dark:bg-red-500 px-5 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-700 dark:hover:bg-red-600 transition-all">
                        Apagar Atividade
                    </button>
                </div>
            </div>
        </div>
    </x-ui.modal>
</div>