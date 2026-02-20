@props([
    'size'         => 'medium',   // 'large' | 'medium' | 'small'
    'variant'      => 'primary',  // 'primary' | 'secondary' | 'soft' | 'outline' | 'ghost'
    'iconPosition' => 'left',     // 'left' | 'right'
    'href'         => null,       // se informado, renderiza como <a>
    'type'         => 'button',   // 'button' | 'submit'
    'color'        => 'green',    // 'green' | 'blue' | 'red' | 'orange' | 'zinc'
    'full'         => false,      // true = width 100%
    'disabled'     => false,
])

@php
    // 'secondary' não depende de cor, usa classe própria
    // os outros variants combinam com cor: btn-soft btn-green, btn-outline btn-blue, etc.
    $variantClass = match($variant) {
        'secondary' => 'btn-secondary',
        'soft'      => "btn-soft btn-{$color}",
        'outline'   => "btn-outline btn-{$color}",
        'ghost'     => "btn-ghost btn-{$color}",
        default     => "btn-{$color}",  // primary = só a cor
    };

    $classes = implode(' ', array_filter([
        'btn-mere',
        "btn-{$size}",
        $variantClass,
        $iconPosition === 'right' ? 'icon-right' : '',
        $full ? 'full-width' : '',
    ]));
@endphp

@if($href)
    <a
        href="{{ $disabled ? '#' : $href }}"
        class="{{ $classes }}"
        @if($disabled) aria-disabled="true" tabindex="-1" style="pointer-events:none;opacity:.5;" @endif
        {{ $attributes }}
    >
        @if(!empty($icon))
            <span class="btn-icon">{{ $icon }}</span>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button
        type="{{ $type }}"
        @if($disabled) disabled @endif
        class="{{ $classes }}"
        {{ $attributes }}
    >
        @if(!empty($icon))
            <span class="btn-icon">{{ $icon }}</span>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
