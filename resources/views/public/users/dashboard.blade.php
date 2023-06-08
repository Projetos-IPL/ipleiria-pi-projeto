@extends('public.layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <div class="mb-5">
                <h2 class="mb-0 pb-0">Dashboard</h2>
                <hr>
            </div>

            <div class="row mb-5">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center justify-content-center"
                                    style="font-size: 2em;">
                                    <i class="fa-solid fa-sack-dollar fa-2xl"></i>
                                </div>

                                @php
                                $percentagemIva = \App\Models\Configuracao::first()->percentagem_iva;
                                $totalBilhetesComIva = $totalBilhetes * (1 + ($percentagemIva / 100));
                                @endphp

                                <div class="col-8 text-right">
                                    <h3>{{ number_format($totalBilhetesComIva, 2, ',', '.') }} €</h3>
                                    <p class="lead mb-0">Total em bilhetes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center justify-content-center"
                                    style="font-size: 2em;">
                                    <i class="fa-solid fa-database fa-2xl"></i>
                                </div>

                                <div class="col-8 text-right">
                                    <h3>{{ $totalBilhetesCount }}</h3>
                                    <p class="lead mb-0">Total de bilhetes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center justify-content-center"
                                    style="font-size: 2em;">
                                    <i class="fa-solid fa-chart-simple fa-2xl"></i>
                                </div>

                                <div class="col-8 text-right">
                                    <p class="lead mb-4">Bilhetes Usados vs. Não Usados</p>

                                    <div class="progress" role="progressbar">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ number_format($percentagemUsados, 2) }}%">{{
                                            number_format($percentagemUsados, 0) }}%</div>
                                        <div class="progress-bar bg-danger"
                                            style="width: {{ number_format($percentagemNaoUsados, 2) }}%">{{
                                            number_format($percentagemNaoUsados, 0) }}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3">Histórico de bilhetes</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Filme</th>
                        <th scope="col">Data e Hora</th>
                        <th scope="col">Sala</th>
                        <th scope="col">Lugar</th>
                        <th scope="col">Preço (s/ IVA)</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bilhetes as $bilhete)
                    <tr>
                        <td>{{ $bilhete->id }}</td>
                        <td>{{ $bilhete->sessao->filme->titulo }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($bilhete->sessao->data)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($bilhete->sessao->horario_inicio)->format('H:i') }}
                        </td>
                        <td>{{ $bilhete->sessao->sala->nome }}</td>
                        <td>{{ $bilhete->lugar->getPrettyLugar() }}</td>
                        <td>{{ $bilhete->preco_sem_iva }} €</td>
                        <td>{{ $bilhete->getPrettyEstado() }}</td>
                        <td>
                            <a href="{{ route('bilhetes.showPDF', $bilhete->id) }}" class="btn btn-sm btn-dark me-1">
                                <i class="fa-solid fa-file-pdf me-2 fa-lg"></i>
                                Bilhete
                            </a>
                            <a href="{{ $bilhete->recibo->recibo_pdf_url }}" class="btn btn-sm btn-secondary">
                                <i class="fa-solid fa-file-pdf me-2 fa-lg"></i>
                                Recibo
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $bilhetes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
