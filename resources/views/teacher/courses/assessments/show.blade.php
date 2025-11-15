<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Evaluaciones'), 'url' => route('teacher.courses.assessments.index', [$course])],
        ['label' => $assessment->title],
    ]"
>
    <x-course-navbar :$course />

    <div class="card mb-5">
        <!-- Assessment Header -->
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <h2 class="h4 m-0 me-auto">{{ $assessment->title }}</h2>
            </div>
            <a
                class="btn btn-sm btn-primary"
                href="{{ route('teacher.courses.assessments.edit', [$course, $assessment]) }}"
                title="{{ __('Editar Evaluación') }}"
            >
                <i class="bi bi-pencil-square"></i>
                {{ __('Editar') }}
            </a>
        </div>

        <!-- Assessment Details -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="m-0">
                        <strong>{{ __('Nota:') }}</strong>
                        <i 
                            class="{{ $assessment->grade_type->icon() }}" 
                            title="{{ __($assessment->grade_type->label()) }}"
                        ></i>
                        {{ __($assessment->grade_type->label()) }}
                    </p>
                    <p class="m-0">
                        <strong>{{ __('Tipo:') }}</strong>
                        <i
                            class="{{ $assessment->type->icon() }}" 
                            title="{{ __($assessment->type->label()) }}"
                        ></i>
                        {{ __($assessment->type->label()) }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="m-0">
                        <strong>{{ __('Verificaciones:') }}</strong>
                        @if (empty($assessment->checks))
                            <span class="text-muted fst-italic"><small>{{ __('Ninguna') }}</small></span>
                        @else
                            <ul class="mb-0">
                                @foreach ($assessment->checks as $checkKey => $checkData)
                                    @php
                                        $checkType = \App\Enums\CheckTypeEnum::tryFrom($checkKey);
                                        $enabled = $checkData['enabled'] ?? false;
                                        if (!$checkType) continue;
                                    @endphp
                                    @if ($enabled)
                                        <li class="mb-1">
                                            <i
                                                class="{{ $checkType->icon() }}"
                                                title="{{ __($checkType->label()) }}"
                                            ></i>
                                            {{ __($checkType->label()) }}
                                            @if ($checkType->requiresConfig() && !empty($checkData['config']))
                                                <code>{{ $checkData['config'] }}</code>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Assessment Description -->
        <div class="card-body border-top">
            @if ($assessment->description)
                {{ $assessment->description }}
            @else
                <span class="text-muted fst-italic"><small>{{ __('Sin descripción') }}</small></span>
            @endif
        </div>
    </div>

    @switch($assessment->type)
        @case(\App\Enums\AssessmentTypeEnum::Individual)
            <h2 class="h4">{{ __('Notas de Estudiantes') }}</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Alumno') }}</th>
                            <th scope="col">
                                {{ __('Nota') }}
                                <i
                                    class="{{ $assessment->grade_type->icon() }} me-2" 
                                    title="{{ __($assessment->grade_type->label()) }}"
                                ></i>
                            </th>
                            <th scope="col">{{ __('Comentario') }}</th>
                            <th scope="col">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($assessment->course->students as $student)
                        @php
                            $grade = $student->grades->first();
                        @endphp
                        <tr>
                            <th scope="row">
                                <a
                                    href="{{ route('teacher.courses.students.show', [ 'course' => $course, 'student' => $student ]) }}"
                                    title="{{ __('Ver perfil del alumno') }}"
                                    class="text-decoration-none"
                                >
                                    {{ $student->name }}
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
            @break

        @case(\App\Enums\AssessmentTypeEnum::Group)
            <h2 class="h4">{{ __('Grupos de Estudiantes') }}</h2>
            <a href="{{ route('teacher.courses.assessments.groups.create', [$course, $assessment]) }}" class="btn btn-primary mb-3">
                <i class="bi bi-people-fill"></i>
                {{ __('Administrar Grupos') }}
            </a>

            @forelse ($assessment->studentGroups as $group)
                <div class="card mb-3">
                    <!-- Group Header -->
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h5 m-0">{{ $group->title }} ({{ $group->students->count() }} {{ __('integrantes') }})</h3>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#gradeModalGroup{{ $group->id }}">
                                <i class="bi bi-journal-plus"></i>
                                {{ __('Corregir') }}
                            </button>
                        </div>
                    </div>

                    <!-- Group Grade Modal -->
                    <div class="modal fade" id="gradeModalGroup{{ $group->id }}" tabindex="-1" aria-labelledby="gradeModalGroupLabel{{ $group->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gradeModalGroupLabel{{ $group->id }}">
                                        {{ __('Corregir') }}: {{ $group->title }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <x-grades.form
                                        :id="'group-' . $group->id . '-assessment-' . $assessment->id"
                                        :course="$course"
                                        :assessment="$assessment"
                                        :gradeable="$group"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Group Details -->
                    <div class="card-body">
                        @if ($group->description)
                            <p>{{ $group->description }}</p>
                        @else
                            <p class="text-muted fst-italic"><small>{{ __('Sin descripción') }}</small></p>
                        @endif
                        <p class="m-0">
                            <strong>{{ __('Integrantes:') }}</strong>
                            <ul>
                                @forelse ($group->students as $student)
                                    <li>{{ $student->name }}</li>
                                @empty
                                    <li>{{ __('Sin integrantes') }}</li>
                                @endforelse
                            </ul>
                        </p>
                    </div>

                    <!-- Group Grades -->
                    <ul class="list-group list-group-flush">
                        @foreach ($group->grades as $grade)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-auto text-muted">
                                        {{ $grade->created_at->format('d/m') }}
                                    </div>
                                    <div class="col-auto">
                                        <x-grade-label :$grade />
                                    </div>
                                    <div class="col-md">
                                        {{ $grade->comment }}
                                    </div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <div class="alert alert-warning">
                    {{ __('No hay grupos de estudiantes asignados a esta evaluación.') }}
                </div>
            @endforelse
            @break
    @endswitch
</x-layouts.app>
