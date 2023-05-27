@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <div class="row">
                    <div class="col-10">
                        <h2><i class="fa-solid fa-users me-3"></i>Utilizadores</h2>
                    </div>
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
            @endif

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
                            <div class="col-md-2">
                                <label class="form-label" for="tipo">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo">
                                    <option value="">Todos</option>
                                    <option {{ $filterByTipo=='C' ? 'selected' : '' }} value="C">Cliente</option>
                                    <option {{ $filterByTipo=='F' ? 'selected' : '' }} value="F">Funcionário</option>
                                    <option {{ $filterByTipo=='A' ? 'selected' : '' }} value="A">Administrador</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="bloqueado"
                                        name="bloqueado" {{ $filterByBloqueado=="1" ? "checked" : "" }}>
                                    <label class="form-check-label" for="bloqueado">Mostrar bloqueados?</label>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Pesquisar
                                </button>

                                <a href="{{ route('utilizadores.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-trash me-1"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Utilizadores</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>
                                    <a href="{{ $user->getAvatarPath() }}" target="_blank">
                                        <img src="{{ $user->getAvatarPath() }}" alt="" class="rounded-circle img-fluid"
                                            style="max-width: 64px">
                                    </a>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getPrettyTipo() }}</td>
                                <td>
                                    <a href="{{ route('utilizadores.show', $user->id) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    @if (auth()->user()->id != $user->id)
                                    <a href="{{ route('utilizadores.edit', $user->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('filmes.destroy', $user->id) }}" method="post"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
