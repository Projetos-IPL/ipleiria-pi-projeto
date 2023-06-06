@extends('public.layouts.app')

@section('content')
<style>
    #capa {
        max-width: 250px;
    }
</style>

<div class="row my-5">
    <div class="col-12">
        @if (session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
        @endif

        <form method="post" action="{{ route('carrinho.addItem') }}">
            @csrf

            <h4>1. Sessão</h4>
            <hr class="mt-0 mb-4">

            <div class="row g-3">
                <div class="col-sm-3">
                    <label class="form-label fw-bold">Filme</label>
                    <p>{{ $sessao->filme->titulo }}</p>
                </div>

                <div class="col-sm-3">
                    <label class="form-label fw-bold">Data e Hora</label>
                    <p>
                        {{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }} às
                        {{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}
                    </p>
                </div>

                <div class="col-sm-3">
                    <label class="form-label fw-bold">Sala</label>
                    <p>{{ $sessao->sala->nome }} ({{ $sessao->sala->id }})</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-3">
                    <label for="quantidade" class="form-label fw-bold">Quantidade de bilhetes</label>
                    <select name="quantidade" id="quantidade" class="form-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <div class="form-text">Máximo 5 por compra.</div>
                </div>
            </div>

            <h4 class="mt-5">2. Seleção de lugares</h4>
            <hr class="mt-0 mb-4">

            <p>
                Para selecionar um lugar, clique no lugar pretendido.
                Lugares com fundo vermelho estão reservados.
                Para alterar um lugar selecionado, clique nele e selecione outro.
            </p>

            @include('public.partials._lugares', ['sala' => $sessao->sala, 'ocupados' => $ocupados])

            <input type="hidden" name="sessao_id" value="{{ $sessao->id }}">
            <input type="hidden" name="sala_id" value="{{ $sessao->sala_id }}">

            <div class="row col-3 float-end">
                <button class="btn btn-dark mt-3" type="submit">
                    <i class="fa-solid fa-cart-shopping me-1"></i>
                    Adicionar ao carrinho
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
