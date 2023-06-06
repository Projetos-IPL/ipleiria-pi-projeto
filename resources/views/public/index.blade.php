@extends('public.layouts.app')

@section('content')
<style>
    #cartaz {
        width: 500px;
    }
</style>

<!-- Heading Row-->
<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-4">
        <img class="img-fluid rounded mb-4 mb-lg-0" src="{{ $sessao->filme->getCartazPath() }}" id="cartaz" />
    </div>
    <div class="col-lg-8">
        <h1 class="font-weight-light mb-3">{{ $sessao->filme->titulo }}</h1>
        <p class="lead mb-4">{{ $sessao->filme->sumario }}</p>
        <a class="btn btn-dark" href="{{ route('sessoes.showPublic', $sessao->filme->id) }}">
            <i class="fa-solid fa-film me-1"></i>
            Ver Sessões
        </a>
    </div>
</div>

<!-- Call to Action-->
<div class="card text-white bg-secondary my-5 py-4 text-center">
    <div class="card-body">
        <h2>Do que está à espera?</h2>
        <div class="my-4">
            <small class="text-white m-0">Bilhetes desde</small>
            <h2>
                {{ number_format($preco_bilhete_sem_iva * (1 + $percentagem_iva / 100), 2, ',', '.') }}€
            </h2>
        </div>

        <a class="btn btn-light" href="{{ route('sessoes.indexPublic') }}">
            <i class="fa-solid fa-ticket me-1"></i>
            Comprar Bilhete
        </a>
    </div>
</div>

<!-- Content Row-->
<div class="row gx-4 gx-lg-5">
    <div class="col-md-4 mb-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Card One</h2>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex
                    numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
            </div>
            <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Card Two</h2>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex
                    natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore
                    voluptates quos eligendi labore.</p>
            </div>
            <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>
        </div>
    </div>
    <div class="col-md-4 mb-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Card Three</h2>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex
                    numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
            </div>
            <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>
        </div>
    </div>
</div>
@endsection