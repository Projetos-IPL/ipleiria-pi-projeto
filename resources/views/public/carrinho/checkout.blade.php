@extends('public.layouts.app')

@section('content')
<style>
    span {
        font-weight: bold;
    }

    td>p {
        line-height: 1;
    }

    ul>li {
        list-style: none;
        margin-left: 0;
    }

    ul {
        padding-left: 0;
    }
</style>

<div class="row my-5">
    <div class="col-5">
        <h2 class="mb-3">Checkout</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Sessão</th>
                    <th>Lugar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                @php
                $sessao = \App\Models\Sessao::find($item["sessao_id"]);
                @endphp
                <tr>
                    <td>
                        <p><span>Filme:</span> {{ $sessao->filme->titulo }}</p>
                        <p><span>Data e Hora:</span> {{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}
                            - {{
                            \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }}</p>
                        <p><span>Sala:</span> {{ $sessao->sala->nome }} ({{ $sessao->sala->id }})</p>
                        <small>#{{ $sessao->id }}</small>
                    </td>
                    <td>
                        <ul>
                            @foreach ($item["lugares"] as $lugar)
                            <li>
                                @php $lugar = collect($lugar) @endphp
                                {{ $lugar[1] }}{{ $lugar[2] }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end">
                        <span>Total sem IVA:</span> {{ number_format($valorBilhete * $quantidadeBilhetes, 2, ',', '.')
                        }}€
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-end">
                        <span>Percentagem de IVA:</span> {{ $valorIva }}%
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-end pt-3">
                        <h5>
                            <span>Valor a pagar:</span>
                            {{ number_format($valorTotal, 2, ',', '.') }}€
                        </h5>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class=" col-1">
    </div>

    <div class="col-5">
        @if (session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
        @endif

        <form method="post" action="{{ route('carrinho.checkout') }}">
            @csrf

            <input type="hidden" name="preco_total_sem_iva" value="{{ $valorBilhete * $quantidadeBilhetes }}">
            <input type="hidden" name="percentagem_iva" value="{{ $valorIva }}">
            <input type="hidden" name="preco_total_com_iva" value={{ $valorTotal }}>

            <h2 class="mb-3">Dados do Cliente</h2>

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" name="name" readonly value="{{ auth()->user()->name }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" readonly value="{{ auth()->user()->email }}">
            </div>
            <div class="mb-3">
                <label for="nif" class="form-label">NIF</label>
                <input type="text" class="form-control" name="nif" readonly value="{{ auth()->user()->cliente->nif }}">
            </div>


            <h2 class="mb-3 mt-5">Dados de Pagamento</h2>
            <p class="mb-4">Pode alterar o método de pagamento <a href="{{ route('utilizadores.publicProfile') }}">no
                    seu perfil</a>.
            </p>

            @if (auth()->user()->cliente->tipo_pagamento == "VISA")
            <div class="row" id="cartao">
                <div class="col-8">
                    <div class="mb-3">
                        <label for="numero_cartao" class="form-label">Número de Cartão</label>
                        <input type="text" class="form-control" name="numero_cartao" placeholder="1111111111111111"
                            value="{{ auth()->user()->cliente->ref_pagamento }}" readonly>
                        <div class="form-text">16 digítos, localizado na frente do cartão</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="cvc" class="form-label">CVC</label>
                        <input type="text" class="form-control" name="cvc" placeholder="123" maxlength="3">
                        <div class="form-text">3 digítos, localizado no verso do cartão</div>
                    </div>
                </div>
            </div>
            @elseif (auth()->user()->cliente->tipo_pagamento == "MBWAY")
            <div class="mb-3" id="mbway">
                <label for="name" class="form-label">Número de Telemóvel</label>
                <input type="text" class="form-control" name="numero_telemovel" placeholder="912345678"
                    value="{{ auth()->user()->cliente->ref_pagamento }}">
                <div class="form-text">9 digítos, sem indicativo</div>
            </div>
            @else
            <div class="mb-3" id="paypal">
                <h5>Paypal</h5>
                Iremos debitar o valor da sua conta PayPal associada ao seu endereço de email.
            </div>
            @endif

            <div class="row mt-5">
                <div class="col text-end">
                    <button class="btn btn-dark" type="submit">
                        <i class="fas fa-check me-1"></i> Confirmar e Pagar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
