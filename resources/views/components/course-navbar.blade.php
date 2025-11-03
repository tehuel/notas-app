@php
  $items = [
    [
      'name' => __('Curso'),
      'url' => route('teacher.courses.show', [$course]),
      'active' => request()->routeIs(['teacher.courses.show', 'teacher.courses.edit']),
    ],
    [
      'name' => __('Notas'),
      'url' => route('teacher.courses.grades.index', [$course]),
      'active' => request()->routeIs('teacher.courses.grades.*'),
    ],
    [
      'name' => __('Evaluaciones'),
      'url' => route('teacher.courses.assessments.index', [$course]),
      'active' => request()->routeIs('teacher.courses.assessments.*'),
    ],
    [
      'name' => __('Alumnos'),
      'url' => route('teacher.courses.students.index', [$course]),
      'active' => request()->routeIs('teacher.courses.students.*'),
    ],
    [
      'name' => __('Asistencias'),
      'url' => route('teacher.courses.attendances.index', [$course]),
      'active' => request()->routeIs('teacher.courses.attendances.*'),
    ],
    [
      'name' => __('Docentes'),
      'url' => route('teacher.courses.teachers.index', [$course]),
      'active' => request()->routeIs('teacher.courses.teachers.*'),
    ],
  ];
@endphp

<ul class="nav nav-underline justify-content-center border-bottom mb-3">
  @foreach($items as $item)
  <li class="nav-item">
    <a
      @class(['nav-link', 'active' => $item['active'] ])
      aria-current="page"
      href="{{ $item['url'] }}"
    >
      {{ $item['name'] }}
    </a>
  </li>
  @endforeach
</ul>
