<x-layouts.app :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Alumnos'), 'url' => route('teacher.courses.students.index', [$course])],
        ['label' => isset($student) ? __('Editar Alumno') : __('Crear Nuevo Alumno')],
]">
    <x-course-navbar :$course />
    
    <div class="container" style="max-width: 600px;">
        <h2 class="my-4">
            {{ isset($student) ? __('Editar Alumno') : __('Crear Nuevo Alumno') }}
        </h2>
        <form
            action="{{ isset($student) ? route('teacher.courses.students.update', [$course, $student]) : route('teacher.courses.students.store', [$course]) }}"
            method="POST" class="row g-3">
            @csrf

            @if (isset($student))
                @method('PUT')
            @endif

            <div class="col-12 col-sm-6">
                <label for="first_name" class="form-label">{{ __('Nombre') }}</label>
                <input type="text" name="first_name" id="first_name" class="form-control"
                    value="{{ old('first_name', $student->first_name ?? '') }}" required>
            </div>

            <div class="col-12 col-sm-6">
                <label for="last_name" class="form-label">{{ __('Apellido') }}</label>
                <input type="text" name="last_name" id="last_name" class="form-control"
                    value="{{ old('last_name', $student->last_name ?? '') }}" required>
            </div>

            <div class="col-12 col-sm-6">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email', $student->user->email ?? '') }}" required>
            </div>

            <div class="col-12 col-sm-6">
                <label for="github_username" class="form-label">{{ __('Usuario de Github') }}</label>
                <input type="text" name="github_username" id="github_username" class="form-control"
                    value="{{ old('github_username', $student->github_username ?? '') }}">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    {{ $submitLabel ?? (isset($student) ? __('Actualizar') : __('Crear')) }}
                </button>

                <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">
                    {{ __('Cancelar') }}
                </a>

            </div>
        </form>
    </div>
</x-layouts.app>
