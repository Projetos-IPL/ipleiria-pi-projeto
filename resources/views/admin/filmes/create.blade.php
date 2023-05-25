@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa-solid fa-video me-3"></i>Novo Filme</h2>
            </div>

            @if($errors->any())
            <div class="alert alert-danger">
                <p>Verifique os dados introduzidos:</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li class="mb-0">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="post" action="{{ route('filmes.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-header">Criar filme</div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-8">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título*</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo"
                                        value="{{ old('titulo') }}" required>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <div>
                                            <label for="ano" class="form-label">Ano*</label>
                                            <input type="text" class="form-control" id="ano" name="ano"
                                                value="{{ old('ano') }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <label for="genero_code" class="form-label">Género</label>
                                            <select class="form-select" id="genero_code" name="genero_code">
                                                @foreach ($generos as $genero)
                                                <option {{ old('genero_code')==$genero->code ? 'selected' : '' }}
                                                    value="{{ $genero->code }}">{{ $genero->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-10">
                                            <label for="trailer_url" class="form-label">URL do Trailer</label>
                                            <input type="text" class="form-control" id="trailer_url" name="trailer_url"
                                                value="{{ old('trailer_url') }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label for="sumario" class="form-label">Sumário</label>
                                    <textarea class="form-control" id="sumario" name="sumario"
                                        rows="6">{{ old('sumario') }}</textarea>
                                </div>
                            </div>

                            <div class="col-4">
                                <div>
                                    <label for="cartaz_url" class="form-label">Alterar cartaz</label>
                                    <input type="file" class="form-control" id="cartaz_url" name="cartaz_url">
                                    <div class="form-text">O cartaz deve ter uma dimensão de 500x750px.</div>

                                    @error('cartaz_url')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-2">
                                <a href="{{ route('filmes.index') }}" class="btn btn-dark d-block">
                                    <i class="fa-solid fa-left-long me-2"></i> Voltar à lista
                                </a>
                            </div>
                            <div class="col-10 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check me-2"></i> Guardar alterações
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection