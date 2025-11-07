@if($attendance)
    <form 
        class="d-inline"
        action="{{ route('teacher.courses.attendances.update', [$course, $attendance]) }}" 
        method="POST"
    >
        @csrf
        @method('PUT')
        <input type="hidden" name="present" value="{{ $attendance->present ? '0' : '1' }}">
        <button type="submit" class="btn btn-sm btn-link p-0" title="{{ $attendance->present ? __('Marcar como ausente') : __('Marcar como presente') }}">
            <i class="bi {{ $attendance->present ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
        </button>
    </form>
@else
    <form 
        class="d-inline"
        action="{{ route('teacher.courses.attendances.storeSingle', [$course]) }}" 
        method="POST"
    >
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="class_date" value="{{ $class_day->class_date->toDateString() }}">
        <input type="hidden" name="present" value="1">
        <button type="submit" class="btn btn-sm btn-link p-0" title="{{ __('Marcar como presente') }}">
            <i class="bi bi-check-circle"></i>
        </button>
    </form>
@endif