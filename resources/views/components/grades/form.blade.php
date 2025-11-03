<form 
    id="grade-form-{{ $id }}"
    method="POST" 
    action="{{ route('teacher.courses.grades.store', ['course' => $assessment->course]) }}"
>
    @csrf
    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
    <input type="hidden" name="{{ $assessment->isGroupAssessment() ? 'student_group_id' : 'student_id' }}" value="{{ $gradeable->id }}">

    <div class="mb-3">
        <x-grades.value-input :grade="$grade ?? null" :assessment="$assessment" :name="'value'" :id="$id . '-value'" />
    </div>
    <div class="mb-3">
        <label for="gradeComment-{{ $id }}" class="form-label">{{ __('Comentario') }}</label>
        <textarea
            class="form-control"
            id="gradeComment-{{ $id }}"
            rows="3"
            name="comment"
        >{{ $grade?->comment ?? '' }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">
        {{ __('Guardar') }}
    </button>
</form>