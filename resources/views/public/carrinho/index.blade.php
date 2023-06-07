@extends('public.layouts.app')

@section('content')
<style>
    td>p>span {
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
    <div class="col-12">
        @if (session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
        @endif

        <h2 class="mb-4">
            <i class="fa-solid fa-cart-shopping me-1"></i>
            Carrinho
        </h2>

        @if ($cart->isEmpty())
        <div class="alert alert-secondary">
            O carrinho está vazio. <a href="{{ route('sessoes.indexPublic') }}">Veja as sessões em cartaz.</a>
        </div>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Sessão</th>
                    <th>Lugar</th>
                    <th>Ações</th>
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
                        <p>
                            <span>
                                Data e Hora:</span>
                            {{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }} -
                            {{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}
                        </p>
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
                    <td>
                        <!-- button to remove the item from the cart -->
                        <form action="{{ route('carrinho.removeItem', $sessao->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash me-1"></i>
                                Remover
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row col-3 float-end mt-4">
            <a href="{{ route('carrinho.showCheckout') }}" class="btn btn-dark" type="submit">
                <i class="fa-solid fa-cart-shopping me-1"></i>
                Finalizar compra
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
