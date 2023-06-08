@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registar Conta de Cliente</div>

                <div class="card-body">
                    <p class="mb-4">Após criar o seu registo, terá acesso à compra de sessões de filmes, histórico de
                        compras,
                        bilhetes digitais e muito mais.</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <h5>1. Dados gerais</h5>
                        <hr class="mb-4">

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Endereço de email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                <div class="form-text">Iremos enviar um email de confirmação para este endereço.</div>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar
                                Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <h5>2. Dados de faturação</h5>
                        <hr class="mb-4">

                        <div class="row mb-3">
                            <label for="nif" class="col-md-4 col-form-label text-md-end">NIF</label>

                            <div class="col-md-6">
                                <input id="nif" type="text" class="form-control" name="nif" maxlength="9" minlength="9"
                                    pattern="[0-9]{1,9}">

                                @error('nif')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nif" class="col-md-4 col-form-label text-md-end">Método de Pagamento</label>

                            <div class="col-md-6">
                                <select name="tipo_pagamento" id="tipo_pagamento" class="form-select">
                                    <option value="MBWAY">MBWAY</option>
                                    <option value="PAYPAL" selected>PayPal</option>
                                    <option value="VISA">VISA</option>
                                </select>
                                <div class="form-text">Pode sempre alterar mais tarde no seu perfil.</div>

                                @error('tipo_pagamento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="ref_pagamento">
                            <label for="ref_pagamento" class="col-md-4 col-form-label text-md-end">Referência para
                                Pagamento</label>

                            <div class="col-md-6">
                                <input id="ref_pagamento" type="text" class="form-control" name="ref_pagamento"
                                    maxlength="9" minlength="9" pattern="[0-9]{1,9}">

                                @error('ref_pagamento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div class="form-text">Pode sempre alterar mais tarde no seu perfil.</div>
                            </div>
                        </div>

                        <div class="row mb-0 mt-5">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Registar Conta</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function () {
        $('#tipo_pagamento').change(function () {
            if ($(this).val() == 'PAYPAL') {
                $('#ref_pagamento').hide();
            } else {
                $('#ref_pagamento').show();
            }
        });
    });
</script>
@endsection