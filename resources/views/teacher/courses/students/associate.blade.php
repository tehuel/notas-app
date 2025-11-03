<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Alumnos'), 'url' => route('teacher.courses.students.index', [$course])],
        ['label' => __('Asociar')],
    ]"
>
    <x-course-navbar :$course />
    
    <div class="container" style="max-width: 600px;">
        <h2 class="my-4">{{ __('Asociar Alumnos') }}</h2>

        <p class="text-muted">{{ __('Seleccione alumnos existentes para asociarlos al curso :courseTitle.', ['courseTitle' => $course->title]) }}</p>
        <form action="{{ route('teacher.courses.students.storeAssociation', [$course]) }}" method="POST">
            @csrf

            @if($allStudents->isEmpty())
                <div class="alert alert-info">
                    {{ __('No hay alumnos disponibles para asociar.') }}
                </div>
            @else
                <div class="border rounded p-2" style="max-height: 300px; overflow:auto;">
                    @foreach($allStudents as $student)
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="students[]"
                                id="student_{{ $student->id }}"
                                value="{{ $student->id }}"
                                {{ in_array($student->id, (array) old('students', [])) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="student_{{ $student->id }}">
                                {{ $student->name }} @if(!empty($student->user->email)) <small class="text-muted">({{ $student->user->email }})</small> @endif
                            </label>
                        </div>
                    @endforeach
                </div>

                @if($errors->has('students') || $errors->has('students.*'))
                    <div class="invalid-feedback d-block mt-2">
                        {{ $errors->first('students') ?: $errors->first('students.*') }}
                    </div>
                @endif

                <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" id="select_all_students">
                    <label class="form-check-label" for="select_all_students">
                        {{ __('Seleccionar todos') }}
                    </label>
                </div>
            @endif

            <div class="my-3">
                <button type="submit" class="btn btn-primary" @if($allStudents->isEmpty()) disabled @endif>
                    {{ __('Asociar') }}
                </button>

                <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">
                    {{ __('Cancelar') }}
                </a>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            document.getElementById('select_all_students').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('input[name="students[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        </script>
    @endpush
</x-layouts.app>