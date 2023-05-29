@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <div class="row">
                    <div class="col-10">
                        <h2><i class="fa-solid fa-clapperboard me-3"></i>Sessões</h2>
                    </div>
                    <div class="col-2">
                        <a href="{{ route('salas.create') }}" class="btn btn-dark d-block">
                            <i class="fa-solid fa-plus me-2"></i> Nova Sessão
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
                            <div class="col-md-4">
                                <label class="form-label" for="filme">Filme</label>
                                <select class="form-select" id="filme" name="filme">
                                    <option value="">Todos</option>

                                    @foreach ($filmes as $filme)
                                    <option {{ $filterByFilme==$filme->id ? 'selected' : '' }} value="{{ $filme->id
                                        }}">{{ $filme->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="data">Sala</label>
                                <select class="form-select" id="sala" name="sala">
                                    <option value="">Todos</option>

                                    @foreach ($salas as $sala)
                                    <option {{ $filterBySala==$sala->id ? 'selected' : '' }} value="{{ $sala->id }}">{{
                                        $sala->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Pesquisar
                                </button>

                                <a href="{{ route('sessoes.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-trash me-1"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Sessões</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Filme</th>
                                <th scope="col">Sala</th>
                                <th scope="col">Data e Hora</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessoes as $sessao)
                            <tr>
                                <th scope="row">{{ $sessao->id }}</th>
                                <td>
                                    <img src="{{ $sessao->filme->getCartazPath() }}" alt="" class="img-fluid me-3"
                                        style="max-width: 75px">
                                    {{ $sessao->filme->titulo }}
                                </td>
                                <td>{{ $sessao->sala->nome }}</td>
                                <td>
                                    {{ $sessao->data }},
                                    {{ $sessao->horario_inicio }}
                                </td>
                                <td>
                                    <a href="{{ route('salas.show', $sessao->id) }}" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('salas.edit', $sessao->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('salas.destroy', $sessao->id) }}" method="post"
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
                        {{ $sessoes->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
