@extends('admin.layouts.app')

@section('styles')
<style>
    .fila {
        background-color: #555;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        width: 75px;
        text-align: center;
    }

    .posicao {
        background-color: #000;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        width: 40px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="mb-4">
                <h2><i class="fa fa-people-roof me-3"></i>{{ $sala->nome }}</h2>
            </div>

            <form method="post" action="{{ route('salas.update', $sala->id) }}">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">Visualizar sala</div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-9">
                                <div>
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        value="{{ $sala->nome }}" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div>
                                    <label for="lotacao" class="form-label">Lotação</label>
                                    <input type="text" class="form-control" id="lotacao" name="lotacao"
                                        value="{{ $sala->getLotacao() }}" readonly>
                                    <div class="form-text">Este valor é calculado automaticamente.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h4 class="mb-3">Esquema da Sala</h4>

                                @include('admin.partials._sala', ['sala' => $sala])

                                <small>Nota: os lugares são estáticos, i.e. não podem ser
                                    adicionados/alterados/removidos após a criação da sala.</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-2">
                                <a href="{{ route('salas.index') }}" class="btn btn-dark d-block">
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
