<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Alumnos'), 'url' => route('teacher.courses.students.index', [$course])],
        ['label' => $student->name],
    ]"
>

    <x-course-navbar :$course />

    <!-- Student Details Card -->
    <div class="card my-3">
        <div class="card-header d-flex align-items-center">
            <h2 class="h4 m-0 me-auto">{{ $student->name }}</h2>
            <a
                class="btn btn-sm btn-primary"
                href="{{ route('teacher.courses.students.edit', [$course, $student]) }}"
                title="{{ __('Editar Alumno') }}"
            >
                <i class="bi bi-pencil-square"></i>
                {{ __('Editar') }}
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <p><strong>GitHub:</strong> {{ $student->github_username }}</p>
                    <p class="m-0"><strong>Email:</strong> {{ $student->user->email }}</p>
                </div>
                <div class="col-6">
                    <p>
                        <strong>{{ __('Asistencias') }}:</strong> {{ $attendancesCount }} / {{ $classDaysCount }}
                        <small><span class="text-muted">({{ $classDaysCount > 0 ? round(($attendancesCount / $classDaysCount) * 100, 2) : 0 }}%)</span></small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Evaluación') }}</th>
                    <th>
                        {{ __('Nota') }}
                    </th>
                    <th>{{ __('Comentario') }}</th>
                    <th>{{ __('Acciones') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course->assessments as $assessment)
                    @php
                        $grade = $student->grades->where('assessment_id', $assessment->id)->first();
                    @endphp
                    <tr>
                        <th scope="row">
                            <i class="{{ $assessment->type->icon() }} me-2" title="{{ __($assessment->type->label()) }}"></i>
                            <i class="{{ $assessment->grade_type->icon() }} me-2" title="{{ __($assessment->grade_type->label()) }}"></i>
                            <a
                                href="{{ route('teacher.courses.assessments.show', [$course, $assessment]) }}"
                                title="{{ __('Ver evaluación') }}"
                                class="text-decoration-none"
                            >
                                {{ $assessment->title }}
                            </a>
                        </th>
                        <td><x-grade-label :$grade /></td>
                        <td>{{ $grade?->comment ?? '' }}</td>
                        <td>
                            @include('teacher.courses.grades._grade_actions', [
                                'course' => $course,
                                'assessment' => $assessment,
                                'gradeable' => $student,
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
