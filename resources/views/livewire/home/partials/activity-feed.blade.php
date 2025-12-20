<div class="space-y-6">
    <!-- Feed Items -->
    @forelse($activities as $activity)
        <div x-data="{ 
                showComments: false, 
                showMentions: false,
                mentionQuery: '',
                users: {{ Js::from($mentionableUsers) }},
                get filteredUsers() {
                    if (this.mentionQuery === '') return this.users;
                    return this.users.filter(u => u.name.toLowerCase().includes(this.mentionQuery.toLowerCase()));
                },
                checkMention(e) {
                    const input = e.target;
                    const cursorPosition = input.selectionStart;
                    const textBeforeCursor = input.value.substring(0, cursorPosition);
                    const words = textBeforeCursor.split(/\s+/);
                    const lastWord = words[words.length - 1];

                    if (lastWord.startsWith('@')) {
                        this.showMentions = true;
                        this.mentionQuery = lastWord.substring(1);
                    } else {
                        this.showMentions = false;
                    }
                },
                selectUser(user) {
                    const input = $refs['commentInput_' + {{ $activity->id }}];
                    const cursorPosition = input.selectionStart;
                    const textBeforeCursor = input.value.substring(0, cursorPosition);
                    const words = textBeforeCursor.split(/\s+/);
                    words.pop(); // Remove the partial @mention to replace with full handle
                    
                    const newTextBefore = words.join(' ') + (words.length > 0 ? ' ' : '') + '@' + user.name + ' ';
                    const textAfterCursor = input.value.substring(cursorPosition);
                    
                    // Set Livewire model
                    $wire.set('newComment.{{ $activity->id }}', newTextBefore + textAfterCursor);
                    
                    this.showMentions = false;
                    setTimeout(() => {
                        input.focus();
                        input.setSelectionRange(newTextBefore.length, newTextBefore.length);
                    }, 50);
                }
             }"
             class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
            
            <!-- Header -->
            <div class="p-4 flex items-start justify-between">
                <div class="flex gap-3">
                    <a href="{{ route('profile.view', $activity->user) }}">
                        <img src="{{ $activity->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($activity->user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            class="w-10 h-10 rounded-full object-cover border border-zinc-100 dark:border-zinc-800 hover:ring-2 hover:ring-brand-500 transition-all cursor-pointer">
                    </a>
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white flex items-center gap-1">
                            <a href="{{ route('profile.view', $activity->user) }}" class="hover:text-brand-600 transition-colors cursor-pointer">
                                {{ $activity->user->name }}
                            </a>
                            @if(!empty($activity->tagged_users))
                                <span class="font-normal text-zinc-500 dark:text-zinc-400">está com</span>
                                @foreach($activity->tagged_users as $tagged)
                                    <span class="font-bold cursor-pointer hover:underline">{{ $tagged['name'] ?? 'Amigo' }}</span>{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            @endif
                        </h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            {{ $activity->start_time ? $activity->start_time->format('d \d\e M \d\e Y \à\s H:i') : $activity->created_at->diffForHumans() }} · Mere App
                        </p>
                    </div>
                </div>
                <!-- ... (Keep existing options button) -->
            </div>

            <!-- Title & Description -->
            <div class="px-4 pb-2 flex gap-3">
                <div class="shrink-0 mt-1">
                    @if($activity->sport_type == 'run')
                         <img src="https://cdn-icons-png.flaticon.com/512/55/55239.png" class="w-6 h-6 opacity-60 dark:invert" alt="Run">
                    @elseif($activity->sport_type == 'bike')
                         <img src="https://cdn-icons-png.flaticon.com/512/2972/2972185.png" class="w-6 h-6 opacity-60 dark:invert" alt="Bike">
                    @else
                         <img src="https://cdn-icons-png.flaticon.com/512/2928/2928158.png" class="w-6 h-6 opacity-60 dark:invert" alt="Activity">
                    @endif
                </div>
                <div class="flex flex-col">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white leading-tight">{{ $activity->title }}</h3>
                    @if($activity->description)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 whitespace-pre-line">{{ $activity->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Media Content (Map + Images/Videos) -->
            <div class="px-4 pb-4 mt-2">
                <!-- Map (If exists) -->
                @if(!empty($activity->polylines))
                <div class="w-full h-48 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden relative mb-2">
                    <iframe
                        width="100%" height="100%" frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/view?key={{ config('services.google.maps_key') }}&center=-15.601,-56.097&zoom=14" allowfullscreen>
                    </iframe>
                </div>
                @endif
                
                <!-- Media Grid -->
                @if(!empty($activity->media))
                    @php 
                        $mediaCount = count($activity->media);
                        $gridClass = $mediaCount == 1 ? 'grid-cols-1' : ($mediaCount == 2 ? 'grid-cols-2' : 'grid-cols-3');
                    @endphp
                    <div class="grid {{ $gridClass }} gap-2 mt-2">
                        @foreach($activity->media as $mediaUrl)
                            <div class="h-48 rounded-lg overflow-hidden bg-zinc-100 relative group cursor-pointer aspect-video">
                                @if(str_contains($mediaUrl, '.mp4'))
                                    <video src="{{ $mediaUrl }}" controls class="w-full h-full object-cover"></video>
                                @else
                                    <img src="{{ $mediaUrl }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Stats Grid -->
                <!-- ... (Keep stats grid same as before) ... -->
                <div class="flex justify-center mt-4 mb-2">
                    <div class="flex gap-8 text-center divide-x divide-zinc-200 dark:divide-zinc-700">
                        <div class="px-4 first:pl-0">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Distância</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">{{ number_format($activity->distance / 1000, 2, ',', '.') }} km</span>
                        </div>
                        <div class="px-4">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Ritmo</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">
                                @php
                                    $pace = $activity->distance > 0 ? ($activity->duration / 60) / ($activity->distance / 1000) : 0;
                                    $paceMin = floor($pace);
                                    $paceSec = round(($pace - $paceMin) * 60);
                                @endphp
                                {{ $paceMin }}:{{ str_pad($paceSec, 2, '0', STR_PAD_LEFT) }} /km
                            </span>
                        </div>
                        <div class="px-4">
                            <span class="block text-xs text-zinc-500 dark:text-zinc-400">Tempo</span>
                            <span class="block text-xl font-medium text-zinc-700 dark:text-zinc-200">
                                {{ gmdate("H:i:s", $activity->duration) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-800/30">
                <div class="flex gap-4">
                    <button wire:click="toggleLike({{ $activity->id }})" 
                        class="flex items-center gap-1.5 text-sm font-medium transition-colors {{ $activity->likes->contains('user_id', auth()->id()) ? 'text-brand-600' : 'text-zinc-500 hover:text-brand-600' }}">
                        <svg class="w-5 h-5" fill="{{ $activity->likes->contains('user_id', auth()->id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                        <span>{{ $activity->likes->count() }}</span>
                    </button>
                    <button @click="showComments = !showComments" class="flex items-center gap-1.5 text-zinc-500 hover:text-brand-600 transition-colors text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        <span>{{ $activity->comments->count() }}</span>
                    </button>
                </div>
            </div>

            <!-- Comment Section -->
            <div x-show="showComments" style="display: none;" x-transition class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/30 dark:bg-zinc-800/20">
                <!-- Activity Item as Child Component -->
                <livewire:home.partials.activity-item :activity="$activity" :key="'activity-'.$activity->id" />
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <p class="text-zinc-500 dark:text-zinc-400">Nenhuma atividade recente.</p>
        </div>
    @endforelse
</div>