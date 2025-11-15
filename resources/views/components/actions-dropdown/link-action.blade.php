@props(['route', 'label', 'icon' => null])

<li>
    <a
        href="{{ $route }}"
        {{ $attributes->merge(['class' => 'dropdown-item']) }}
    >
        @if ($icon)
            <i class="{{ $icon }}"></i>            
        @endif
        {{ $label }}
    </a>
</li>
