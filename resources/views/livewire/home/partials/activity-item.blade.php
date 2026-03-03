<div x-data="{ showMenu: false }"
    class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
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

        <div class="flex items-center gap-2">
            <!-- Bookmark Button -->
            <button wire:click="toggleSave"
                class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full transition-colors group">
                @if($activity->savedItems->contains('user_id', auth()->id()))
                    <svg class="w-5 h-5 text-yellow-500 fill-current" viewBox="0 0 24 24">
                        <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z" />
                    </svg>
                @else
                    <svg class="w-5 h-5 text-zinc-500 group-hover:text-yellow-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3-7 3V5z" />
                    </svg>
                @endif
            </button>

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

        @php
            $polylines = $activity->polylines;
            $mapData = ['type' => 'none', 'data' => null];

            if ($polylines) {
                if (isset($polylines['summary_polyline']) && !empty($polylines['summary_polyline'])) {
                    $mapData = ['type' => 'encoded', 'data' => $polylines['summary_polyline']];
                } elseif (isset($polylines['points']) && is_array($polylines['points']) && count($polylines['points']) > 0) {
                    $mapData = ['type' => 'points', 'data' => collect($polylines['points'])->take(100)->values()->all()];
                } elseif (is_array($polylines) && isset($polylines[0]['lat'])) {
                    $mapData = ['type' => 'points', 'data' => collect($polylines)->take(100)->values()->all()];
                } elseif (is_string($polylines) && !empty($polylines)) {
                    $mapData = ['type' => 'encoded', 'data' => $polylines];
                }
            }

            $locationStr = $activity->location ?? '';
        @endphp

        {{-- MAP: show when GPS track exists --}}
        @if($mapData['type'] !== 'none')
            <div class="w-full aspect-video bg-zinc-100 dark:bg-zinc-800 relative overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700"
                x-data="activityMap(@js($mapData))" x-intersect.once="initMap()">
                <div x-ref="mapContainer" class="w-full h-full z-10"></div>
                <div x-show="!loaded"
                    class="absolute inset-0 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 z-10">
                    <div class="w-6 h-6 border-2 border-brand-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
        @elseif(!empty($locationStr))
            {{-- Fallback: geocode city/address via free Nominatim API --}}
            <div class="w-full aspect-video bg-zinc-100 dark:bg-zinc-800 relative overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700"
                x-data="activityMap({type: 'geocode', data: @js($locationStr)})" x-intersect.once="initMap()">
                <div x-ref="mapContainer" class="w-full h-full z-10"></div>
                <div x-show="!loaded"
                    class="absolute inset-0 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 z-10">
                    <div class="w-6 h-6 border-2 border-brand-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
        @endif

        {{-- MEDIA GRID --}}
        @if($mediaCount > 0)
            @if($mediaCount === 1)
                <div class="w-full aspect-4/5 bg-zinc-100 dark:bg-zinc-800 relative">
                    @if(str_contains($mediaItems[0], '.mp4'))
                        <video src="{{ $mediaItems[0] }}" controls class="w-full h-full object-cover"></video>
                    @else
                        <img src="{{ $mediaItems[0] }}"
                            class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity" alt="Post image"
                            x-on:click='$dispatch("open-lightbox", { images: @json($mediaItems), index: 0 })'>
                    @endif
                </div>
            @elseif($mediaCount === 2)
                <div class="grid grid-cols-2 gap-0.5">
                    @foreach($mediaItems as $media)
                        <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 relative">
                            @if(str_contains($media, '.mp4'))
                                <video src="{{ $media }}" controls class="w-full h-full object-cover"></video>
                            @else
                                <img src="{{ $media }}"
                                    class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                    alt="Post image"
                                    x-on:click='$dispatch("open-lightbox", { images: @json($mediaItems), index: $index })'>
                            @endif
                        </div>
                    @endforeach
                </div>
            @elseif($mediaCount === 3)
                <div class="grid grid-cols-2 gap-0.5">
                    <div class="row-span-2 aspect-square bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ $mediaItems[0] }}"
                            class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity"
                            alt="Post image" x-on:click='$dispatch("open-lightbox", { images: @json($mediaItems), index: 0 })'>
                    </div>
                    <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ $mediaItems[1] }}"
                            class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity"
                            alt="Post image" x-on:click='$dispatch("open-lightbox", { images: @json($mediaItems), index: 1 })'>
                    </div>
                    <div class="aspect-square bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ $mediaItems[2] }}"
                            class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity"
                            alt="Post image" x-on:click='$dispatch("open-lightbox", { images: @json($mediaItems), index: 2 })'>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-2 gap-0.5">
                    @foreach($mediaItems as $index => $media)
                        @if($index < 4)
                            <div class="aspect-square bg-zinc-100 dark:bg-zinc-800 relative">
                                <img src="{{ $media }}"
                                    class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                    alt="Post image"
                                    x-on:click='$dispatch("open-lightbox", { images: @json($mediaItems), index: $index })'>
                                @if($index === 3 && $mediaCount > 4)
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center cursor-pointer hover:bg-black/70 transition-colors"
                                        x-on:click='$dispatch("open-lightbox", { images: @json($mediaItems), index: 3 })'>
                                        <span class="text-white text-3xl font-bold">+{{ $mediaCount - 4 }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif

        <!-- Activity Stats (if sports activity) -->
        <div class="px-4 py-3 border-t border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center justify-around text-center">
                <div>
                    <p class="text-lg font-bold text-zinc-900 dark:text-white">
                        {{ number_format(($activity->distance ?? 0) / 1000, 2, ',', '.') }}
                    </p>
                    <p class="text-[10px] uppercase font-bold tracking-wider text-zinc-500 dark:text-zinc-400">Distância
                    </p>
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
                    <p class="text-[10px] uppercase font-bold tracking-wider text-zinc-500 dark:text-zinc-400">Calorias
                    </p>
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
                            <svg class="w-6 h-6 text-green-500 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-zinc-500 group-hover:text-green-500 transition-colors" fill="none"
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
    </div>

    @include('livewire.home.partials._comment_section', ['item' => $activity])
    @include('livewire.home.partials._delete_comment_modal', ['item' => $activity])

    <!-- Edit Activity Modal -->
    <x-ui.modal wire:model="editingActivity" :showCloseButton="true" wire:key="edit-activity-modal-{{ $activity->id }}"
        :maxWidth="'sm:max-w-lg'">
        <div class="p-4 sm:p-10 text-center">
            <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200 ">Editar Atividade</h3>

            <div class="mt-8 space-y-4 text-left">
                <!-- Title Input -->
                <div
                    class="border border-gray-200 dark:border-neutral-700 rounded-xl p-3 px-4 focus-within:border-blue-500 transition-colors">
                    <label
                        class="block text-[11px] font-bold text-gray-500 dark:text-neutral-400 uppercase tracking-widest mb-1 ">TÍTULO</label>
                    <input type="text" wire:model="editTitle"
                        class="w-full bg-transparent border-none p-0 text-[15px] text-gray-800 dark:text-neutral-200 focus:ring-0 focus:outline-none placeholder-gray-400  shadow-none"
                        placeholder="Insira o título da atividade">
                </div>
                @error('editTitle') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

                <div
                    class="border border-gray-200 dark:border-neutral-700 rounded-xl p-3 px-4 focus-within:border-blue-500 transition-colors">
                    <label
                        class="block text-[11px] font-bold text-gray-500 dark:text-neutral-400 uppercase tracking-widest mb-1 ">DESCRIÇÃO</label>
                    <textarea wire:model="editContent" rows="4"
                        class="w-full bg-transparent border-none p-0 text-[15px] text-gray-800 dark:text-neutral-200 focus:ring-0 focus:outline-none shadow-none placeholder-gray-400 resize-none "
                        placeholder="Detalhes da atividade..."></textarea>
                </div>
                @error('editContent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

                <!-- Existing Media Management -->
                @if(count($activity->media ?? []) > 0)
                    <div class="space-y-2">
                        <label
                            class="block text-[11px] font-bold text-gray-500 dark:text-neutral-400 uppercase tracking-widest">MÍDIA
                            ATUAL (CLIQUE PARA REMOVER)</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($activity->media as $media)
                                @if(!in_array($media, $mediaToRemove))
                                    <div
                                        class="relative aspect-square rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-zinc-100 group">
                                        @if(str_contains($media, '.mp4'))
                                            <video src="{{ $media }}" class="w-full h-full object-cover"></video>
                                        @else
                                            <img src="{{ $media }}" class="w-full h-full object-cover">
                                        @endif
                                        <button wire:click="removeExistingMedia('{{ $media }}')"
                                            class="absolute top-1 right-1 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Media Uploads (Edit Activity) -->
                <div class="space-y-3">
                    <label
                        class="block text-[11px] font-bold text-gray-500 dark:text-neutral-400 uppercase tracking-widest">ADICIONAR
                        MÍDIA</label>
                    <div class="flex gap-4">
                        <label class="cursor-pointer flex-1">
                            <div
                                class="border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-xl p-4 flex flex-col items-center gap-1 hover:border-brand-500 transition-colors">
                                <svg class="w-6 h-6 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] text-zinc-500">Fotos</span>
                            </div>
                            <input type="file" wire:model="editPhotos" class="hidden" multiple accept="image/*">
                        </label>
                        <label class="cursor-pointer flex-1">
                            <div
                                class="border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-xl p-4 flex flex-col items-center gap-1 hover:border-brand-500 transition-colors">
                                <svg class="w-6 h-6 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M4 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8z" />
                                </svg>
                                <span class="text-[10px] text-zinc-500">Vídeos</span>
                            </div>
                            <input type="file" wire:model="editVideos" class="hidden" multiple accept="video/*">
                        </label>
                    </div>

                    {{-- Previews --}}
                    @if(count($editPhotos) > 0 || count($editVideos) > 0)
                        <div class="grid grid-cols-4 gap-2 mt-2">
                            @foreach($editPhotos as $photo)
                                <div
                                    class="aspect-square rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                            @foreach($editVideos as $video)
                                <div
                                    class="aspect-square rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 bg-black flex items-center justify-center">
                                    @if($video && method_exists($video, 'temporaryUrl'))
                                        <video src="{{ $video->temporaryUrl() }}" class="w-full h-full object-cover"></video>
                                    @else
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center">
            <button type="button" wire:click="cancelEditingActivity"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-es-xl border border-transparent bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 focus:outline-hidden disabled:opacity-50 transition-all ">
                Cancelar
            </button>
            <button type="button" wire:click="updateActivity"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-ee-xl bg-brand-600 border border-transparent text-white hover:bg-brand-700 focus:outline-hidden disabled:opacity-50 transition-all ">
                Salvar Atividade
            </button>
        </div>
    </x-ui.modal>

    <!-- Delete Activity Confirmation Modal -->
    <x-ui.modal wire:model="confirmingActivityDeletion" :maxWidth="'sm:max-w-lg'" :showCloseButton="false"
        wire:key="delete-activity-modal-{{ $activity->id }}">
        <div class="p-4 sm:p-14 text-center overflow-y-auto">
            <div
                class="mx-auto flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/20 mb-4">
                <svg class="h-6 w-6 text-[#E60000]" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-neutral-200 ">
                Apagar Atividade
            </h3>
            <p class="text-gray-500 dark:text-neutral-400 ">
                Tem certeza que deseja remover esta atividade? Esta ação não pode ser desfeita e todos os comentários e
                curtidas serão perdidos.
            </p>
        </div>

        <div class="flex items-center">
            <button type="button" @click="showMenu = false; $wire.cancelDeleteActivity()"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-es-xl border border-transparent bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 focus:outline-hidden disabled:opacity-50 transition-all ">
                Cancelar
            </button>
            <button type="button" wire:click="deleteActivity"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-ee-xl  border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                Apagar
            </button>
        </div>
    </x-ui.modal>
</div>