@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa-solid fa-tag me-3"></i>{{ $genero->nome }}</h2>
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

            <form method="post" action="{{ route('generos.update', $genero->code) }}">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">Alterar género</div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-8">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título*</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        value="{{ $genero->nome }}" required>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <div>
                                            <label for="ano" class="form-label">Código*</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                value="{{ $genero->code }}" required>
                                        </div>
                                    </div>
                                </div>
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