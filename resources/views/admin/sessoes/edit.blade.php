@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa fa-clapperboard me-3"></i>Sessão #{{ $sessao->id }}</h2>
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

            <form method="post" action="{{ route('sessoes.update', $sessao->id) }}">
                @csrf
                @method('put')

                <div class="card">
                    <div class="card-header">Editar sessão</div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-8">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="filme_id" class="form-label">Filme*</label>
                                        <input type="text" class="form-control" name="filme_id" id="filme_id"
                                            value="{{ $sessao->filme->titulo }}" readonly>
                                        <input type="hidden" name="filme_id" value="{{ $sessao->filme->id }}">
                                    </div>
                                    <div class="col">
                                        <label for="sala_id" class="form-label">Sala*</label>
                                        <select name="sala_id" id="sala_id" class="form-select" disabled>
                                            <option value="">-- Escolha uma sala --</option>
                                            @foreach ($salas as $sala)
                                            <option {{ $sessao->sala_id==$sala->id ? 'selected' : '' }}
                                                value="{{ $sala->id }}">{{ $sala->nome }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="sala_id" value="{{ $sessao->sala->id }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="data" class="form-label">Data*</label>
                                        <input type="text" name="data" id="data" class="form-control"
                                            value="{{ $sessao->data }}">
                                        <div class="form-text">Data no formato YYYY-MM-DD.</div>
                                    </div>
                                    <div class="col">
                                        <label for="horario_inicio" class="form-label">Hora*</label>
                                        <input type="time" name="horario_inicio" id="horario_inicio"
                                            class="form-control" value="{{ $sessao->horario_inicio }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <img id="cartaz" src="{{ $sessao->filme->getCartazPath() }}" class="img-fluid ms-5"
                                    style="max-width: 250px">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-2">
                                <a href="{{ route('sessoes.index') }}" class="btn btn-dark d-block">
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
