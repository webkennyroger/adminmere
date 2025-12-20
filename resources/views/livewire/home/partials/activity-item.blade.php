<div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-800">
    <!-- Activity Header -->
    <div class="flex justify-between items-start mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.view', $activity->user->id) }}">
                <img src="{{ $activity->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($activity->user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                    class="w-10 h-10 rounded-full border border-zinc-100 dark:border-zinc-800 hover:ring-2 hover:ring-brand-500 transition-all">
            </a>
            <div>
                <a href="{{ route('profile.view', $activity->user->id) }}" class="font-bold text-zinc-900 dark:text-white hover:text-brand-600 hover:underline transition-colors">
                    {{ $activity->user->name }}
                </a>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ $activity->start_time->isoFormat('D [de] MMMM [de] YYYY [às] HH:mm') }} · {{ $activity->app_name ?? 'Garmin' }}
                </p>
            </div>
        </div>
        
        <!-- Activity Icon/Type -->
        <div class="text-zinc-400">
            @if($activity->sport_type === 'run')
                <i class="fas fa-running text-xl"></i>
            @elseif($activity->sport_type === 'ride')
                <i class="fas fa-bicycle text-xl"></i>
            @elseif($activity->sport_type === 'swim')
                <i class="fas fa-swimmer text-xl"></i>
            @else
                <i class="fas fa-dumbbell text-xl"></i>
            @endif
        </div>
    </div>

    <!-- Title and Stats -->
    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">{{ $activity->title }}</h3>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div>
            <p class="text-xs text-zinc-500 uppercase tracking-wider mb-0.5">Distância</p>
            <p class="text-xl font-medium text-zinc-900 dark:text-white">{{ number_format($activity->distance / 1000, 2, ',', '.') }}<span class="text-sm text-zinc-500 ml-1">km</span></p>
        </div>
        <div class="border-l border-zinc-100 dark:border-zinc-800 pl-4">
            <p class="text-xs text-zinc-500 uppercase tracking-wider mb-0.5">Tempo</p>
            <p class="text-xl font-medium text-zinc-900 dark:text-white">
                {{ floor($activity->duration / 3600) }}h {{ floor(($activity->duration % 3600) / 60) }}min
            </p>
        </div>
        <div class="border-l border-zinc-100 dark:border-zinc-800 pl-4">
            <p class="text-xs text-zinc-500 uppercase tracking-wider mb-0.5">Calorias</p>
            <p class="text-xl font-medium text-zinc-900 dark:text-white">{{ number_format($activity->calories, 0, ',', '.') }} <span class="text-sm text-zinc-500 ml-1">kcal</span></p>
        </div>
    </div>

    <!-- Map/Media Placeholder -->
    @if(empty($activity->media))
    <div class="rounded-2xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 mb-6 aspect-video flex items-center justify-center relative group cursor-pointer">
        <!-- Mock Map Background -->
        <div class="absolute inset-0 opacity-50 bg-[url('https://maps.googleapis.com/maps/api/staticmap?center=-23.550520,-46.633308&zoom=13&size=600x300&maptype=roadmap&key=YOUR_API_KEY&style=feature:all|element:all|saturation:-100|visibility:simplified')] bg-cover bg-center"></div>
        <p class="relative z-10 text-zinc-500 text-sm font-medium bg-white/80 dark:bg-black/50 px-3 py-1 rounded-full backdrop-blur-sm">
            Mapa da atividade
        </p>
    </div>
    @else
        <!-- Display Media Logic -->
        <div class="rounded-2xl overflow-hidden mb-6 aspect-video">
             <img src="{{ $activity->media[0] }}" class="w-full h-full object-cover">
        </div>
    @endif

    <!-- Actions Bar -->
    <div class="flex items-center justify-between border-t border-zinc-100 dark:border-zinc-800 pt-4 mt-2">
        <div class="flex gap-4">
            <button wire:click="toggleLike" class="flex items-center gap-2 {{ $activity->likes->contains('user_id', auth()->id()) ? 'text-brand-600' : 'text-zinc-500 hover:text-brand-600' }} transition-colors">
                @if($activity->likes->contains('user_id', auth()->id()))
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                @endif
                <span class="text-sm font-semibold">{{ $activity->likes->count() }}</span>
            </button>
            <button @click="$wire.showComments = !$wire.showComments" class="flex items-center gap-2 text-zinc-500 hover:text-brand-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                <span class="text-sm font-semibold">{{ $activity->comments->count() }}</span>
            </button>
        </div>
    </div>

    <!-- Comments Section -->
    <div x-data="{ showComments: @entangle('showComments') }"
         x-show="showComments" 
         x-transition
         class="border-t border-zinc-100 dark:border-zinc-800 mt-4 pt-4">
        
        <!-- Comments List -->
        <div class="space-y-4 mb-4">
            @foreach($activity->comments as $comment)
            <!-- Only show top level comments -->
            @if(is_null($comment->parent_id))
            <div x-data="{ showReplies: false }" class="group/comment" wire:key="comment-{{ $comment->id }}">
                <!-- Parent Comment -->
                <div class="flex gap-3">
                    <a href="{{ route('profile.view', $comment->user->id) }}">
                        <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            class="w-8 h-8 rounded-full border border-zinc-100 dark:border-zinc-800 shrink-0 hover:ring-2 hover:ring-brand-500 transition-all">
                    </a>
                    <div class="flex-1">
                        <div class="bg-zinc-100 dark:bg-zinc-800 rounded-2xl rounded-tl-none px-4 py-2 inline-block min-w-[200px]">
                            <a href="{{ route('profile.view', $comment->user->id) }}" class="font-bold text-sm text-zinc-900 dark:text-white mb-0.5 hover:text-brand-600 hover:underline transition-colors">
                                {{ $comment->user->name }}
                            </a>
                            <div class="text-sm text-zinc-700 dark:text-zinc-300">{!! $this->formatComment($comment->body) !!}</div>
                        </div>
                        <div class="flex items-center gap-4 mt-1 ml-2 text-xs text-zinc-500 dark:text-zinc-400">
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                            
                            <button
                                @click="$wire.set('replyingToCommentId', {{ $comment->id }}); $refs.commentInput.focus(); $wire.set('newComment', '@' + '{{ $comment->user->name }} ');"
                                class="font-semibold hover:underline">
                                Responder
                            </button>

                            <!-- Comment Likes -->
                            <button wire:click="toggleCommentLike({{ $comment->id }})" class="flex items-center gap-1 hover:text-red-500 {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-red-500' : '' }}">
                                @if($comment->likes->contains('user_id', auth()->id()))
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                @else
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                @endif
                                <span>{{ $comment->likes->count() }}</span>
                            </button>

                            <!-- Delete Comment -->
                            @if(auth()->id() === $comment->user_id || auth()->id() === $activity->user_id)
                                <button 
                                    wire:click="confirmDelete({{ $comment->id }})"
                                    class="opacity-0 group-hover/comment:opacity-100 transition-opacity text-zinc-400 hover:text-red-600"
                                    title="Apagar comentário">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Replies -->
                @if($comment->replies->count() > 0)
                    <div class="ml-11 mt-2">
                        <button @click="showReplies = !showReplies" class="flex items-center gap-2 text-xs text-zinc-500 font-semibold mb-2">
                            <div class="w-6 h-px bg-zinc-300 dark:bg-zinc-700"></div>
                            <span x-text="showReplies ? 'Ocultar respostas' : 'Ver {{ $comment->replies->count() }} resposta(s)'"></span>
                        </button>
                        
                        <div x-show="showReplies" style="display: none;" class="space-y-3">
                            @foreach($comment->replies as $reply)
                            <div class="flex gap-3 group/reply" wire:key="reply-{{ $reply->id }}">
                                <a href="{{ route('profile.view', $reply->user->id) }}">
                                    <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) . '&color=F3E8FF&background=7E22CE' }}"
                                        class="w-6 h-6 rounded-full border border-zinc-100 dark:border-zinc-800 shrink-0 hover:ring-2 hover:ring-brand-500 transition-all">
                                </a>
                                <div class="flex-1">
                                    <div class="bg-zinc-100 dark:bg-zinc-800 rounded-2xl rounded-tl-none px-3 py-1.5 inline-block min-w-[150px]">
                                        <a href="{{ route('profile.view', $reply->user->id) }}" class="font-bold text-xs text-zinc-900 dark:text-white mb-0.5 hover:text-brand-600 hover:underline transition-colors">
                                            {{ $reply->user->name }}
                                        </a>
                                        <div class="text-xs text-zinc-700 dark:text-zinc-300">{!! $this->formatComment($reply->body) !!}</div>
                                    </div>
                                    <div class="flex items-center gap-4 mt-1 ml-2 text-[10px] text-zinc-500 dark:text-zinc-400">
                                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                                        
                                        <!-- Reply to reply handled same as parent for now -->
                                        <button 
                                            @click="$wire.set('replyingToCommentId', {{ $comment->id }}); $refs.commentInput.focus(); $wire.set('newComment', '@' + '{{ $reply->user->name }} ');"
                                            class="font-semibold hover:underline">Responder</button>
                                        
                                        <!-- Reply Likes -->
                                        <button wire:click="toggleCommentLike({{ $reply->id }})" class="flex items-center gap-1 hover:text-red-500 {{ $reply->likes->contains('user_id', auth()->id()) ? 'text-red-500' : '' }}">
                                            @if($reply->likes->contains('user_id', auth()->id()))
                                                <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                            @else
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                            @endif
                                            <span>{{ $reply->likes->count() }}</span>
                                        </button>

                                        <!-- Delete Reply -->
                                        @if(auth()->id() === $reply->user_id || auth()->id() === $activity->user_id)
                                            <button 
                                                wire:click="confirmDelete({{ $reply->id }})"
                                                class="opacity-0 group-hover/reply:opacity-100 transition-opacity text-zinc-400 hover:text-red-600"
                                                title="Apagar resposta">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @endif
            @endforeach
        </div>

        <!-- Input Area with Mentions Dropdown -->
        <div class="flex gap-3 relative">
            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                class="w-8 h-8 rounded-full object-cover border border-zinc-100 dark:border-zinc-800">
            <div class="flex-1 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg flex items-center pr-2 relative">
                <input type="text" 
                    x-ref="commentInput"
                    wire:model.live="newComment"
                    wire:keydown.enter="postComment"
                    placeholder="Adicione um comentário, @ para mencionar"
                    class="bg-transparent border-none w-full text-sm px-3 py-2 focus:ring-0 text-zinc-700 dark:text-zinc-200 placeholder-zinc-400">
                <button wire:click="postComment" class="text-brand-600 font-semibold text-sm hover:text-brand-700 px-2 transition-colors">Enviar</button>
                
                <!-- Mentions Dropdown -->
                <div x-show="showMentions && filteredUsers.length > 0" 
                        style="display: none;"
                        class="absolute bottom-full left-0 mb-2 w-64 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden z-10">
                    <ul>
                        <template x-for="user in filteredUsers" :key="user.id">
                            <li @click="selectUser(user)" 
                                class="flex items-center gap-3 px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-700 cursor-pointer transition-colors">
                                <img :src="user.avatar || 'https://ui-avatars.com/api/?name=' + user.name + '&color=7F9CF5&background=EBF4FF'" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white" x-text="user.name"></p>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal :isOpen="!! $confirmingCommentDeletion" :showCloseButton="false">
        <div class="sm:flex sm:items-start">
            <div class="w-full">
                <x-ui.alert 
                    variant="error" 
                    title="Apagar comentário" 
                    message="Tem certeza que deseja remover este comentário? Esta ação não pode ser desfeita."
                />
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
</div>
