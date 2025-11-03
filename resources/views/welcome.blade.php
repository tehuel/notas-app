<x-layouts.guest>
    <main class="my-5">
        <h1>{{ __('Esto es :app', ['app' => config('app.name')]) }}</h1>

        <small><p class="text-muted">{{ __('Ambiente :env', ['env' => App::environment()]) }}</p></small>
    </main>
</x-layouts.guest>
