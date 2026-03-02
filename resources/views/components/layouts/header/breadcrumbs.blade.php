<flux:breadcrumbs>
    <flux:breadcrumbs.item :href="route('dashboard')" icon="home" wire:navigate />
    
    @foreach ($breadcrumbs as $item)
        @if (!$loop->last)
            <flux:breadcrumbs.item :href="$item['url']" wire:navigate>
                {{ $item['title'] }}
            </flux:breadcrumbs.item>
        @else
            <flux:breadcrumbs.item>
                {{ $item['title'] }}
            </flux:breadcrumbs.item>
        @endif
    @endforeach
</flux:breadcrumbs>