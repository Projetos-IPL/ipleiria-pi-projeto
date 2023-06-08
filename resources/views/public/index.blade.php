@extends('public.layouts.app')

@section('content')
<!-- Heading Row-->
<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-4">
        <img class="img-fluid rounded mb-4 mb-lg-0 shadow-lg" src="{{ $sessao->filme->getCartazPath() }}"
            style="width: 500px;" />
    </div>
    <div class="col-lg-8">
        <h1 class="fw-light mb-4">{{ $sessao->filme->titulo }}</h1>

        <p class="lead">{{ $sessao->filme->sumario }}</p>
        <p><span class="fw-bold">Género:</span> {{ $sessao->filme->genero->nome }} | <span class="fw-bold">Ano:</span>
            {{ $sessao->filme->ano }}</p>

        <a class="btn btn-dark mt-3" href="{{ route('sessoes.showPublic', $sessao->filme->id) }}">
            <i class="fa-solid fa-film me-1"></i>
            Ver Sessões
        </a>
    </div>
</div>

<!-- Call to Action-->
<div class="card text-white bg-dark my-5 py-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="h-100 d-flex justify-content-center align-items-center">
                    <figure>
                        <blockquote class="blockquote">
                            <p>
                                "O CineMagic é simplesmente mágico!"
                            </p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            Nuno, <cite>cliente da CineMagic.</cite>
                        </figcaption>
                    </figure>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <h2>Do que está à espera?</h2>
                <div class="my-4">
                    <small class="text-white m-0">Bilhetes desde</small>
                    <h2>
                        {{ number_format($preco_bilhete_sem_iva * (1 + $percentagem_iva / 100), 2, ',', '.') }}€
                    </h2>
                </div>

                <a class="btn btn-lg btn-light" href="{{ route('sessoes.indexPublic') }}">Comprar Já</a>
            </div>
        </div>
    </div>
</div>

<!-- Content Row-->
<div class="row gx-4 gx-lg-5">
    <div class="col-md-4 mb-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="fa-solid fa-film me-1"></i>
                    Filmes
                </h2>
                <p class="card-text">
                    Temos vários filmes em cartaz, para todos os gostos. Consulte a nossa lista de filmes e
                    escolha o seu preferido.
                </p>
            </div>
            <div class="card-footer">
                <a class="btn btn-primary btn-sm" href="{{ route('sessoes.indexPublic') }}">Ver Mais</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="fa-solid fa-ticket me-1"></i>
                    Bilhetes
                </h2>
                <p class="card-text">
                    Compre o seu bilhete online e evite filas de espera. Pode comprar bilhetes para si e para
                    os seus amigos.
                </p>
            </div>
            <div class="card-footer">
                <a class="btn btn-primary btn-sm" href="{{ route('sessoes.indexPublic') }}">Ver Mais</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="fa-solid fa-info me-1"></i>
                    Informações
                </h2>
                <div class="card-text">
                    <p>Este cinema é fictício e foi criado para o projeto final da disciplina de Programação
                        para a Internet (PI - TeSP TI - 2022/2023).</p>
                    <p>Desenvolvido por Afonso Santos, Filipe Pedrosa e Inês Saragoça.</p>
                    &copy; {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
