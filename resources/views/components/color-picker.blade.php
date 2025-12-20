@props(['color', 'colorCode'])

@php
    $ringColorClass = match ($colorCode) {
        'red' => 'ring-red-500',
        'orange' => 'ring-orange-500',
        'amber' => 'ring-amber-500',
        'yellow' => 'ring-yellow-500',
        'lime' => 'ring-lime-500',
        'green' => 'ring-green-500',
        'emerald' => 'ring-emerald-500',
        'teal' => 'ring-teal-500',
        'cyan' => 'ring-cyan-500',
        'sky' => 'ring-sky-500',
        'blue' => 'ring-blue-500',
        'indigo' => 'ring-indigo-500',
        'violet' => 'ring-violet-500',
        'purple' => 'ring-purple-500',
        'fuchsia' => 'ring-fuchsia-500',
        'pink' => 'ring-pink-500',
        'rose' => 'ring-rose-500',
        default => 'ring-zinc-500',
    };

    $bgColorClass = match ($colorCode) {
        'red' => 'bg-red-500',
        'orange' => 'bg-orange-500',
        'amber' => 'bg-amber-500',
        'yellow' => 'bg-yellow-500',
        'lime' => 'bg-lime-500',
        'green' => 'bg-green-500',
        'emerald' => 'bg-emerald-500',
        'teal' => 'bg-teal-500',
        'cyan' => 'bg-cyan-500',
        'sky' => 'bg-sky-500',
        'blue' => 'bg-blue-500',
        'indigo' => 'bg-indigo-500',
        'violet' => 'bg-violet-500',
        'purple' => 'bg-purple-500',
        'fuchsia' => 'bg-fuchsia-500',
        'pink' => 'bg-pink-500',
        'rose' => 'bg-rose-500',
        default => 'bg-zinc-500',
    };

    $hoverRingColorClass = match ($colorCode) {
        'red' => 'hover:ring-red-500',
        'orange' => 'hover:ring-orange-500',
        'amber' => 'hover:ring-amber-500',
        'yellow' => 'hover:ring-yellow-500',
        'lime' => 'hover:ring-lime-500',
        'green' => 'hover:ring-green-500',
        'emerald' => 'hover:ring-emerald-500',
        'teal' => 'hover:ring-teal-500',
        'cyan' => 'hover:ring-cyan-500',
        'sky' => 'hover:ring-sky-500',
        'blue' => 'hover:ring-blue-500',
        'indigo' => 'hover:ring-indigo-500',
        'violet' => 'hover:ring-violet-500',
        'purple' => 'hover:ring-purple-500',
        'fuchsia' => 'hover:ring-fuchsia-500',
        'pink' => 'hover:ring-pink-500',
        'rose' => 'hover:ring-rose-500',
        default => 'hover:ring-zinc-500',
    };
@endphp

<div
    @class([
        'w-10 h-10 rounded-full transition-all duration-200',
        $bgColorClass,
        'ring-2 ring-offset-2 ring-offset-white dark:ring-offset-zinc-800 scale-110' => $color === $colorCode,
        $ringColorClass => $color === $colorCode,
        'hover:ring-2 hover:ring-offset-2 hover:ring-offset-white dark:hover:ring-offset-zinc-800 hover:scale-110' => $color !== $colorCode,
        $hoverRingColorClass => $color !== $colorCode,
    ])
>
</div>
