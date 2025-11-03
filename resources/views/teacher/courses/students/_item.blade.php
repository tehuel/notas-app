<div class="row align-items-center g-2">
    <div class="col">
        <p class="m-0">
            <span class="lead">{{ $student->name }}</span>
        </p>
        <p class="m-0">
            {{ "@" . $student->github_username }}
        </p>
    </div>
    <div class="col-auto">
        @include('teacher.courses.students._item_actions', [$course, $student])
    </div>
</div>
