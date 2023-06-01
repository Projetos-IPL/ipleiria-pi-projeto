@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <div class="row">
                    <div class="col-10">
                        <h2><i class="fa-solid fa-tag me-3"></i>Géneros</h2>
                    </div>
                    <div class="col-2">
                        <a href="{{ route('generos.create') }}" class="btn btn-dark d-block">
                            <i class="fa-solid fa-plus me-2"></i> Novo Género
                        </a>
                    </div>
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">Filtrar e Pesquisar</div>
                <div class="card-body">
                    <form method="get">
                        <div class="row align-items-end">
                            <div class="col-md-9">
                                <label class="form-label" for="pesquisa">Pesquisar</label>
                                <input class="form-control" type="text" name="pesquisa" id="pesquisa"
                                    value="{{ $filterByPesquisa }}">
                            </div>

                            <div class="col-md-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Pesquisar
                                </button>

                                <a href="{{ route('generos.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-trash me-1"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Géneros</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col"># Filmes</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($generos as $genero)
                            <tr>
                                <th scope="row">{{ $genero->code }}</th>
                                <td>{{ $genero->nome }}</td>
                                <td>{{ $genero->filmes->count() }}</td>
                                <td>
                                    <a href="{{ route('generos.show', $genero->code) }}" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('generos.edit', $genero->code) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('generos.destroy', $genero->code) }}" method="post"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $generos->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
