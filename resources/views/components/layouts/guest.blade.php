<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/js/app.js'])

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    </head>
    <body class="d-flex flex-column min-vh-100">
        <x-guest-navbar />

        <div class="container">
            @if (session('success'))
                <div class="container-fluid">
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="container-fluid">
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </div>

        <div class="container mt-auto">
            <footer class="py-3 my-4 border-top pt-4 text-center text-muted">
                <p class="text-muted">
                    <span>{{ now()->format('Y') }} {{ config('app.name') }}</span>
                    <span class="mx-2">&middot;</span>
                    <span>{{ round(microtime(true) - LARAVEL_START, 2) }}s</span>
                </p>
                <p class="text-muted">
                    <a href="https://github.com/tehuel/notas-app" target="_blank">
                        {{ __('Ver Código Fuente') }}
                    </a>
                    <span class="mx-2">&middot;</span>
                    <a href="https://github.com/tehuel/notas-app/issues" target="_blank">
                        {{ __('Reportar Error') }}
                    </a>
                </p>
            </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
