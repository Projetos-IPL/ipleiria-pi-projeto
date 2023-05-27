<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="/">Cine<span class="fw-bold">Magic</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Filmes em Exibição</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contactos</a></li>
            </ul>
        </div>

        @auth
        <div class="dropdown ms-3">
            <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @if (auth()->user()->tipo == 'A')
                <li>
                    <a class="dropdown-item" href="{{ route('home') }}">Administração</a>
                </li>
                <hr class="dropdown-divider">
                @endif

                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        @endauth

        @guest
        <div class="dropdown ms-3">
            <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false">
                Login
            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li>
                    <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                </li>
                <hr class="dropdown-divider">
                <li>
                    <a class="dropdown-item" href="{{ route('register') }}">Registar</a>
                </li>
            </ul>
        </div>
        @endguest
</nav>
