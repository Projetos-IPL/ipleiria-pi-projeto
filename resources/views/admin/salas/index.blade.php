@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <div class="row">
                    <div class="col-10">
                        <h2><i class="fa fa-people-roof me-3"></i>Salas</h2>
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

                                <a href="{{ route('salas.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-trash me-1"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Salas</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Lotação</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salas as $sala)
                            <tr>
                                <th scope="row">{{ $sala->id }}</th>
                                <td>{{ $sala->nome }}</td>
                                <td>{{ $sala->getLotacao() }}</td>
                                <td>
                                    <a href="{{ route('salas.show', $sala->id) }}" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('salas.edit', $sala->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('filmes.destroy', $sala->id) }}" method="post"
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
                        {{ $salas->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection