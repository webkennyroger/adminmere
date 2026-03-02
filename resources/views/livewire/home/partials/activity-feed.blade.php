<div class="space-y-6">
 @if (session()->has('error'))
 <div class="p-4 bg-red-100 border border-red-200 text-red-700 shadow-sm mb-4">
 {{ session('error') }}
 </div>
 @endif
 @if (session()->has('message'))
 <div class="p-4 bg-green-100 border border-green-200 text-green-700 shadow-sm mb-4">
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
 <div x-data="{}" x-intersect="$wire.loadMore()" class="w-full py-8 flex justify-center">
 <div wire:loading class="w-full space-y-6">
 {{-- Skeleton Card --}}
 <div
 class="bg-white dark:bg-zinc-900 p-6 shadow-sm border border-zinc-100 dark:border-zinc-800 animate-pulse">
 <div class="flex items-center gap-4 mb-4">
 <div class="w-12 h-12 bg-zinc-200 dark:bg-zinc-800 "></div>
 <div class="flex-1 space-y-2">
 <div class="h-4 bg-zinc-200 dark:bg-zinc-800 w-1/3"></div>
 <div class="h-3 bg-zinc-200 dark:bg-zinc-800 w-1/4"></div>
 </div>
 </div>
 <div class="space-y-3 mb-4">
 <div class="h-4 bg-zinc-200 dark:bg-zinc-800 w-full"></div>
 <div class="h-4 bg-zinc-200 dark:bg-zinc-800 w-5/6"></div>
 </div>
 <div class="h-48 bg-zinc-200 dark:bg-zinc-800 w-full"></div>
 </div>
 </div>
 <div wire:loading.remove class="h-10"></div>
 </div>
 @endif
</div>