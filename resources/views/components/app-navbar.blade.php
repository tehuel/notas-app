<nav
    {{ $attributes->merge(['class' => 'navbar navbar-expand-md bg-dark']) }}
    data-bs-theme="dark"
>
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" 
            aria-expanded="false" 
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0">
                <li class="nav-item">
                    <a
                        @class([
                            'nav-link',
                            'active' => request()->routeIs('*.dashboard')
                        ])
                        aria-current="page" 
                        href="{{ route('dashboard') }}"
                    >
                        {{ __('Dashboard') }}
                    </a>
                </li>
            </ul>

            <div class="dropdown">
                <button
                    class="btn btn-secondary dropdown-toggle"
                    type="button" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false"
                >
                    {{ Auth::user()->email }}
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            {{ __('Perfil') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                {{ __('Cerrar Sesión') }}
                            </button>
                        </form> 
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>