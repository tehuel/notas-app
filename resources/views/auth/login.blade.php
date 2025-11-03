<x-layouts.guest>
    <div class="card shadow-sm w-100 mx-auto my-5" style="max-width: 520px;">
        <div class="card-body">
            <div class="text-center">
                <h1 class="card-title h3">{{ __('Iniciar Sesión') }}</h1>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label 
                        for="email" 
                        class="form-label text-muted"
                    >{{ __('Email') }}</label>
                    <input
                        class="form-control" 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus 
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="" />
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-muted">{{ __('Contraseña') }}</label>
                    <input
                        class="form-control"
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="" />
                </div>

                <div class="mb-4">
                    <label for="remember_me">
                        <input
                            id="remember_me" 
                            type="checkbox" 
                            name="remember"
                        >
                        <span>{{ __('Recordarme') }}</span>
                    </label>
                </div>

                <div class="mb-4">
                    <button
                        type="submit"
                        class="btn w-100 btn-dark btn-lg"
                    >
                        {{ __('Iniciar Sesión') }}
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </form>
        </div>
    </div>
</x-layouts.guest>
