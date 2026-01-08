<div class="relative w-full mb-6">
    <div class="flex gap-4 overflow-x-auto pb-2 no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
        <!-- Add Story Card -->
        <div class="flex-shrink-0 w-32 h-48 relative rounded-xl overflow-hidden cursor-pointer group">
            <div class="absolute inset-0 bg-zinc-800"></div>
            <!-- User Image as Background (blurred or darkened) -->
            <img src="{{ auth()->user()->image_url }}"
                class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-500">

            <div class="absolute inset-0 flex flex-col items-center justify-center pt-8">
                <div
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg mb-2 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="text-white font-medium text-xs mt-8">Add Story</span>
            </div>
        </div>

        <!-- Mock Stories -->
        @php
            $stories = [
                ['name' => 'Victor Exrixon', 'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'user' => 'https://i.pravatar.cc/150?u=1'],
                ['name' => 'Surfiya Zakir', 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'user' => 'https://i.pravatar.cc/150?u=2'],
                ['name' => 'Goria Coast', 'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'user' => 'https://i.pravatar.cc/150?u=3'],
                ['name' => 'Hurin Seary', 'img' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80', 'user' => 'https://i.pravatar.cc/150?u=4'],
            ];
        @endphp

        @foreach($stories as $story)
            <div class="flex-shrink-0 w-32 h-48 relative rounded-xl overflow-hidden cursor-pointer group">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 z-10"></div>
                <img src="{{ $story['img'] }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                <div class="absolute top-3 left-0 right-0 flex justify-center z-20">
                    <div class="w-10 h-10 rounded-full border-2 border-brand-500 p-0.5 bg-white">
                        <img src="{{ $story['user'] }}" class="w-full h-full rounded-full object-cover">
                    </div>
                </div>

                <div class="absolute bottom-3 left-0 right-0 text-center z-20 px-1">
                    <span class="text-white font-medium text-xs truncate block">{{ $story['name'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>