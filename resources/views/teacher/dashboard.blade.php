<x-layouts.app>
    <x-slot:header>
        <h2>
            {{ __('Dashboard Docente') }}
        </h2>
    </x-slot>

    <div>
        <ul>
            <li>
                <a href="{{ route('teacher.courses.index') }}">
                    {{ __('Cursos') }}
                </a>
            </li>
        </ul>
    </div>
</x-layouts.app>
