@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa-solid fa-tag me-3"></i>{{ $genero->nome }}</h2>
            </div>

            <div class="card">
                <div class="card-header">Visualizar género</div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-8">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"
                                    value="{{ $genero->nome }}" readonly>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div>
                                        <label for="ano" class="form-label">Código</label>
                                        <input type="text" class="form-control" id="ano" name="ano"
                                            value="{{ $genero->code }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <h4 class="mb-3">Filmes do género {{ $genero->nome }}</h4>

                            @if ($filmes->isEmpty())
                            <p>Sem filmes para este género.</p>
                            @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Título</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($filmes as $filme)
                                    <tr>
                                        <th scope="row">{{ $filme->id }}</th>
                                        <td>
                                            <a href="{{ route('filmes.show', $filme->id) }}" class="text-dark">{{
                                                $filme->titulo }}</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2">
                            <a href="{{ route('generos.index') }}" class="btn btn-dark d-block">
                                <i class="fa-solid fa-left-long me-2"></i> Voltar à lista
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection