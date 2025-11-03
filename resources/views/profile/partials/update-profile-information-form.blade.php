<section>
    <header>
        <p>{{ __("Actualiza la información de tu perfil") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="first_name">{{__('Nombre')}}</label>
            <input
                id="first_name" 
                class="form-control"
                name="first_name" 
                type="text" 
                value="{{old('first_name', $user->teacher->first_name ?? $user->student->first_name)}}" 
                required 
                autofocus 
                autocomplete="first_name" 
            />
            <x-input-error class="" :messages="$errors->get('first_name')" />
        </div>

        <div class="mb-3">
            <label for="last_name">{{__('Apellido')}}</label>
            <input
                id="last_name" 
                class="form-control"
                name="last_name" 
                type="text" 
                value="{{old('last_name', $user->teacher->last_name ?? $user->student->last_name)}}" 
                required 
                autocomplete="last_name" 
            />
            <x-input-error class="" :messages="$errors->get('last_name')" />
        </div>

        @if($user->student)
            <div class="mb-3">
                <label for="github_username">{{__('Usuario de Github')}}</label>
                <div class="input-group">
                    <span class="input-group-text">github.com/</span>
                    <input
                        id="github_username" 
                        class="form-control"
                        name="github_username" 
                        type="text" 
                        value="{{old('github_username', $user->student->github_username)}}" 
                        required 
                        autocomplete="github_username" 
                    />
                </div>
                <x-input-error class="" :messages="$errors->get('github_username')" />
            </div>
        @endif

        <div class="mb-3">
            <label for="email">{{__('Email')}}</label>
            <input 
                id="email"
                class="form-control"
                name="email" 
                type="email" 
                value="{{old('email', $user->email)}}" 
                required 
                autocomplete="username"
            />
            <x-input-error class="" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p>
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p>
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <button type="submit" class="btn btn-primary">
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ __('Guardado.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </form>
</section>
