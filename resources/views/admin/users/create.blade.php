@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa-solid fa-users me-3"></i>Novo Utilizador</h2>
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

            <form method="post" action="{{ route('utilizadores.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-header">Criar utilizador</div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome*</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <div>
                                            <label for="email" class="form-label">Email*</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="tipo" class="form-label">Tipo</label>
                                        <select class="form-select" id="tipo" name="tipo">
                                            <option value="F">Funcionário</option>
                                            <option value="A">Administrador</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="password" class="form-label">Password*</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <label for="password_confirmation" class="form-label">Confirmar
                                            Password*</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="bloqueado"
                                            name="bloqueado">
                                        <label class="form-check-label" for="bloqueado">Bloqueado</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div>
                                    <label for="foto_url" class="form-label">Alterar avatar</label>
                                    <input type="file" class="form-control" id="foto_url" name="foto_url">
                                    <div class="form-text">O avatar deve ter uma dimensão de 128px.</div>

                                    @error('foto_url')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
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
