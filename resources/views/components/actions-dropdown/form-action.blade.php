@props(['route', 'label', 'icon', 'message'])

<li>
    <form method="POST" action="{{ $route }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button
            type="submit"
            {{ $attributes->merge(['class' => 'dropdown-item']) }}
            onclick="return confirm('{{ $message }}')"
        >
            @if ($icon)
                <i class="{{ $icon }}"></i>
            @endif
            {{ $label }}
        </button>
    </form>
</li>
