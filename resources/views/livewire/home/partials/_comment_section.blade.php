<div x-data="{ showComments: @entangle('showComments') }" x-show="showComments" x-transition
    class="border-t border-zinc-100 dark:border-zinc-800 px-4 py-3">

    <!-- Comments List -->
    <div class="space-y-3 mb-4 max-h-96 overflow-y-auto">
        @foreach($item->comments as $comment)
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
                                @if(auth()->id() === $comment->user_id || auth()->id() === $item->user_id || auth()->user()->isAdmin())
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
                                                    @if(auth()->id() === $reply->user_id || auth()->id() === $item->user_id || auth()->user()->isAdmin())
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
        <div class="flex-1 relative" x-data="{ showMentions: @entangle('showMentions') }">
            <input type="text" x-ref="commentInput" wire:model.live="newComment" wire:keydown.enter="postComment"
                placeholder="Escreva um comentário..."
                class="w-full bg-zinc-100 dark:bg-zinc-800 border-none rounded-full px-4 py-2 text-sm focus:ring-2 focus:ring-brand-500 text-zinc-700 dark:text-zinc-200 placeholder-zinc-400">

            <!-- Mentions Dropdown -->
            <div x-show="showMentions" x-cloak
                class="absolute bottom-full left-0 mb-2 w-64 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden z-20">
                @if(count($filteredUsers) > 0)
                    <ul>
                        @foreach($filteredUsers as $user)
                            <li wire:click="selectUser({{ json_encode($user) }})"
                                class="flex items-center gap-3 px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700 cursor-pointer">
                                <img src="{{ $user['image_url'] }}" class="w-8 h-8 rounded-full">
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $user['name'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>