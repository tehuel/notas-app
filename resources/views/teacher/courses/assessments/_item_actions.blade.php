<form
    method="POST"
    action="{{ route('teacher.courses.assessments.destroy', [$course, $assessment]) }}"
>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
        <a
            class="btn btn-link"
            href="{{ route('teacher.courses.assessments.show', [$course, $assessment]) }}"
        >
            <i class="bi bi-eye"></i>
            <span class="d-none d-sm-inline d-md-none d-lg-inline">{{ __('Ver') }}</span>
        </a>
        <a
            class="btn btn-link"
            href="{{ route('teacher.courses.assessments.edit', [$course, $assessment]) }}"
        >
            <i class="bi bi-pencil"></i>
            <span class="d-none d-sm-inline d-md-none d-lg-inline">{{ __('Editar') }}</span>
        </a>
        <button
            type="submit"
            class="btn btn-link text-danger"
        >
            <i class="bi bi-x-circle"></i>
            <span class="d-none d-sm-inline d-md-none d-lg-inline">{{ __('Eliminar') }}</span>
        </button>
</form>
