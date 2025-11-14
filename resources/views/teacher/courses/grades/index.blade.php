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

        @if($students->isEmpty())
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
        @elseif($assessments->isEmpty())
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
            <x-table>
                <x-slot:headers>
                    <tr>
                        <th scope="col">
                            {{ __('Alumno') }}
                        </th>
                        @foreach ($assessments as $assessment)
                            <th scope="col" class="text-center">
                                <i
                                    class="{{ $assessment->grade_type->icon() }}"
                                    title="{{ __($assessment->grade_type->label()) }}"
                                ></i>
                                <a
                                    href="{{ route('teacher.courses.assessments.show', [$course, $assessment]) }}"
                                    title="{{ __('Ver evaluación') }}"
                                    class="text-decoration-none"
                                >
                                    {{ $assessment->title }}
                                </a>
                            </th>
                        @endforeach
                    </tr>
                </x-slot:headers>

                <x-slot:rows>
                    @foreach ($students as $student)
                        <tr>
                            <th
                                scope="row"
                                class="align-middle"
                            >
                                <a
                                    href="{{ route('teacher.courses.students.show', [ 'course' => $course, 'student' => $student ]) }}"
                                    title="{{ __('Ver perfil del alumno') }}"
                                    class="text-decoration-none"
                                >
                                    {{ $student->name }}
                                </a>
                            </th>

                            @foreach ($assessments as $assessment)
                                <td class="align-middle text-center" style="min-width: 160px;">
                                    @php
                                        // get grade keyed by "gradable_id-assessment_id"
                                        $gradeKey = $student->id . '-' . $assessment->id;
                                        $grade = $grades[$gradeKey] ?? null;
                                    @endphp

                                    <x-grade-label :grade="$grade" />

                                    @include('teacher.courses.grades._grade_actions', [
                                        'course' => $course,
                                        'assessment' => $assessment,
                                        'gradeable' => $student,
                                    ])
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-table>
        @endif
    </div>
</x-layouts.app>
