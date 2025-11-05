@props([
    'headers' => null,
    'rows' => null,
])

<div class="table-responsive">
    <table {{ $attributes->merge(['class' => 'table table-striped m-0']) }}>
        <thead>
            {{ $headers }}
        </thead>
        <tbody>
            {{ $rows }}
        </tbody>
    </table>
</div>
