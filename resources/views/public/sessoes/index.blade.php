@extends('public.layouts.app')

@php
$minSessaoDate = \Carbon\Carbon::parse($sessoes->min('data'))->format('d/m/Y');
$maxSessaoDate = \Carbon\Carbon::parse($sessoes->max('data'))->format('d/m/Y');
@endphp

@section('content')
<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-7">
        <h1 class="font-weight-light mb-2">Filmes em cartaz</h1>
        <h5>A nossa coleção de filmes em cartaz, de {{ $minSessaoDate }} até {{ $maxSessaoDate }}.</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Filtrar e Pesquisar
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row d-flex align-items-end">
                <div class="col-md-3">
                    <label class="form-label" for="genero">Género</label>
                    <select class="form-select" name="genero" id="genero">
                        <option value="">Todos</option>
                        @foreach ($generos as $genero)
                        <option value="{{ $genero->code }}" {{ $generoQuery==$genero->code ? 'selected' : '' }}>
                            {{ $genero->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label for="search" class="form-label">Título ou Sinopse</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" id="search"
                            value="{{ $searchQuery ?? '' }}">
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search me-1"></i>
                        Pesquisar
                    </button>
                    <a class="btn btn-secondary" href="{{ route('sessoes.indexPublic') }}">
                        <i class="fas fa-eraser me-1"></i>
                        Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <small>A mostrar {{ $sessoes->count() }} resultados</small>

    @if ($sessoes->count() == 0)
    <div class="col-md-12 my-5 text-center">
        <h3>Não foram encontrados resultados</h3>
        <p>Tente mudar os filtros ou os termos de pesquisa.</p>
    </div>
    @endif

    @foreach ($sessoes as $sessao)
    <div class="col-md-3 my-4">
        <a href="{{ route('sessoes.showPublic', $sessao->filme->id) }}">
            <img src="{{ $sessao->filme->getCartazPath() }}" alt="{{ $sessao->filme->titulo }}"
                class="img-fluid rounded shadow">
        </a>

        <div class="text-center mt-3">
            <h4>{{ $sessao->filme->titulo }}</h4>
            <span class="badge rounded-pill text-bg-dark">{{ $sessao->filme->genero->nome }}</span>
        </div>
    </div>
    @endforeach
</div>
@endsection