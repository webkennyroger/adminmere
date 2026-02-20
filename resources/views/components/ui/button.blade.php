@props([
    'size' => 'medium',   // 'xs' | 'small' | 'medium' | 'large' | 'xl'
    'iconPosition' => 'left',     // 'left' | 'right'
    'href' => null,       // se informado, renderiza como <a>
    'type' => 'button',   // 'button' | 'submit'
    'color' => 'green',    // 'green' | 'blue' | 'red' | 'orange' | 'zinc'
    'full' => false,      // true = width 100%
    'disabled' => false,
])
@php
    $classes = implode(' ', array_filter([
        'btn-mere',
        "btn-{$size}",
        "btn-{$color}",
        $iconPosition === 'right' ? 'icon-right' : '',
        $full ? 'full-width' : '',
    ]));
@endphp
@if($href)
    <a
        href="{{ $disabled ? '#' : $href }}"
        class="{{ $classes }}"
            @if($disabled) aria-disabled="true" style="pointer-events:none;opacity:.5;" @endif
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
