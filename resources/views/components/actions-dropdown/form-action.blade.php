@props(['route', 'label', 'icon' => null, 'message' => null, 'method' => 'DELETE'])

<li>
    <form method="POST" action="{{ $route }}">
        {{ csrf_field() }}
        {{ method_field($method) }}
        <button
            type="submit"
            {{ $attributes->merge(['class' => 'dropdown-item']) }}
            @if ($message)
                onclick="return confirm('{{ $message }}')"
            @endif
        >
            @if ($icon)
                <i class="{{ $icon }}"></i>
            @endif
            {{ $label }}
        </button>
    </form>
</li>
