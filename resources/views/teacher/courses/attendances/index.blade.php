<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Asistencias') ],
    ]"
>
    <x-course-navbar :$course />

    <div class="card my-3">
        <div class="card-header d-flex gap-3 align-items-center">
            <h2 class="h4 m-0 me-auto">{{ __('Asistencias') }}</h2>
            <a
                class="btn btn-sm btn-primary"
                title="{{ __('Tomar asistencias') }}"
                data-bs-toggle="offcanvas"
                href="#offcanvasGrade"
                role="button"
                aria-controls="offcanvasGrade"
                disabled="{{ $course->students->isEmpty() ? 'true' : 'false' }}"
            >
                <i class="bi bi-plus-lg"></i>
                {{ __('Nuevo') }}
            </a>
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
        @elseif($class_days->isEmpty())
            <div class="alert alert-warning m-3">
                {{ __('No hay días de clase en este curso.') }}
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Alumno') }}</th>
                            <th>{{ __('%') }}</th>
                            @foreach ($class_days as $class_day)
                                <th>{{ $class_day->class_date->format('d/m') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->students as $student)
                            <tr>
                                <th scope="row">
                                    <a 
                                        class="text-decoration-none"
                                        href="{{ route('teacher.courses.students.show', [$course, $student]) }}" 
                                        title="{{ __('Ver alumno') }}"
                                    >
                                        {{ $student->name }}
                                    </a>
                                </th>
                                <td>{{ round($percentage_by_student[$student->id]) ?? '-' }}%</td>
                                @foreach ($class_days as $class_day)
                                    <td>
                                        @php
                                            $attendance = $class_day->attendances->where('student_id', $student->id)->first();
                                        @endphp
                                        @if ($attendance)
                                            <span 
                                                class="badge bg-{{ $attendance->present ? 'success' : 'danger' }}"
                                                title="{{ $attendance->note ?? '' }}"
                                            >
                                                {{ $attendance->present ? __('Presente') : __('Ausente') }}
                                            </span>
                                            {{-- form to edit attendance --}}
                                            <form 
                                                class="d-inline"
                                                action="{{ route('teacher.courses.attendances.update', [$course, $attendance]) }}" 
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="present" value="{{ $attendance->present ? '0' : '1' }}">
                                                <button type="submit" class="btn btn-sm btn-link p-0" title="{{ $attendance->present ? __('Marcar como ausente') : __('Marcar como presente') }}">
                                                    <i class="bi {{ $attendance->present ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{ __('No registrado') }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        <tr>{{-- attendance percentage by class_day --}}
                            <td colspan="2" class="text-end pe-3 fw-bold">{{ __('Total') }}</td>
                            @foreach ($class_days as $class_day)
                                <td>{{ round($percentage_by_day[$class_day->id]) ?? '-' }}%</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="offcanvasGrade" aria-labelledby="offcanvasLabel" style="width: 300px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLabel">{{ __('Tomar asistencias') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @include('teacher.courses.attendances._form', ['course' => $course])
        </div>
    </div>
</x-layouts.app>
