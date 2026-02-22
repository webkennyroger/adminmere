<div x-data="{ 
    showMenu: false,
    editingPost: @entangle('editingPost'),
    editingPoll: @entangle('editingPoll'),
    confirmingPostDeletion: @entangle('confirmingPostDeletion'),
    confirmingPollDeletion: @entangle('confirmingPollDeletion'),
    confirmingCommentDeletion: @entangle('confirmingCommentDeletion')
}"
    class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
    @if (session()->has('error'))
        <div class="p-4 bg-red-50 border-b border-red-100 text-red-600 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="p-4 bg-green-50 border-b border-green-100 text-green-600 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('message') }}
        </div>
    @endif
    <!-- Post Header -->
    <div class="flex justify-between items-start p-4 pb-3">
        <div class="flex items-center gap-3 flex-1">
            <a href="{{ profile_url($post->user) }}" class="block shrink-0">
                <img src="{{ $post->user->image_url }}"
                    class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-zinc-800 hover:ring-2 hover:ring-brand-500 transition-all">
            </a>
            <div class="flex-1 min-w-0">
                <a href="{{ profile_url($post->user) }}"
                    class="font-bold text-zinc-900 dark:text-white hover:text-brand-600 transition-colors block leading-tight truncate">
                    {{ $post->user->name }}
                </a>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        <!-- Bookmark Icon (Save Post) + Owner Menu -->
        <div class="flex items-center gap-2">
            <!-- Bookmark Icon -->
            <button class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full transition-colors">
                <svg class="w-5 h-5 text-zinc-500 hover:text-brand-600 transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
            </button>

            <!-- Three Dots Menu (Only for Owner or Admin) -->
            @if(auth()->id() == $post->user_id || auth()->user()->isAdmin())
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
                            <button @click="showMenu = false; $wire.startEditingPost()"
                                class="w-full text-left px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                                {{ $post->type === 'poll' ? 'Editar enquete' : 'Editar post' }}
                            </button>
                            <button @click="showMenu = false; $wire.confirmDeletePost()"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                                {{ $post->type === 'poll' ? 'Excluir enquete' : 'Excluir post' }}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Post Title -->
    @if($post->title)
        <div class="px-4 pb-2">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
                {{ $post->title }}
            </h3>
        </div>
    @endif

    <!-- Post Content -->
    @if($post->content)
        <div class="px-4 pb-3">
            <p class="text-sm text-zinc-700 dark:text-zinc-300 whitespace-pre-line">
                {{ Str::limit($post->content, 300) }}
            </p>
            @if(strlen($post->content) > 300)
                <button class="text-brand-600 hover:text-brand-700 text-sm font-medium mt-1">Ver mais</button>
            @endif
        </div>
    @endif

    <!-- Poll Section -->
    @if($post->is_poll)
        <div class="px-4 pb-4">
            <div class="space-y-2 mt-2">
                @php
                    $hasVoted = $post->hasVoted(auth()->user());
                    $totalVotes = $post->total_votes;
                    $isExpired = $post->poll_expires_at && $post->poll_expires_at->isPast();
                    $isMultiple = (bool)(is_array($post->meta) && ($post->meta['isMultiple'] ?? false));
                    // Show results ONLY if voted or expired. Don't force show for owner unless voted.
                    $showResults = $hasVoted || $isExpired;
                @endphp

                @if($isMultiple)
                    <div class="flex items-center gap-1.5 mb-2 text-zinc-500 dark:text-zinc-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="text-[11px] font-semibold uppercase tracking-wider">Múltipla escolha</span>
                    </div>
                @endif

                @foreach($post->pollOptions as $option)
                    @php
                        $percentage = $totalVotes > 0 ? round(($option->votes_count / $totalVotes) * 100) : 0;
                        $isVotedOption = $hasVoted && $post->pollVotes->where('user_id', auth()->id())->where('poll_option_id', $option->id)->isNotEmpty();
                        // For Multiple Choice: show result only for the specific option voted, otherwise keep voting button.
                        // For Single Choice: show all results if any option was voted.
                        // Expired: always show results.
                        $showThisResult = $isExpired || ($isMultiple ? $isVotedOption : $hasVoted);
                    @endphp

                    <div class="relative w-full">
                        @if($showThisResult)
                            <!-- Result View -->
                            <div class="relative w-full h-10 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                <!-- Progress Bar -->
                                <div class="absolute top-0 left-0 h-full bg-purple-100 dark:bg-purple-900/30 transition-all duration-500"
                                     style="width: {{ $percentage }}%"></div>
                                
                                <!-- Content -->
                                <div class="absolute inset-0 flex items-center justify-between px-4 z-10">
                                    <span class="text-sm font-medium {{ $isVotedOption ? 'text-purple-700 dark:text-purple-300' : 'text-zinc-700 dark:text-zinc-300' }}">
                                        {{ $option->option_text }}
                                        @if($isVotedOption) <span class="ml-1 text-xs bg-purple-200 dark:bg-purple-800 text-purple-800 dark:text-purple-200 px-1.5 py-0.5 rounded-md">Você</span> @endif
                                    </span>
                                    <span class="text-xs font-bold text-zinc-600 dark:text-zinc-400">{{ $percentage }}%</span>
                                </div>
                            </div>
                        @else
                            <!-- Voting View -->
                            <button wire:click="vote({{ $option->id }})" wire:loading.attr="disabled"
                                class="w-full text-left px-4 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 hover:border-purple-500 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 text-zinc-900 dark:text-white transition-all text-sm font-medium">
                                {{ $option->option_text }}
                            </button>
                        @endif
                    </div>
                @endforeach

                <div class="flex justify-between items-center mt-2 text-xs text-zinc-500 dark:text-zinc-400 px-1">
                    <span>{{ $totalVotes }} votos</span>
                    <span>
                        @if($isExpired)
                            Encerrado
                        @elseif($post->poll_expires_at)
                            Termina em {{ $post->poll_expires_at->diffForHumans() }}
                        @else
                            Sem prazo
                        @endif
                    </span>
                </div>
            </div>
        </div>
    @endif

    <!-- Media Section -->
    @php
        $mediaItems = collect($post->media ?? [])->filter(function ($path) {
            if (empty($path)) return false;
            // Accept http/https URLs or storage paths
            return str_starts_with($path, 'http://') || 
                   str_starts_with($path, 'https://') || 
                   str_starts_with($path, '/storage') || 
                   str_starts_with($path, 'storage/');
        })->values()->all();
        $mediaCount = count($mediaItems);
    @endphp

    @if($mediaCount > 0)
        @if($mediaCount === 1)
            <div class="w-full max-h-[600px] bg-zinc-100 dark:bg-zinc-800 relative flex items-center justify-center">
                @if(str_contains($mediaItems[0], '.mp4'))
                    <video src="{{ $mediaItems[0] }}" controls class="w-full max-h-[600px] object-contain"></video>
                @else
                    <img src="{{ $mediaItems[0] }}" class="w-full max-h-[600px] object-contain cursor-pointer hover:opacity-90 transition-opacity" alt="Post image" @click="$dispatch('open-lightbox', { images: {{ json_encode($mediaItems) }}, index: 0 })">
                @endif
            </div>
        @elseif($mediaCount === 2)
            <div class="grid grid-cols-2 gap-0.5">
                @foreach($mediaItems as $media)
                    <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 relative">
                        @if(str_contains($media, '.mp4'))
                            <video src="{{ $media }}" controls class="w-full h-full object-cover"></video>
                        @else
                            <img src="{{ $media }}" class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity" alt="Post image" @click="$dispatch('open-lightbox', { images: {{ json_encode($mediaItems) }}, index: {{ $loop->index }} })">
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif($mediaCount === 3)
            <div class="grid grid-cols-2 gap-0.5">
                <div class="row-span-2 aspect-square bg-zinc-100 dark:bg-zinc-800">
                    <img src="{{ $mediaItems[0] }}" class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity" alt="Post image" @click="$dispatch('open-lightbox', { images: {{ json_encode($mediaItems) }}, index: 0 })">
                </div>
                <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                    <img src="{{ $mediaItems[1] }}" class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity" alt="Post image" @click="$dispatch('open-lightbox', { images: {{ json_encode($mediaItems) }}, index: 1 })">
                </div>
                <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                    <img src="{{ $mediaItems[2] }}" class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity" alt="Post image" @click="$dispatch('open-lightbox', { images: {{ json_encode($mediaItems) }}, index: 2 })">
                </div>
            </div>
        @else
            <div class="grid grid-cols-2 gap-0.5">
                @foreach($mediaItems as $index => $media)
                    @if($index < 4)
                        <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 relative">
                            <img src="{{ $media }}" class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity" alt="Post image" @click="$dispatch('open-lightbox', { images: {{ json_encode($mediaItems) }}, index: {{ $index }} })">
                            @if($index === 3 && $mediaCount > 4)
                                <div class="absolute inset-0 bg-black/70 flex flex-col items-center justify-center cursor-pointer hover:bg-black/80 transition-colors" @click="$dispatch('open-lightbox', { images: {{ json_encode($mediaItems) }}, index: 0 })">
                                    <span class="text-white text-4xl font-bold mb-1">+{{ $mediaCount - 4 }}</span>
                                    <span class="text-white text-sm font-medium">Ver todas</span>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    @endif

    <!-- Actions Bar -->
    <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <!-- Like Button -->
                <button wire:click="toggleLike" class="flex items-center gap-2 group">
                    @if($post->likes->contains('user_id', auth()->id()))
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
                        class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $post->likes->count() }}</span>
                </button>

                <!-- Comment Button -->
                <button @click="$wire.showComments = !$wire.showComments" class="flex items-center gap-2 group">
                    <svg class="w-6 h-6 text-zinc-500 group-hover:text-brand-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span
                        class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $post->comments->count() }}</span>
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
            @foreach($post->comments as $comment)
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
                                    @if(auth()->id() === $comment->user_id || auth()->id() === $post->user_id)
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
                                                        @if(auth()->id() === $reply->user_id || auth()->id() === $post->user_id)
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

    <!-- Delete Comment Modal -->
    <x-ui.modal :isOpen="!!$confirmingCommentDeletion" :showCloseButton="false" wire:key="delete-comment-modal-{{ $post->id }}">
        <div class="sm:flex sm:items-start">
            <div class="w-full">
                <x-ui.alert variant="error" title="Apagar comentário"
                    message="Tem certeza que deseja remover este comentário? Esta ação não pode ser desfeita." />
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-2">
            <button type="button" wire:click="deleteComment"
                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                Apagar
            </button>
            <button type="button" wire:click="cancelDelete"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50 sm:mt-0 sm:w-auto dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-700">
                Cancelar
            </button>
        </div>
    </x-ui.modal>

    <!-- Edit Post Modal -->
    <x-ui.modal :isOpen="$editingPost" :showCloseButton="false" wire:key="edit-post-modal-{{ $post->id }}">
        <div class="sm:flex sm:items-start">
            <div class="w-full">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Editar Publicação</h3>

                <div class="space-y-3">
                    <!-- Title Input -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Título
                            (opcional)</label>
                        <input type="text" wire:model="editTitle"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 text-zinc-900 dark:text-white">
                        @error('editTitle') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Content Input -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Conteúdo</label>
                        <textarea wire:model="editContent" rows="4"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 text-zinc-900 dark:text-white resize-none"></textarea>
                        @error('editContent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-2">
            <button type="button" wire:click="updatePost"
                class="inline-flex w-full justify-center rounded-md bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-700 sm:w-auto">
                Salvar
            </button>
            <button type="button" wire:click="cancelEditingPost"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50 sm:mt-0 sm:w-auto dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-700">
                Cancelar
            </button>
        </div>
    </x-ui.modal>

    <!-- Delete Post Modal -->
    <x-ui.modal :isOpen="$confirmingPostDeletion" :showCloseButton="false" wire:key="delete-post-modal-{{ $post->id }}">
        <div class="sm:flex sm:items-start">
            <div class="w-full">
                <x-ui.alert variant="error" title="Apagar publicação"
                    message="Tem certeza que deseja remover esta publicação? Esta ação não pode ser desfeita e todos os comentários e curtidas serão perdidos." />
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-2">
            <button type="button" wire:click="deletePost"
                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                {{ $post->type === 'poll' ? 'Apagar Enquete' : 'Apagar Publicação' }}
            </button>
            <button type="button" @click="showMenu = false; $wire.cancelDeletePost()"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50 sm:mt-0 sm:w-auto dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-700">
                Cancelar
            </button>
        </div>
    </x-ui.modal>

    <!-- Delete Poll Modal -->
    <x-ui.modal :isOpen="$confirmingPollDeletion" :showCloseButton="false" wire:key="delete-poll-modal-{{ $post->id }}">
        <div class="sm:flex sm:items-start">
            <div class="w-full">
                <x-ui.alert variant="error" title="Apagar Enquete"
                    message="Tem certeza que deseja remover esta enquete? Esta ação não pode ser desfeita e todos os votos serão perdidos." />
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-2">
            <button type="button" wire:click="deletePost"
                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                Apagar Enquete
            </button>
            <button type="button" @click="showMenu = false; $wire.cancelDeletePost()"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50 sm:mt-0 sm:w-auto dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-700">
                Cancelar
            </button>
        </div>
    </x-ui.modal>

    <!-- Edit Poll Modal -->
    <x-ui.modal :isOpen="$editingPoll" :showCloseButton="false" wire:key="edit-poll-modal-{{ $post->id }}">
        <div class="sm:flex sm:items-start">
            <div class="w-full">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Editar Enquete</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Título da Enquete</label>
                        <input type="text" wire:model="editTitle"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 text-zinc-900 dark:text-white">
                        @error('editTitle') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-2">
            <button type="button" wire:click="updatePost"
                class="inline-flex w-full justify-center rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-700 sm:w-auto">
                Salvar Enquete
            </button>
            <button type="button" wire:click="cancelEditingPost"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50 sm:mt-0 sm:w-auto dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-700">
                Cancelar
            </button>
        </div>
    </x-ui.modal>
</div>