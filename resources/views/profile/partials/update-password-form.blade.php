<section>
    <header>
        <p>
            {{ __('Desde acá podés actualizar la contraseña de tu cuenta') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password">{{__('Contraseña Actual')}}</label>
            <input id="update_password_current_password" class="form-control" name="current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="" />
        </div>

        <div class="mb-3">
            <label for="update_password_password">{{__('Nueva Contraseña')}}</label>
            <input id="update_password_password" class="form-control" name="password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="" />
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation">{{__('Confirmar Contraseña')}}</label>
            <input id="update_password_password_confirmation" class="form-control" name="password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="" />
        </div>

        <div>
            <button type="submit" class="btn btn-primary">{{ __('Guardar Cambios') }}</button>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ __('Guardado.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </form>
</section>
