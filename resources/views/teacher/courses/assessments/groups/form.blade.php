@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.1/dist/cdn.min.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
        groups: @json($assessment->studentGroups),
        students: @json($course->students),
        assignations: @json($assignations),
        addGroup() {
            // generate a random string id
            const randomId = Math.random().toString(36).substr(2, 9);
            const groupTitle = `{{ __('Grupo') }} ${randomId}`;
            this.groups.push({
                id: `new-${randomId}`,
                title: groupTitle,
                new: true,
            });
        },
        removeGroup(index) {
            // remove all assignations to this group
            for (const studentId in this.assignations) {
                if (this.assignations[studentId] == this.groups[index].id) {
                    delete this.assignations[studentId];
                }
            }
            // remove the group
            this.groups.splice(index, 1);
        },
    }))
})
</script>
@endpush

<x-layouts.app
    :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('teacher.dashboard')],
        ['label' => __('Cursos'), 'url' => route('teacher.courses.index')],
        ['label' => $course->title, 'url' => route('teacher.courses.show', [$course])],
        ['label' => __('Evaluaciones'), 'url' => route('teacher.courses.assessments.index', [$course])],
        ['label' => $assessment->title, 'url' => route('teacher.courses.assessments.show', [$course, $assessment])],
        ['label' => __('Administrar Grupos')],
    ]"
>
    <x-course-navbar :$course />

    <h2 class="h2 text-center">{{ __('Administrar Grupos') }}</h2>

    <form x-data="app" method="POST" action="{{ route('teacher.courses.assessments.groups.store', [$course, $assessment]) }}">
        @csrf

        <template x-for="(group, index) in groups" :key="group.id">
            <div class="d-none">
                <input type="hidden" :name="`groups[${index}][title]`" :value="group.title" />
                <input type="hidden" :name="`groups[${index}][id]`" :value="group.id" />
            </div>
        </template>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>{{ __('Alumno') }}</th>
                        <template x-for="(group, index) in groups" :key="index">
                            <th>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span x-text="group.title"></span>
                                    <button
                                        class="btn btn-sm rounded-circle"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a
                                                href="#"
                                                class="dropdown-item"
                                                @click.prevent="(() => {
                                                    const newTitle = prompt('{{ __('Nuevo título') }}', group.title);
                                                    if (newTitle !== null && newTitle.trim() !== '') group.title = newTitle.trim();
                                                })()"
                                            >
                                                {{ __('Renombrar') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                href="#"
                                                class="dropdown-item text-danger"
                                                @click.prevent="(() => {
                                                    if (confirm('{{ __('¿Eliminar este grupo?') }}')) removeGroup(index);
                                                })()"
                                            >
                                                {{ __('Eliminar') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($course->students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <template x-for="(group, index) in groups" :key="index">
                                <td class="text-center">
                                    <div class="form-check">
                                        <input 
                                            type="radio" 
                                            class="btn-check" 
                                            name="students[{{ $student->id }}]" 
                                            :id="`student_{{ $student->id }}_group_${group.id}`"
                                            :value="group.id"
                                            x-model.number="assignations[{{ $student->id }}]"
                                        >
                                        <label 
                                            class="btn btn-sm d-block" 
                                            :for="`student_{{ $student->id }}_group_${group.id}`"
                                        >
                                            <span x-text="assignations[{{ $student->id }}] == group.id ? '{{ __('Asignado') }}' : '{{ __('Asignar') }}'"></span>
                                        </label>
                                    </div>
                                </td>
                            </template>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button
            type="button"
            class="btn btn-secondary"
            @click="addGroup()"
        >
            {{ __('Agregar Grupo') }}
        </button>

        <div class="my-3 text-end">
            <a
                href="{{ route('teacher.courses.assessments.show', [$course, $assessment]) }}"
                class="btn btn-secondary"
            >
                {{ __('Cancelar') }}
            </a>
            <button type="submit" class="btn btn-primary">
                {{ __('Guardar Cambios') }}
            </button>
        </div>
    </form>
</x-layouts.app>
