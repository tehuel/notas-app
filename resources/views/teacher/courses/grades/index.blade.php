<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Notas') ],
    ]"
>
    <x-course-navbar :$course />

    <div class="card my-3">
        <div class="card-header d-flex gap-3 align-items-center">
            <h2 class="h4 m-0 me-auto">{{ __('Notas') }}</h2>
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
        @elseif($individualAssessments->isEmpty())
            <div class="alert alert-warning m-3">
                {{ __('No hay evaluaciones en este curso.') }}
                <a
                    href="{{ route('teacher.courses.assessments.create', [$course]) }}"
                    class="alert-link"
                >
                    {{ __('Agregar evaluación') }}
                </a>
            </div>
        @else
            @include('teacher.courses.grades._index_table', [
                'course' => $course,
                'headers' => $headers,
                'rows' => $rows,
                'individualAssessments' => $individualAssessments,
            ])
        @endif
    </div>
</x-layouts.app>
