@extends('public.layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <div class="mb-4">
                <h5 class="mb-0 pb-0">Olá,</h5>
                <h2 class="mt-0 fw-bold">{{ $user->name }}</h2>
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

            @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
            @endif

            <!-- 1.ª Linha -->
            <form method="post" action="{{ route('utilizadores.updatePublicProfile', $user->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nome*</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}">
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <div>
                                                    <label for="email" class="form-label">Email*</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="tipo" class="form-label">Tipo</label>
                                                <select class="form-select" id="tipo" disabled>
                                                    <option {{ $user->tipo=='C' ? 'selected' : '' }} value="C">Cliente
                                                    </option>
                                                    <option {{ $user->tipo=='F' ? 'selected' : '' }}
                                                        value="F">Funcionário
                                                    </option>
                                                    <option {{ $user->tipo=='A' ? 'selected' : '' }}
                                                        value="A">Administrador
                                                    </option>
                                                </select>

                                                <input type="hidden" name="tipo" value="{{ $user->tipo }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <div>
                                                    <label for="nif" class="form-label">NIF</label>
                                                    <input type="text" class="form-control" id="nif" name="nif"
                                                        value="{{ $user->cliente->nif }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div>
                                                    <label for="tipo_pagamento" class="form-label">Método de
                                                        Pagamento</label>
                                                    <select class="form-select" id="tipo_pagamento"
                                                        name="tipo_pagamento">
                                                        <option {{ $user->cliente->tipo_pagamento=='VISA' ? 'selected'
                                                            :
                                                            '' }} value="VISA">Cartão de Crédito (VISA)</option>
                                                        <option {{ $user->cliente->tipo_pagamento=='PAYPAL' ?
                                                            'selected' :
                                                            '' }} value="PAYPAL">PayPal</option>
                                                        <option {{ $user->cliente->tipo_pagamento=='MBWAY' ?
                                                            'selected'
                                                            : '' }} value="MBWAY">MB Way</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                @if (auth()->user()->cliente->tipo_pagamento == "VISA")
                                                <div class="mb-3">
                                                    <label for="ref_pagamento" class="form-label">Número de
                                                        Cartão</label>
                                                    <input type="text" class="form-control" name="ref_pagamento"
                                                        placeholder="1111111111111111"
                                                        value="{{ auth()->user()->cliente->ref_pagamento }}" required>
                                                    <div class="form-text">16 digítos, localizado na frente do
                                                        cartão</div>
                                                </div>
                                                @elseif (auth()->user()->cliente->tipo_pagamento == "MBWAY")
                                                <div class="mb-3" id="mbway">
                                                    <label for="ref_pagamento" class="form-label">Número de
                                                        Telemóvel</label>
                                                    <input type="text" class="form-control" name="ref_pagamento"
                                                        placeholder="912345678"
                                                        value="{{ auth()->user()->cliente->ref_pagamento }}" required>
                                                    <div class="form-text">9 digítos, sem indicativo</div>
                                                </div>
                                                @else
                                                <div class="mb-3" id="paypal">
                                                    <h5>Paypal</h5>
                                                    Iremos debitar o valor da sua conta PayPal associada ao seu endereço
                                                    de email.
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <!-- password fields -->
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Nova Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Nova Password
                                                (confirmação)</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-check me-2"></i> Guardar alterações
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <a href="{{ $user->getAvatarPath() }}" target="_blank">
                                        <img src="{{ $user->getAvatarPath() }}" class="img-fluid rounded-circle"
                                            style="max-width: 128px;">
                                    </a>
                                </div>

                                <div class="mt-4">
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
                </div>

                <!-- 2.ª Linha -->
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1">
                                        Data de registo: <span class="fw-bold">{{
                                            \Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y') }}</span>
                                    </li>
                                    <li class="mb-0">
                                        Última atualização: <span class="fw-bold">{{
                                            \Carbon\Carbon::parse(Auth::user()->updated_at)->format('d M Y, H:i:s')
                                            }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection