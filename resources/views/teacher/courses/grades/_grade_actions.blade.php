@props([
    'course',
    'assessment',
    'gradeable',
])

<div>
    <!-- show modal to add a new grade -->
    <x-grades.modal
        :course="$course"
        :assessment="$assessment" 
        :gradeable="$gradeable"
    />

    <!-- show button to go to history of grades -->
    <a
        href="{{ route('teacher.courses.students.history', [
            'course' => $course,
            'assessment' => $assessment,
            'student' => $gradeable,
        ]) }}"
        class="btn btn-sm btn-link"
        title="{{ __('Historial de calificaciones') }}"
    >
        <i class="bi bi-view-list"></i>
    </a>
</div>