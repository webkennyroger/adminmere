@props([
    'title' => null,
    'pageTitle' => null,
    'links' => []
])

@php
    // Support both 'title' and 'pageTitle' props
    $displayTitle = $title ?? $pageTitle ?? 'Page';
    
    // Default breadcrumb structure
    $breadcrumbs = !empty($links) ? $links : [
        ['label' => 'Dashboard', 'url' => url('/dashboard')],
        ['label' => $displayTitle, 'url' => null]
    ];
@endphp

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-zinc-800 dark:text-white/90">
        {{ $displayTitle }}
    </h2>
    <nav>
        <ol class="flex items-center gap-1.5">
            @foreach($breadcrumbs as $index => $breadcrumb)
                <li class="inline-flex items-center gap-1.5">
                    @if($breadcrumb['url'])
                        <a
                            class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300"
                            href="{{ $breadcrumb['url'] }}"
                        >
                            {{ $breadcrumb['label'] }}
                        </a>
                        @if($index < count($breadcrumbs) - 1)
                            <svg
                                class="stroke-current text-zinc-500 dark:text-zinc-400"
                                width="17"
                                height="16"
                                viewBox="0 0 17 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                                    stroke=""
                                    stroke-width="1.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        @endif
                    @else
                        <span class="text-sm text-zinc-800 dark:text-white/90">
                            {{ $breadcrumb['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
