<form
    method="POST"
    action="{{ route('teacher.courses.students.destroy', [$course, $student]) }}"
>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
        <a
            class="btn btn-link"
            href="{{ route('teacher.courses.students.show', [$course, $student]) }}"
        >
            <i class="bi bi-eye"></i>
            <span class="d-none d-sm-inline">{{ __('Ver') }}</span>
        </a>
        <a
            class="btn btn-link"
            href="{{ route('teacher.courses.students.edit', [$course, $student]) }}"
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
