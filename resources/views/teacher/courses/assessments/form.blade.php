@use(App\Enums\GradeTypeEnum)
@use(App\Enums\AssessmentTypeEnum)
@use(App\Enums\CheckTypeEnum)

<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Evaluaciones'), 'url' => route('teacher.courses.assessments.index', [$course])],
        ['label' => isset($assessment) ? __('Editar Evaluación') : __('Crear Nueva Evaluación')],
    ]"
>
    <x-course-navbar :$course />

    <div class="container" style="max-width: 600px;">
        <h2 class="my-4">
            {{ isset($assessment) ? __('Editar Evaluación') : __('Crear Nueva Evaluación') }}
        </h2>
        <form
            action="{{ isset($assessment) ? route('teacher.courses.assessments.update', [$course, $assessment]) : route('teacher.courses.assessments.store', [$course]) }}"
            method="POST"
        >
            @csrf

            @if(isset($assessment))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">{{ __('Título') }}</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="form-control"
                    value="{{ old('title', $assessment->title ?? '') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{__('Descripción')}}</label>
                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="5"
                >{{ old('description', $assessment->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="grade_type" class="form-label">{{ __('Tipo de Nota') }}</label>

                <ul class="list-group mb-2">
                    @foreach(GradeTypeEnum::cases() as $grade_type)
                        <li class="list-group-item">
                            <label class="d-flex gap-2">
                                <input
                                    class="form-check-input flex-shrink-0"
                                    type="radio"
                                    name="grade_type"
                                    id="grade_type_{{ $grade_type->value }}"
                                    value="{{ $grade_type->value }}"
                                    @if(old('grade_type', $assessment->grade_type ?? '') === $grade_type) checked @endif
                                >
                                <span>
                                    {{ __($grade_type->label()) }}
                                </span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">{{ __('Tipo de Evaluación') }}</label>

                <ul class="list-group">
                    @foreach(AssessmentTypeEnum::cases() as $assessment_type)
                        <li class="list-group-item">
                            <label class="d-flex gap-2">
                                <input
                                    class="form-check-input flex-shrink-0"
                                    type="radio"
                                    name="type"
                                    id="type_{{ $assessment_type->value }}"
                                    value="{{ $assessment_type->value }}"
                                    @if(old('type', $assessment->type ?? '') === $assessment_type) checked @endif
                                >
                                <span>
                                    <i class="{{ $assessment_type->icon() }} me-1"></i>
                                    {{ __($assessment_type->label()) }}
                                </span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Verificaciones Automáticas') }}</label>
                <ul class="list-group">
                    @foreach (CheckTypeEnum::cases() as $checkType)
                        <li class="list-group-item">
                            <div class="row align-items-center g-2">
                                <div class="col-auto">
                                    <input type="hidden" name="checks[{{ $checkType->value }}][enabled]" value="0">
                                    <input
                                        class="form-check-input flex-shrink-0"
                                        type="checkbox"
                                        name="checks[{{ $checkType->value }}][enabled]"
                                        id="check_{{ $checkType->value }}"
                                        value="1"
                                        @if(old('checks.' . $checkType->value . '.enabled', $assessment->checks[$checkType->value]['enabled'] ?? false)) checked @endif
                                    >
                                </div>
                                <div class="col">
                                    <label class="form-check-label flex-shrink-0" for="check_{{ $checkType->value }}">
                                        <i class="bi bi-{{ $checkType->icon() }} me-1"></i>
                                        {{ __($checkType->label()) }}
                                    </label>
                                </div>
                                <div class="col-12 col-sm order-sm-0">
                                    <input
                                        type="text"
                                        name="checks[{{ $checkType->value }}][config]"
                                        class="form-control mt-1"
                                        value="{{ old('checks.' . $checkType->value . '.config', $assessment->checks[$checkType->value]['config'] ?? '') }}"
                                    >
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $submitLabel ?? (isset($assessment) ? __('Actualizar') : __('Crear')) }}
            </button>

            <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">
                {{ __('Cancelar') }}
            </a>
        </form>
    </div>
</x-layouts.app>
