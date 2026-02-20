@props([
    'size'         => 'medium',   // 'large' | 'medium' | 'small'
    'iconPosition' => 'left',     // 'left' | 'right'
    'href'         => null,       // se informado, renderiza como <a>
    'type'         => 'button',   // 'button' | 'submit'
    'color'        => 'green',    // 'green' | 'brand' | 'red' | 'zinc'
    'full'         => false,      // true = width 100%
    'disabled'     => false,
])

@php
    // ── Size specs (matching Button Guide image) ──────────────────────────────
    $sizes = [
        'large'  => ['height' => '48px', 'pl' => '24px', 'pr' => '16px', 'gap' => '10px', 'font' => '15px', 'icon' => '20px', 'radius' => '10px'],
        'medium' => ['height' => '40px', 'pl' => '20px', 'pr' => '16px', 'gap' => '8px',  'font' => '14px', 'icon' => '18px', 'radius' => '8px'],
        'small'  => ['height' => '32px', 'pl' => '18px', 'pr' => '14px', 'gap' => '6px',  'font' => '12px', 'icon' => '16px', 'radius' => '6px'],
    ];

    // ── Color palette ──────────────────────────────────────────────────────────
    $colors = [
        'green' => ['bg' => '#16a34a', 'hover' => '#15803d', 'border' => 'rgba(74,222,128,0.4)',  'shadow' => 'rgba(22,163,74,0.3)',   'text' => '#ffffff', 'icon' => '#fde047'],
        'brand' => ['bg' => '#465fff', 'hover' => '#3641f5', 'border' => 'rgba(99,131,255,0.4)',  'shadow' => 'rgba(70,95,255,0.3)',   'text' => '#ffffff', 'icon' => '#bfdbfe'],
        'red'   => ['bg' => '#ef4444', 'hover' => '#dc2626', 'border' => 'rgba(252,165,165,0.4)', 'shadow' => 'rgba(239,68,68,0.3)',   'text' => '#ffffff', 'icon' => '#fde047'],
        'zinc'  => ['bg' => '#3f3f46', 'hover' => '#27272a', 'border' => 'rgba(161,161,170,0.3)', 'shadow' => 'rgba(63,63,70,0.2)',    'text' => '#ffffff', 'icon' => '#d4d4d8'],
    ];

    $s = $sizes[$size] ?? $sizes['medium'];
    $c = $colors[$color] ?? $colors['green'];

    $direction = $iconPosition === 'right' ? 'row-reverse' : 'row';
    $widthCss  = $full ? 'width: 100%;' : '';
    $opacityCss = $disabled ? 'opacity: 0.5; cursor: not-allowed;' : 'cursor: pointer;';

    $baseStyle = "
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-direction: {$direction};
        gap: {$s['gap']};
        height: {$s['height']};
        padding-left: {$s['pl']};
        padding-right: {$s['pr']};
        {$widthCss}
        background-color: {$c['bg']};
        border-radius: {$s['radius']};
        border: 2px solid {$c['border']};
        box-shadow: 0 4px 15px {$c['shadow']};
        color: {$c['text']};
        font-size: {$s['font']};
        font-weight: 600;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        {$opacityCss}
        transition: transform 0.15s ease, background-color 0.15s ease, box-shadow 0.15s ease;
        white-space: nowrap;
    ";

    $hoverOn  = !$disabled ? "this.style.backgroundColor='{$c['hover']}'; this.style.transform='scale(1.03)'; this.style.boxShadow='0 6px 20px {$c['shadow']}';" : '';
    $hoverOff = !$disabled ? "this.style.backgroundColor='{$c['bg']}'; this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px {$c['shadow']}';" : '';
    $mouseDown = !$disabled ? "this.style.transform='scale(0.97)';" : '';
    $mouseUp   = !$disabled ? "this.style.transform='scale(1.03)';" : '';

    $iconStyle = "width: {$s['icon']}; height: {$s['icon']}; color: {$c['icon']}; flex-shrink: 0; display: flex;";
@endphp

{{-- ── Check if icon slot was provided ──────────────────────────────────────── --}}
@if($href)
    <a
        href="{{ $disabled ? '#' : $href }}"
        style="{{ $baseStyle }}"
        onmouseover="{{ $hoverOn }}"
        onmouseout="{{ $hoverOff }}"
        {{ $attributes }}
    >
        @if (!empty($icon))
            <span style="{{ $iconStyle }}">{{ $icon }}</span>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button
        type="{{ $type }}"
        @if($disabled) disabled @endif
        style="{{ $baseStyle }}"
        onmouseover="{{ $hoverOn }}"
        onmouseout="{{ $hoverOff }}"
        onmousedown="{{ $mouseDown }}"
        onmouseup="{{ $mouseUp }}"
        {{ $attributes }}
    >
        @if (!empty($icon))
            <span style="{{ $iconStyle }}">{{ $icon }}</span>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
