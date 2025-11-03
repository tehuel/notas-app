<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos')],
    ]"
>
    <x-slot name="header">
        <h2 class="h4 me-auto">{{ __('Cursos') }}</h2>
        <a
            class="btn btn-sm btn-primary"
            href="{{ route('teacher.courses.create') }}"
            title="{{ __('Crear nuevo curso') }}"
        >
            <i class="bi bi-plus-lg"></i>
            {{ __('Nuevo') }}
        </a>
    </x-slot>

    <div class="row g-3">
        @foreach ($courses as $course)
            <div class="col-12 col-sm-6">
                <div class="card h-100">
                    <div class="card-body position-relative">
                        <h1 class="m-0 h2">
                            <a
                                href="{{ route('teacher.courses.show', $course) }}"
                                class="stretched-link text-decoration-none"
                            >
                                {{ $course->title }}
                            </a>
                        </h1>
                        <span class="text-muted">{{ $course->description }}</span>
                    </div>
                    <div class="card-footer text-muted">
                        <form method="POST" action="{{ route('teacher.courses.destroy', $course) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                                <a
                                    href="{{ route('teacher.courses.show', $course) }}"
                                    class="btn btn-link"
                                >
                                    <i class="bi bi-eye"></i>
                                    <span class="d-none d-sm-inline">{{ __('Ver') }}</span>
                                </a>
                                <a
                                    href="{{ route('teacher.courses.edit', $course) }}"
                                    class="btn btn-link"
                                >
                                    <i class="bi bi-pencil"></i>
                                    <span class="d-none d-sm-inline">{{ __('Editar') }}</span>
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-link text-danger"
                                >
                                    <i class="bi bi-x-circle"></i>
                                    <span class="d-none d-sm-inline">{{ __('Eliminar') }}</span>
                                </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.app>