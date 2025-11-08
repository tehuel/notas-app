<x-layouts.guest>
    <div class="my-5 py-5 p-md-5 text-center border shadow-sm rounded"> 
        <h1 class="display-3">
            {{ __('Bienvenido a :app', ['app' => config('app.name')]) }}
        </h1> 
        <p class="lead">
            {{ __('Una aplicación para la administración de notas y tareas.') }}
        </p>

        <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2 my-3">
            {{ __('Iniciar Sesión') }}
        </a>
        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg mx-2 my-3">
            {{ __('Registrarse') }}
        </a>
    </div>
</x-layouts.guest>
