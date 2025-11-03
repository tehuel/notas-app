<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Docentes') ],
    ]"
>
    <x-course-navbar :$course />

    <div class="card my-3">
        <div class="card-header d-flex gap-3 align-items-center">
            <h2 class="h4 m-0 me-auto">{{ __('Docentes') }}</h2>
        </div>

        <ul class="list-group list-group-flush">
            @foreach ($course->teachers as $teacher)
                <li class="list-group-item">
                    @include('teacher.courses.teachers._item', ['teacher' => $teacher])
                </li>
            @endforeach
        </ul>
    </div>
</x-layouts.app>
