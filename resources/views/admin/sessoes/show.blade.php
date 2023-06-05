@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa fa-people-roof me-3"></i>Sessão #{{ $sessao->id }}</h2>
            </div>

            <div class="card">
                <div class="card-header">Visualizar sessão</div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-8">
                            <div>
                                <label for="filme" class="form-label">Filme</label>
                                <input type="text" class="form-control" id="filme" name="filme"
                                    value="{{ $sessao->filme->titulo }}" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <label for="bilhetes_count" class="form-label">Bilhetes Vendidos</label>
                                <input type="text" class="form-control" id="bilhetes_count" name="bilhetes_count"
                                    value="{{ $sessao->bilhetes->count() }}" readonly>
                                <div class="form-text">Este valor é calculado automaticamente.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div>
                                <label for="sala" class="form-label">Sala</label>
                                <input type="text" class="form-control" id="sala" name="sala"
                                    value="{{ $sessao->sala->nome }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <label for="data" class="form-label">Data</label>
                                <input type="date" class="form-control" id="data" name="data"
                                    value="{{ $sessao->data }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <label for="horario_inicio" class="form-label">Horário de Início</label>
                                <input type="time" class="form-control" id="horario_inicio" name="horario_inicio"
                                    value="{{ $sessao->horario_inicio }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <h3 class="mb-4">Bilhetes</h3>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Lugar</th>
                                        <th scope="col">Preço com IVA</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bilhetes as $bilhete)
                                    <tr>
                                        <td>{{ $bilhete->id }}</td>
                                        <td>{{ $bilhete->recibo->cliente != null ?
                                            $bilhete->recibo->cliente->user->name
                                            : 'Cliente removido' }}</td>
                                        <td>{{ $bilhete->lugar->getPrettyLugar() }}</td>
                                        <td>{{ $bilhete->getPrecoComIva() }} €</td>
                                        <td>
                                            @if ($bilhete->estado == 'usado')
                                            <span class="badge bg-success">Usado</span>
                                            @elseif ($bilhete->estado == 'não usado')
                                            <span class="badge bg-danger text-light">Não Usado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('bilhetes.showPDF', $bilhete->id) }}"
                                                class="btn btn-sm btn-primary me-1">
                                                <i class="fa-solid fa-file-pdf me-2 fa-lg"></i>
                                                Bilhete
                                            </a>
                                            <a href="{{ $bilhete->recibo->recibo_pdf_url }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fa-solid fa-file-pdf me-2 fa-lg"></i>
                                                Recibo
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $bilhetes->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2">
                            <a href="{{ route('sessoes.index') }}" class="btn btn-dark d-block">
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
