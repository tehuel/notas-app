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
        <div class="card-header">
            <div class="row g-2">
                <div class="col-12 col-sm">
                    <h2 class="h4 m-0 me-auto">{{ __('Evaluaciones') }}</h2>
                </div>
                <div class="col-12 col-sm-auto d-flex flex-wrap gap-2 align-items-center">
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
            </div>
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
                            <div class="col-auto">
                                <i
                                    class="{{ $assessment->type->icon() }} me-2"
                                    title="{{ __($assessment->type->label()) }}"
                                ></i>
                                <i 
                                    class="{{ $assessment->grade_type->icon() }}"
                                    title="{{ __($assessment->grade_type->label()) }}"
                                ></i>
                            </div>

                            <div class="col text-truncate" style="position: relative;">
                                <p class="mb-0 text-truncate">
                                    <a
                                        href="{{ route('teacher.courses.assessments.show', [$course, $assessment]) }}"
                                        class="text-decoration-none stretched-link"
                                    >
                                        {{ $assessment->title }}
                                    </a>
                                    <span class="text-muted mb-0">
                                        {{ $assessment->description }}
                                    </span>
                                </p>
                            </div>

                            <!-- Actions dropdown -->
                            <div class="col-auto">
                                <button
                                    class="btn btn-sm rounded-circle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    aria-label="{{ __('Acciones') }}"
                                >
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a
                                            href="{{ route('teacher.courses.assessments.edit', [$course, $assessment]) }}"
                                            class="dropdown-item"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            {{ __('Editar') }}
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('teacher.courses.assessments.destroy', [$course, $assessment]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button
                                                type="submit"
                                                class="dropdown-item text-danger"
                                                onclick="return confirm('{{ __('¿Estás seguro de eliminar esta evaluación?') }}')"
                                            >
                                                <i class="bi bi-trash"></i>
                                                {{ __('Eliminar') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
