@props(['route', 'label', 'icon'])

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
