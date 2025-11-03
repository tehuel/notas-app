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
                </a>.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped m-0">
                    <thead>
                        <tr>
                            <th scope="col" style="min-width: 150px;">{{ __('Alumno') }}</th>
                            @foreach ($individualAssessments as $assessment)
                                <th scope="col">
                                    <a
                                        class="text-decoration-none"
                                        href="{{ route('teacher.courses.assessments.show', [$course, $assessment]) }}"
                                        title="{{ __('Ver evaluación') }}"
                                    >
                                        {{ $assessment->title }}
                                    </a>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    @foreach ($course->students as $student)
                        <tr>
                            <th scope="row">
                                <a
                                    class="text-decoration-none text-nowrap"
                                    href="{{ route('teacher.courses.students.show', [$course, $student]) }}"
                                    title="{{ __('Ver alumno') }}"
                                >
                                    {{ $student->name }}
                                </a>
                            </th>
                            @foreach($individualAssessments as $assessment)
                                @php
                                    $grade = $student->grades->firstWhere('assessment_id', $assessment->id);
                                @endphp
                                <td style="width: 250px;">
                                    <div class="d-flex gap-2 align-items-center justify-content-between">
                                        <x-grade-label :$grade />
                                        @include('teacher.courses.grades._grade_modal', [
                                            'gradeable' => $student,
                                            'assessment' => $assessment,
                                        ])
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

    </div>
</x-layouts.app>
