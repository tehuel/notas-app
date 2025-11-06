@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @vite('resources/js/sortable.js')
@endpush

<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Alumnos') ],
    ]"
>
    <x-course-navbar :$course />

    <div class="card my-3">
        <div class="card-header">
            <div class="row g-2">
                <div class="col-12 col-sm">
                    <h2 class="h4 m-0 me-auto">{{ __('Alumnos') }}</h2>
                </div>
                <div class="col-12 col-sm-auto d-flex flex-wrap gap-2 align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="sortSwitch">
                        <label class="form-check-label" for="sortSwitch">{{ __('Ordenar') }}</label>
                    </div>

                    <a
                        class="btn btn-sm btn-primary"
                        href="{{ route('teacher.courses.students.create', [$course]) }}"
                        title="{{ __('Crear nuevo alumno') }}"
                    >
                        <i class="bi bi-plus-lg"></i>
                        {{ __('Nuevo') }}
                    </a>
                    <a
                        class="btn btn-sm btn-secondary"
                        href="{{ route('teacher.courses.students.associate', [$course]) }}"
                        title="{{ __('Asociar alumno existente') }}"
                    >
                        <i class="bi bi-person-check"></i>
                        {{ __('Asociar') }}
                    </a>
                </div>
            </div>
        </div>

        @if($course->students->isEmpty())
            <div class="alert alert-warning m-3">
                {{ __('No hay alumnos en este curso.') }}
                <a 
                    href="{{ route('teacher.courses.students.create', [$course]) }}" 
                    class="alert-link"
                >
                    {{ __('Agregar alumno') }}
                </a> o <a 
                    href="{{ route('teacher.courses.students.associate', [$course]) }}" 
                    class="alert-link"
                >{{ __('Asociar alumnos') }}</a>.
            </div>
        @else
            <ul id="sortableList" class="list-group list-group-flush">
                @foreach ($course->students as $student)
                    <li
                        class="list-group-item bg-opacity-25"
                        data-id="{{ $student->id }}"
                        data-pos="{{ $student->pivot->order }}"
                    >
                        @include('teacher.courses.students._item', ['student' => $student])
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
