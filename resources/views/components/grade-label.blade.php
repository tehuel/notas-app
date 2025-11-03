<span>
    @if($grade)
        @switch($grade->type)
            @case(\App\Enums\GradeTypeEnum::Numeric)
                @php $gradeColor = $grade->value >= 7 ? 'text-bg-success' : 'text-bg-danger'; @endphp
                <span class="badge mb-1 {{ $gradeColor }}">
                    {{ $grade->value }}
                </span>
                @break
            @case(\App\Enums\GradeTypeEnum::PassFail)
                <span class="badge mb-1 {{ $grade->value === 'pass' ? 'text-bg-success' : 'text-bg-danger' }}">
                    {{ $grade->value === 'pass' ? __('Aprobado') : __('Desaprobado') }}
                </span>
                @break
            @case(\App\Enums\GradeTypeEnum::Semaphore)
                @php
                    $semaphoreColors = [
                        'satisfactory' => 'text-bg-success',
                        'warning' => 'text-bg-warning',
                        'unsatisfactory' => 'text-bg-danger',
                    ];
                    $gradeColor = $semaphoreColors[$grade->value] ?? 'text-bg-secondary';
                @endphp
                <span class="badge mb-1 {{ $gradeColor }}">
                    {{ match ($grade->value) {
                        'satisfactory' => __('Satisfactorio'),
                        'warning' => __('Advertencia'),
                        'unsatisfactory' => __('Insatisfactorio'),
                    } }}
                </span>
                @break
        @endswitch
    @else
        <span class="badge text-bg-secondary mb-1 bg-opacity-25">{{ __('Sin nota') }}</span>
    @endif
</span>