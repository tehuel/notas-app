<x-layouts.app>
    <div class="mx-auto" style="max-width: 500px;">
        <h2 class="mb-4">
            {{ __('Perfil del Usuario') }}
        </h2>

        <div class="accordion" id="accordionProfile">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button h2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfileInformation" aria-expanded="true" aria-controls="collapseProfileInformation">
                        {{ __('Información del Perfil') }}
                    </button>
                </h2>
                <div id="collapseProfileInformation" class="accordion-collapse collapse show" data-bs-parent="#accordionProfile">
                    <div class="accordion-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button h2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfilePassword" aria-expanded="false" aria-controls="collapseProfilePassword">
                        {{ __('Contraseña') }}
                    </button>
                </h2>
                <div id="collapseProfilePassword" class="accordion-collapse collapse" data-bs-parent="#accordionProfile">
                    <div class="accordion-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
