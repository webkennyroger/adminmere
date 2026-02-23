<div class="space-y-6">
    @if (session()->has('error'))
        <div class="p-4 bg-red-100 border border-red-200 text-red-700 rounded-2xl shadow-sm mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl shadow-sm mb-4">
            {{ session('message') }}
        </div>
    @endif
    {{-- Card de criar publicação (apenas em feed=timeline) --}}
    @if(isset($feed) && $feed === 'timeline')
        <livewire:posts.create-post :feed-type="$feed" />
    @endif


    {{-- ─── Feed Items ──────────────────────────────────────────────── --}}
    @forelse($items as $item)
        @if($item['type'] === 'post')
            <livewire:home.partials.post-item :post="$item['item']" :key="'post-' . $item['item']->id" />
        @else
            <livewire:home.partials.activity-item :activity="$item['item']" :key="'activity-' . $item['item']->id" />
        @endif
    @empty
        <div class="text-center py-12">
            <p class="text-zinc-500 dark:text-zinc-400">Nenhuma atividade ou publicação recente.</p>
        </div>
    @endforelse

    {{-- Loading / scroll trigger --}}
    @if($hasMore)
        <div x-data="{}" x-intersect="$wire.loadMore()" class="w-full py-12 flex justify-center">
            <div wire:loading class="flex items-center justify-center">
                <div
                    class="bg-white dark:bg-zinc-900 rounded-2xl p-4 shadow-sm border border-zinc-100 dark:border-zinc-800 flex items-center gap-1.5 min-w-[100px]">
                    <div class="w-2.5 h-2.5 bg-brand-600 rounded-full animate-typing" style="animation-delay: 0s"></div>
                    <div class="w-2.5 h-2.5 bg-brand-600 rounded-full animate-typing" style="animation-delay: 0.2s"></div>
                    <div class="w-2.5 h-2.5 bg-brand-600 rounded-full animate-typing" style="animation-delay: 0.4s"></div>
                </div>
            </div>
            <div wire:loading.remove class="h-10"></div>
        </div>
    @endif
</div>