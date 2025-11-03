<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title],
    ]"
>
    <x-course-navbar :$course />

    <div class="card my-3">
        <div class="card-header d-flex align-items-center">
            <h2 class="h4 m-0 me-auto">{{ $course->title }}</h2>
            <a
                class="btn btn-sm btn-primary"
                href="{{ route('teacher.courses.edit', [$course]) }}"
                title="{{ __('Editar Curso') }}"
            >
                <i class="bi bi-pencil-square"></i>
                {{ __('Editar') }}
            </a>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>{{ __('División:') }}</strong> {{ $course->division }}
            </li>
            <li class="list-group-item">
                <strong>{{ __('Orientación:') }}</strong> {{ $course->orientation }}
            </li>
            <li class="list-group-item">
                <strong>{{ __('Año:') }}</strong> {{ $course->year }}
            </li>
            @if ($course->description)
                <li class="list-group-item">
                    <p class="mt-2">{{ $course->description }}</p>
                </li>
            @endif
        </ul>
    </div>

</x-layouts.app>
