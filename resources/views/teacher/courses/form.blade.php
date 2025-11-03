<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => isset($course) ? __('Editar curso') : __('Crear nuevo curso')],
    ]"
>
    @if (isset($course))
        <x-course-navbar :$course />
    @endif
    
    <div class="container" style="max-width: 600px;">
        <h2 class="my-4">
            {{ isset($course) ? __('Editar curso') : __('Crear nuevo curso') }}
        </h2>
        <form
            action="{{ isset($course) ? route('teacher.courses.update', $course) : route('teacher.courses.store') }}" 
            method="POST"
        >
            @csrf

            @if(isset($course))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="division" class="form-label">
                    {{ __('División') }}
                </label>
                <input 
                    type="text" 
                    name="division" 
                    id="division" 
                    class="form-control" 
                    value="{{ old('division', $course->division ?? '') }}" 
                    required
                >
            </div>

            <div class="mb-3">
                <label for="orientation" class="form-label">
                    {{ __('Orientación') }}
                </label>
                <input 
                    type="text" 
                    name="orientation" 
                    id="orientation" 
                    class="form-control" 
                    value="{{ old('orientation', $course->orientation ?? '') }}" 
                    required
                >
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">
                    {{ __('Año') }}
                </label>
                <input 
                    type="number" 
                    name="year" 
                    id="year" 
                    class="form-control" 
                    value="{{ old('year', $course->year ?? now()->year) }}" 
                    required
                >
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">
                    {{ __('Descripción') }}
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="form-control" 
                    rows="5"
                >{{ old('description', $course->description ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $submitLabel ?? (isset($course) ? __('Actualizar') : __('Crear')) }}
            </button>

            <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">
                {{ __('Cancelar') }}
            </a>
        </form>
    </div>
</x-layouts.app>