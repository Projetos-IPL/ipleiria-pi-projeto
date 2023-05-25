@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa-solid fa-users me-3"></i>{{ $user->name }}</h2>
            </div>

            <div class="card">
                <div class="card-header">Visualizar utilizador</div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome*</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                                    readonly>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div>
                                        <label for="email" class="form-label">Email*</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select class="form-select" id="tipo" name="tipo" disabled>
                                        <option {{ $user->tipo=='C' ? 'selected' : '' }} value="C">Cliente
                                        </option>
                                        <option {{ $user->tipo=='F' ? 'selected' : '' }} value="F">Funcionário
                                        </option>
                                        <option {{ $user->tipo=='A' ? 'selected' : '' }} value="A">Administrador
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="bloqueado"
                                        name="bloqueado" {{ $user->bloqueado=="1" ? "checked" : "" }} disabled>
                                    <label class="form-check-label" for="bloqueado">Bloqueado</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <a href="{{ $user->getAvatarPath() }}" target="_blank">
                                <img src="{{ $user->getAvatarPath() }}" class="img-fluid">
                            </a>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2">
                            <a href="{{ route('utilizadores.index') }}" class="btn btn-dark d-block">
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