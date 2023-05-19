@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <div class="row">
                    <div class="col">
                        <h2><i class="fa-solid fa-video me-3"></i>Filmes</h2>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <a href="#" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Novo Filme
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Filtrar e Pesquisar</div>
                <div class="card-body">
                    <form method="get">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label" for="pesquisa">Pesquisar</label>
                                <input class="form-control" type="text" name="pesquisa" id="pesquisa"
                                    value="{{ $filterByPesquisa }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="genero">Género</label>
                                <select class="form-select" id="genero" name="genero">
                                    <option value="">Todos</option>

                                    @foreach ($generos as $genero)
                                    <option {{ $filterByGenero===$genero->code ? 'selected' : '' }}
                                        value="{{ $genero->code }}">{{ $genero->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="ano">Ano</label>
                                <select class="form-select" id="ano" name="ano">
                                    <option value="">Todos</option>

                                    @foreach ($anos as $ano)
                                    <option value="{{ $ano->ano }}">{{ $ano->ano }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Pesquisar
                                </button>

                                <a href="{{ route('admin.filmes.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-trash me-1"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Filmes</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cartaz</th>
                                <th scope="col">Título</th>
                                <th scope="col">Género</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filmes as $filme)
                            <tr>
                                <th scope="row">{{ $filme->id }}</th>
                                <th>
                                    <a href="{{ '/storage/cartazes/' . $filme->cartaz_url }}" target="_blank">
                                        <img src="{{ '/storage/cartazes/' . $filme->cartaz_url }}" alt=""
                                            style="max-width: 100px">
                                    </a>
                                </th>
                                <td>{{ $filme->titulo }}</td>
                                <td>{{ $filme->genero->nome }}</td>
                                <td>{{ $filme->ano }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $filmes->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
