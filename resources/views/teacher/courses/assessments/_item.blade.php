<div class="me-auto">
    <p class="m-0">
        <span class="lead">{{ $assessment->title }}</span>
    </p>
    <p class="m-0">
        {{ $assessment->description }}
    </p>
</div>
<div>
    <span>{{ __($assessment->grade_type->label()) }}</span>
</div>
<div class="flex-shrink-0">
    @include('teacher.courses.assessments._item_actions', [$course, $assessment])
</div>
