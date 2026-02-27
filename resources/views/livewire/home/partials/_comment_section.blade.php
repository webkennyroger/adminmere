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
                                    @if($editingCommentId === $comment->id)
                                        <div class="mt-2">
                                            <textarea wire:model="editCommentBody"
                                                class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-sm focus:ring-brand-500 focus:border-brand-500"
                                                rows="2"></textarea>
                                            @error('editCommentBody') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            <div class="flex gap-2 mt-2 justify-end">
                                                <button wire:click="cancelEditingComment"
                                                    class="text-xs text-zinc-500 hover:text-zinc-700 font-medium">Cancelar</button>
                                                <button wire:click="updateComment"
                                                    class="text-xs bg-brand-500 text-white px-3 py-1 rounded-full font-medium hover:bg-brand-600 transition">Salvar</button>
                                            </div>
                                        </div>
                                    @else
                                    {!! $this->formatComment($comment->body) !!}
                                @endif
                                </p>
                                @if($comment->media_url)
                                    <div class="mt-2 text-zinc-700 dark:text-zinc-300">
                                        <div x-on:click='$dispatch("open-lightbox", { images: ["{{ $comment->media_url }}"], index: 0 })'
                                            class="cursor-pointer inline-block">
                                            <img src="{{ $comment->media_url }}"
                                                class="rounded-lg max-h-48 object-cover border border-zinc-200 dark:border-zinc-700 hover:opacity-90 transition-opacity"
                                                alt="Imagem do comentário">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 mt-1 ml-3 text-xs text-zinc-500">
                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                                <button wire:click="toggleCommentLike({{ $comment->id }})"
                                    class="flex items-center gap-1 hover:scale-110 transition-transform {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-green-500' : 'text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300' }}">
                                    <svg class="w-3.5 h-3.5 {{ $comment->likes->contains('user_id', auth()->id()) ? 'fill-current' : 'fill-none' }}"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    <span
                                        class="text-[10px] font-semibold {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-green-500' : 'text-zinc-500' }}">{{ $comment->likes->count() }}</span>
                                </button>
                                <button
                                    @click="$wire.set('replyingToCommentId', {{ $comment->id }}); $refs.commentInput.focus(); $wire.set('newComment', '@' + '{{ $comment->user->name }} ' );"
                                    class="font-semibold hover:underline">
                                    Responder
                                </button>
                                @if(auth()->id() === $comment->user_id || auth()->id() === $item->user_id || auth()->user()->isAdmin())
                                    <button wire:click="startEditingComment({{ $comment->id }})"
                                        class="opacity-0 group-hover/comment:opacity-100 transition-opacity text-blue-600 hover:underline">
                                        Editar
                                    </button>
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
                                                        @if($editingCommentId === $reply->id)
                                                            <div class="mt-2 text-sm">
                                                                <textarea wire:model="editCommentBody"
                                                                    class="w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 text-xs focus:ring-brand-500 focus:border-brand-500"
                                                                    rows="2"></textarea>
                                                                @error('editCommentBody') <span
                                                                class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                                <div class="flex gap-2 mt-2 justify-end">
                                                                    <button wire:click="cancelEditingComment"
                                                                        class="text-[10px] text-zinc-500 hover:text-zinc-700 font-medium">Cancelar</button>
                                                                    <button wire:click="updateComment"
                                                                        class="text-[10px] bg-brand-500 text-white px-2 py-1 rounded-full font-medium hover:bg-brand-600 transition">Salvar</button>
                                                                </div>
                                                            </div>
                                                        @else
                                                        {!! $this->formatComment($reply->body) !!}
                                                    @endif
                                                    </p>
                                                    @if($reply->media_url)
                                                        <div class="mt-2 text-zinc-700 dark:text-zinc-300">
                                                            <div x-on:click='$dispatch("open-lightbox", { images: ["{{ $reply->media_url }}"], index: 0 })'
                                                                class="cursor-pointer inline-block">
                                                                <img src="{{ $reply->media_url }}"
                                                                    class="rounded-lg max-h-32 object-cover border border-zinc-200 dark:border-zinc-700 hover:opacity-90 transition-opacity"
                                                                    alt="Imagem da resposta">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-3 mt-1 ml-2 text-[10px] text-zinc-500">
                                                    <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                    <button wire:click="toggleCommentLike({{ $reply->id }})"
                                                        class="flex items-center gap-1 hover:scale-110 transition-transform {{ $reply->likes->contains('user_id', auth()->id()) ? 'text-green-500' : 'text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300' }}">
                                                        <svg class="w-3 h-3 {{ $reply->likes->contains('user_id', auth()->id()) ? 'fill-current' : 'fill-none' }}"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                            </path>
                                                        </svg>
                                                        <span
                                                            class="text-[10px] font-semibold {{ $reply->likes->contains('user_id', auth()->id()) ? 'text-green-500' : 'text-zinc-500' }}">{{ $reply->likes->count() }}</span>
                                                    </button>
                                                    @if(auth()->id() === $reply->user_id || auth()->id() === $item->user_id || auth()->user()->isAdmin())
                                                        <button wire:click="startEditingComment({{ $reply->id }})"
                                                            class="opacity-0 group-hover/reply:opacity-100 transition-opacity text-blue-600 hover:underline">
                                                            Editar
                                                        </button>
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
    <div class="flex gap-2 items-start relative mt-2">
        <img src="{{ auth()->user()->image_url }}" class="w-8 h-8 rounded-full object-cover shrink-0 mt-1">
        <div class="flex-1 relative bg-zinc-100 dark:bg-zinc-800 rounded-3xl p-1 px-2 border border-transparent focus-within:border-brand-500 focus-within:ring-1 focus-within:ring-brand-500"
            x-data="{ showMentions: @entangle('showMentions') }">

            @if($commentImage)
                <div class="relative inline-block mt-2 mb-1 mx-2">
                    <img src="{{ $commentImage->temporaryUrl() }}"
                        class="h-20 rounded-md border border-zinc-200 dark:border-zinc-700 object-cover">
                    <button wire:click="$set('commentImage', null)"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-0.5 shadow hover:bg-red-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                    <!-- Loading Status -->
                    <div wire:loading wire:target="commentImage"
                        class="absolute inset-0 bg-black/50 rounded-md flex items-center justify-center">
                        <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    </div>
                </div>
            @endif

            <div class="flex items-center gap-2">
                <input type="text" x-ref="commentInput" wire:model.live="newComment" wire:keydown.enter="postComment"
                    placeholder="Escreva um comentário..."
                    class="flex-1 bg-transparent border-none border-transparent focus:outline-none focus:ring-0 focus:border-transparent px-3 py-2 text-sm text-zinc-700 dark:text-zinc-200 placeholder-zinc-400">

                <div class="flex items-center justify-center shrink-0 pr-1 gap-1">
                    <input type="file" id="commentImage-{{ class_basename($item) }}-{{ $item->id }}"
                        wire:model="commentImage" class="hidden" accept="image/*">
                    <label for="commentImage-{{ class_basename($item) }}-{{ $item->id }}"
                        class="cursor-pointer text-zinc-500 hover:text-brand-500 transition-colors p-1.5 rounded-full hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"
                        title="Adicionar imagem">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </label>

                    <button wire:click="postComment"
                        class="text-zinc-500 hover:text-brand-500 transition-colors p-1.5 rounded-full hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center"
                        title="Enviar comentário">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            @error('newComment') <span class="text-red-500 text-xs mt-1 block px-2">{{ $message }}</span> @enderror
            @error('commentImage') <span class="text-red-500 text-xs mt-1 block px-2">{{ $message }}</span> @enderror

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