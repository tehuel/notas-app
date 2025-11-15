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
                    <div class="card-body">
                        <div class="row">
                            <!-- Course title -->
                            <div class="col">
                                <h1 class="m-0 h4">
                                    <a
                                        href="{{ route('teacher.courses.show', $course) }}"
                                        class="text-decoration-none"
                                    >
                                        {{ $course->title }}
                                    </a>
                                </h1>

                            </div>

                            <!-- Actions dropdown -->
                            <div class="col-auto">
                                <x-actions-dropdown>
                                    <x-actions-dropdown.link-action
                                        :route="route('teacher.courses.edit', $course)"
                                        :label="__('Editar')"
                                        icon="bi bi-pencil"
                                    />
                                    <x-actions-dropdown.form-action
                                        :route="route('teacher.courses.destroy', $course)"
                                        :label="__('Eliminar')"
                                        icon="bi bi-trash"
                                        :message="__('¿Estás seguro de eliminar este curso?')"
                                        class="text-danger"
                                    />
                                </x-actions-dropdown>
                            </div>

                            <!-- Course description -->
                            <div class="col-12">
                                <span class="text-muted">{{ $course->description ?? __('Sin descripción') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.app>