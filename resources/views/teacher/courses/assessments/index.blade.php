@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @vite('resources/js/sortable.js')
@endpush

<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Evaluaciones') ],
    ]"
>
    <x-course-navbar :$course />

    <div class="card my-3">
        <div class="card-header d-flex gap-3 align-items-center">
            <h2 class="h4 m-0 me-auto">{{ __('Evaluaciones') }}</h2>

            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="sortSwitch">
              <label class="form-check-label" for="sortSwitch">{{ __('Ordenar') }}</label>
            </div>

            <a
                class="btn btn-sm btn-primary"
                href="{{ route('teacher.courses.assessments.create', [$course]) }}"
                title="{{ __('Crear nueva evaluación') }}"
            >
                <i class="bi bi-plus-lg"></i>
                {{ __('Nuevo') }}
            </a>
        </div>

        @if($course->assessments->isEmpty())
            <div class="alert alert-warning m-3">
                {{ __('No hay evaluaciones en este curso.') }}
                <a 
                    href="{{ route('teacher.courses.assessments.create', [$course]) }}" 
                    class="alert-link"
                >
                    {{ __('Agregar evaluación') }}
                </a>.
            </div>
        @else
            <ul id="sortableList" class="list-group list-group-flush">
                @foreach ($course->assessments as $assessment)
                    <li
                        class="list-group-item bg-opacity-25"
                        data-id="{{ $assessment->id }}"
                        data-pos="{{ $assessment->order }}"
                    >
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md" style="position: relative;">
                                <p class="m-0">
                                    <a href="{{ route('teacher.courses.assessments.show', [$course, $assessment]) }}" class="stretched-link">
                                        <span class="lead">{{ $assessment->title }}</span>
                                    </a>
                                    <small class="text-muted fst-italic">{{ __($assessment->grade_type->label()) }}</small>
                                </p>
                                <p class="m-0">
                                    {{ $assessment->description }}
                                </p>
                            </div>
                            <div class="col col-md-auto">
                                <i
                                    class="bi bi-{{ $assessment->type === \App\Enums\AssessmentTypeEnum::Individual ? 'person-fill' : 'people-fill' }}"
                                    title="{{ __($assessment->type->label()) }}"
                                ></i>
                            </div>
                            <div class="col-auto text-md-end">
                                @include('teacher.courses.assessments._item_actions', [$course, $assessment])
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
