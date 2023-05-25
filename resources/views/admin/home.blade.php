@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <p>Funcionalidade feita:</p>
                    <ul>
                        <li>Filmes</li>
                        <li>Género</li>
                        <li>Utilizadores</li>
                        <li>Configuração</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection