<x-layouts.app>
    <x-slot:header>
        <h2 class="h4">
            {{ __('Dashboard Alumno') }}
        </h2>
        <p class="text-muted">{{ __('Bienvenido al panel de control del alumno.') }}</p>
    </x-slot>

    @forelse ($student->courses as $course)
        <!-- Course Card -->
        <h2 class="h3 m-0">{{ $course->title }}</h2>

        <!-- Attendances Table -->
        <div class="card my-3">
            <div class="card-header">
                <h3 class="h4 m-0">{{ __('Asistencias') }}</h3>
            </div>
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            @forelse ($course->classDays as $classDay)
                                <th>
                                    {{ $classDay->class_date->format('d/m') }}
                                </th>
                            @empty
                                <th>{{ __('No hay días de clase registrados.') }}</th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @forelse ($course->classDays as $classDay)
                                @php
                                    $attendance = $student->attendances
                                        ->where('class_day_id', $classDay->id)
                                        ->first();
                                @endphp
                                <td>
                                    <span 
                                        class="badge bg-{{ $attendance?->present ? 'success' : 'danger' }}"
                                        title="{{ $attendance?->note ?? '' }}"
                                    >
                                        {{ $attendance?->present ? __('Presente') : __('Ausente') }}
                                    </span>

                                </td>
                            @empty
                                <td>
                                    {{ __('No hay días de clase registrados.') }}
                                </td>
                            @endforelse
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="card my-3">
            <div class="card-header">
                <h3 class="h4 m-0">{{ __('Calificaciones') }}</h3>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Evaluación') }}</th>
                            <th>
                                {{ __('Nota') }}
                            </th>
                            <th>{{ __('Comentario') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($course->assessments as $assessment)
                            @php
                                $grade = $student->grades->where('assessment_id', $assessment->id)->first();
                            @endphp
                            <tr>
                                <td style="width: 300px;">
                                    {{ $assessment->title }}
                                    <small class="text-muted">({{ __($assessment->grade_type->label()) }})</small>
                                </td>
                                <td style="width: 180px;">
                                    <x-grade-label :$grade />
                                </td>
                                <td>{{ $grade?->comment ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">{{ __('No hay evaluaciones disponibles.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> 
        </div>
    @empty
        <p>{{ __('No estás inscrito en ningún curso.') }}</p>
    @endforelse
</x-layouts.app>
