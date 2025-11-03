<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Alumnos'), 'url' => route('teacher.courses.students.index', [$course])],
        ['label' => $student->name, 'url' => route('teacher.courses.students.show', [$course, $student])],
        ['label' => __('Historial')],
    ]"
>

    <x-course-navbar :$course />

    <div class="my-3">
        <a
            class="btn btn-sm btn-outline-secondary"
            href="{{ url()->previous() }}"
            title="{{ __('Volver a la página anterior') }}"
        >
            <i class="bi bi-arrow-left"></i>
            {{ __('Volver') }}
        </a>
    </div>

    <div class="card my-3">
        <div class="card-header d-flex align-items-center">
            <h2 class="h4 m-0 me-auto">{{ __('Historial de :evaluacion', ['evaluacion' => $assessment->title]) }}</h2>
        </div>

        <ul class="list-group list-group-flush">
            @forelse ($grades as $grade)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <strong>{{ __('Fecha:') }}</strong> {{ $grade->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-6 col-md-3">
                            <strong>{{ __('Nota:') }}</strong> <x-grade-label :$grade />
                        </div>
                        <div class="col-12 col-md-6">
                            <strong>{{ __('Comentario:') }}</strong> {{ $grade->comment ?? __('N/A') }}
                        </div>
                    </div>
                </li>
            @empty
                <li class="list-group-item">{{ __('Por el momento no hay calificaciones para esta evaluación.') }}</li>
            @endforelse
        </ul>
    </div>

</x-layouts.app>
