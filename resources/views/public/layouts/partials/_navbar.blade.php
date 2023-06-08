<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="/">
            Cine<span class="fw-bold">Magic</span>
            <small class="ms-2 fw-normal h6">O melhor do cinema, mais perto de si!</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">
                        <i class="fas fa-home me-1"></i>
                        Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sessoes.indexPublic') }}">
                        <i class="fas fa-film me-1"></i>
                        Sessões
                    </a>
                </li>
                @if (auth()->user()?->tipo == 'C')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carrinho.showCart') }}">
                        <i class="fas fa-shopping-cart me-1"></i>
                        Carrinho
                    </a>
                </li>
                @endif
            </ul>
        </div>

        @auth
        <div class="dropdown ms-3">
            <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false">
                <!-- show user avatar-->
                <img src="{{ auth()->user()->getAvatarPath() }}" class="rounded-circle me-2" width="24" height="24"
                    alt="Avatar" />
                {{ auth()->user()->name }}
            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @if (auth()->user()->tipo == 'A')
                <li>
                    <a class="dropdown-item" href="{{ route('home') }}">Administração</a>
                </li>
                <hr class="dropdown-divider">
                @endif

                <li>
                    <span class="dropdown-item" href="#">Tipo: {{ auth()->user()->getPrettyTipo() }}</span>
                </li>

                @if (auth()->user()->tipo == 'F')
                <hr class="dropdown-divider">

                <li>
                    <a class="dropdown-item" href="{{ route('sessoes.accessControl') }}">
                        Controlo de Sessões
                    </a>
                </li>
                @endif

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item"
                        href="{{ auth()->user()->tipo == 'A' ? route('utilizadores.adminProfile') : route('utilizadores.publicProfile') }}">Perfil</a>
                </li>
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
        <div class="dropdown ms-1">
            <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false">
                Conta
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