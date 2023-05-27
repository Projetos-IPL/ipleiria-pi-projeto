@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-header">Utilizadores</div>

                        <div class="card-body">
                            <div class="mt-2">
                                <h1 class="display-6">{{ $totalUsers }}</h1>
                                <h4>Utilizadores ativos</h4>
                            </div>

                            <hr class="my-4">

                            <div class=" row">
                                <div class="col">
                                    <h3>{{ $totalAdminUsers }}</h3>
                                    <p>Administradores</p>
                                </div>
                                <div class="col">
                                    <h3>{{ $totalFuncionarioUsers }}</h3>
                                    <p>Funcionários</p>
                                </div>
                                <div class="col">
                                    <h3>{{ $totalCustomerUsers }}</h3>
                                    <p>Clientes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-header">Filmes</div>

                        <div class="card-body">
                            <div class="mt-2">
                                <h1 class="display-6">{{ $totalFilmes }}</h1>
                                <h4>Filmes ativos</h4>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col">
                                    <h3>{{ $mostPopularGeneroName }}</h3>
                                    <p>Género com mais filmes</p>
                                </div>
                                <div class="col">
                                    <h3>{{ $leastPopularGeneroName }}</h3>
                                    <p>Género com menos filmes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body text-start">
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{ Auth::user()->getAvatarPath() }}" alt="user"
                                            class="rounded-circle img-fluid">
                                    </div>
                                    <div class="col-9">
                                        <h5 class="mb-0">Olá,</h5>
                                        <h3 class="fw-bold">{{ Auth::user()->name }}</h3>
                                    </div>
                                </div>
                            </div>

                            <ul class="list-unstyled">
                                <li class="mb-1">
                                    Perfil: <span class="fw-bold">{{ Auth::user()->getPrettyTipo() }}</span>
                                </li>
                                <li class="mb-1">
                                    Email: <span class="fw-bold">{{ Auth::user()->email }}</span>
                                </li>
                                <li class="mb-1">
                                    Data de registo: <span class="fw-bold">{{
                                        \Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y') }}</span>
                                </li>
                                <li class="mb-1">
                                    Última atualização: <span class="fw-bold">{{
                                        \Carbon\Carbon::parse(Auth::user()->updated_at)->format('d M Y, H:i:s')
                                        }}</span>
                                </li>
                            </ul>

                            <div class="mt-5">
                                <a href="{{ route('utilizadores.edit', Auth::user()->id) }}" class="btn btn-dark">
                                    Editar perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <h2 class="mb-4">Estatística</h2>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Bilhetes</div>

                        <div class="card-body">
                            Bilhetes vendidos, filme mais popular ultimos 7, 14 e 30 dias

                            <p>{{ $totalRevenueValueBeginning }} - total dos bilhetes até à data</p>
                            <p>{{ $totalRevenueValueFiveDays }} - total dos bilhetes dos últimos 5 dias</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Sessões</div>

                        <div class="card-body">
                            Sessões, sessões por filme (top 3/5), sessões por sala, sessões por dia da semana
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
