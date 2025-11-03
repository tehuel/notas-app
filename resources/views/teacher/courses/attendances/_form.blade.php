<form
    class="d-flex flex-column"
    method="POST"
    action="{{ route('teacher.courses.attendances.store', $course) }}"
>
    @csrf
    <input name="class_date" type="date" class="form-control mb-3" required value="{{ date('Y-m-d') }}">
    @foreach ($course->students as $index => $student)
        <!-- show a row for each student with a checkbox to mark attendance clicking its name -->
        <div class="mb-3">
            <input type="hidden" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}">
            <input type="hidden" name="attendances[{{ $index }}][present]" value="0">
            <div class="form-check form-switch">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="attendance-{{ $student->id }}" 
                    name="attendances[{{ $index }}][present]" 
                    value="1"
                >
                <label class="form-check-label" for="attendance-{{ $student->id }}">
                    {{ $student->name }}
                </label>
            </div>
        </div>
    @endforeach
    <button type="submit" class="btn btn-primary w-100">
        {{ __('Guardar') }}
    </button>
</form>
