@switch($assessment->grade_type)
    @case(\App\Enums\GradeTypeEnum::Numeric)
        <label for="{{ $id }}" class="form-label">{{ __('Valor') }}</label>
        <input
            type="number" 
            class="form-control form-control-sm"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ $grade?->value }}" 
            min="0" 
            max="10" 
            step="1"
        />
        @break
    @case(\App\Enums\GradeTypeEnum::PassFail)
        <input 
            type="radio" 
            class="btn-check"
            name="{{ $name }}"
            id="{{ $id }}-pass"
            autocomplete="off"
            value="pass"
            @if (($grade?->value ?? '') === 'pass') checked @endif
        />
        <label class="btn btn-sm btn-outline-success" for="{{ $id }}-pass">{{ __('Aprobado') }}</label>

        <input
            type="radio" 
            class="btn-check" 
            name="{{ $name }}"
            id="{{ $id }}-fail"
            autocomplete="off"
            value="fail"
            @if (($grade?->value ?? '') === 'fail') checked @endif
        />
        <label class="btn btn-sm btn-outline-danger" for="{{ $id }}-fail">{{ __('Desaprobado') }}</label>
        @break
    @case(\App\Enums\GradeTypeEnum::Semaphore)
        <input 
            type="radio" 
            class="btn-check"
            name="{{ $name }}"
            id="{{ $id }}-satisfactory"
            value="satisfactory"
            @if (($grade?->value ?? '') === 'satisfactory') checked @endif
        />
        <label class="btn btn-sm btn-outline-success" for="{{ $id }}-satisfactory">{{ __('Satisfactorio') }}</label>

        <input 
            type="radio" 
            class="btn-check"
            name="{{ $name }}"
            id="{{ $id }}-warning"
            value="warning"
            @if (($grade?->value ?? '') === 'warning') checked @endif
        />
        <label class="btn btn-sm btn-outline-warning" for="{{ $id }}-warning">{{ __('Advertencia') }}</label>

        <input 
            type="radio" 
            class="btn-check"
            name="{{ $name }}"
            id="{{ $id }}-unsatisfactory"
            value="unsatisfactory"
            @if (($grade?->value ?? '') === 'unsatisfactory') checked @endif
        />
        <label class="btn btn-sm btn-outline-danger" for="{{ $id }}-unsatisfactory">{{ __('Insatisfactorio') }}</label>
        @break
@endswitch
