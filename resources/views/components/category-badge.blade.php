@props(['color' => 'zinc'])

@php
$colorClasses = match ($color) {
    'red' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
    'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
    'amber' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300',
    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
    'lime' => 'bg-lime-100 text-lime-800 dark:bg-lime-900/50 dark:text-lime-300',
    'green' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
    'emerald' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300',
    'teal' => 'bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300',
    'cyan' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/50 dark:text-cyan-300',
    'sky' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/50 dark:text-sky-300',
    'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
    'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300',
    'violet' => 'bg-violet-100 text-violet-800 dark:bg-violet-900/50 dark:text-violet-300',
    'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
    'fuchsia' => 'bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900/50 dark:text-fuchsia-300',
    'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/50 dark:text-pink-300',
    'rose' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300',
    default => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-900/50 dark:text-zinc-300',
};
@endphp

<span {{ $attributes->class([
    'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
    $colorClasses,
]) }}>
    {{ $slot }}
</span>
