<nav aria-label="breadcrumb" class="bg-body-secondary rounded p-2 ">
    <ol class="breadcrumb my-0">
        @foreach ($items as $item)
            @if (!$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['label'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
