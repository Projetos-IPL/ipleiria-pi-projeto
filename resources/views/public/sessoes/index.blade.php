@extends('public.layouts.app')

@section('content')
<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-7">
        <h1 class="font-weight-light">Filmes em cartaz</h1>
    </div>
</div>

<hr />

<div class="row d-flex align-items-end my-4">
    <div class="col-md-5">
        <form method="get">
            <label class="form-label" for="genero">Filtrar por género:</label>
            <select class="form-select" name="genero" id="genero" onchange="this.form.submit()">
                <option value="">Todos</option>
                @foreach ($generos as $genero)
                <option value="{{ $genero->code }}">{{ $genero->nome }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="col-md-5">
        <form method="get">
            <label for="search" class="form-label">Pesquisar</label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Título, sinopse, etc" name="search" id="search">
                <button class="btn btn-dark" type="submit">Pesquisar</button>
            </div>
        </form>
    </div>

    <div class="col-md-2">
        <form method="get">
            <button class="btn btn-primary w-100" type="submit">Limpar</button>
        </form>
    </div>
</div>

<hr />

<div class="row gx-4 gx-lg-5 align-items-center my-5">
    @foreach ($sessoes as $sessao)
    <div class="col-md-3 my-4">
        <a href="{{ route('sessoes.showPublic', $sessao->filme->id) }}">
            <img src="{{ $sessao->filme->getCartazPath() }}" alt="{{ $sessao->filme->titulo }}"
                class="img-fluid rounded shadow">
        </a>

        <div class="text-center mt-3">
            <h4>{{ $sessao->filme->titulo }}</h4>
            <span class="badge rounded-pill text-bg-secondary">{{ $sessao->filme->genero->nome }}</span>
        </div>
    </div>
    @endforeach
</div>
@endsection
