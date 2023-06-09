@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header">Controlo de Acesso</div>
                <div class="card-body mt-2">
                    <div class="row">
                        <div class="col">
                            <h5 class="mb-4 fw-bold">Sessão</h5>
                            <div class="mb-3">
                                <form method="GET">
                                    <label for="data" class="form-label">Data</label>
                                    <select name="data" id="data" class="form-select" onchange="this.form.submit()">
                                        <option value="" selected>Selecione uma data</option>
                                        @foreach ($datas as $data)
                                        <option value="{{ $data }}" {{ $dataQuery==$data ? 'selected' : '' }}>
                                            {{ $data }}
                                        </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <div class="mb-3">
                                <label for="sessao_id" class="form-label">Sessão</label>
                                <select name="sessao_id" id="sessao_id" class="form-select">
                                    <option value="" selected>Selecione uma sessão</option>
                                    @foreach ($sessoes as $sessao)
                                    <option value="{{ $sessao->id }}">
                                        {{ $sessao->filme->titulo }} - {{ $sessao->sala->nome }}
                                        - {{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="mb-4 fw-bold">Estatística</h5>
                            <div class="row text-center text-uppercase">
                                <div class="col">
                                    <h4 id="totais">-</h4>
                                    <p>bilhetes totais</p>
                                </div>
                                <div class="col">
                                    <h4 id="confirmados">-</h4>
                                    <p>bilhetes confirmados</p>
                                </div>
                                <div class="col">
                                    <h4 id="por_confirmar">-</h4>
                                    <p>bilhetes por confirmar</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="mb-5">

                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-4 fw-bold">ID do bilhete</h5>
                            <div class="row">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="bilhete_id" id="bilhete_id">
                                    <button class="btn btn-dark" type="button" id="bilhete_id_btn">
                                        <i class="fas fa-search me-1"></i> Pesquisar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-4 fw-bold">Resultado</h5>

                            <div class="row">
                                <div class="col">
                                    <h4 id="resultado">
                                        <span class="text-light bg-success fw-bold p-2 d-none">PERMITIDO</span>
                                        <span class="text-light bg-danger fw-bold p-2 d-none">NEGADO</span>
                                    </h4>

                                    <div class="btn-group mt-3" role="group" id="opcoes">
                                        <form method="POST" id="form_opcoes">
                                            @csrf
                                            <button class="btn btn-primary" data-opcao="1">
                                                Permitir
                                            </button>
                                            <button class="btn btn-primary" data-opcao="0">
                                                Negar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col">
                                    <ul id="dados_bilhete"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="module">
    $(document).ready(function() {
        // get counters as dom objects
        let totais = $('#totais');
        let confirmados = $('#confirmados');
        let por_confirmar = $('#por_confirmar');
        let opcoes = $('#opcoes');

        // start with opcoes hidden
        opcoes.hide();

        $('#sessao_id').on('change', function() {
            let sessao_id = $(this).val();

            $.ajax({
                url: `/api/sessoes/${sessao_id}`,
                method: 'GET',
                success: function(response) {
                    totais.text(response.total_bilhetes);
                    confirmados.text(response.total_confirmados);
                    por_confirmar.text(response.total_por_confirmar);
                }
            });
        });

        $('#bilhete_id_btn').on('click', function(e) {
            e.preventDefault();

            let sessao_id = $('#sessao_id').val();
            let bilhete_id = $('#bilhete_id').val();

            $.ajax({
                url: `/api/sessoes/${sessao_id}/bilhete/${bilhete_id}`,
                method: 'GET',
                error: function(response) {
                    alert("Bilhete inválido!");
                    return;
                },
                success: function(response) {
                    let resultado = $('#resultado');
                    let dados = $('#dados_bilhete');

                    if (response.permitido) {
                        resultado.children().addClass('d-none');
                        resultado.children('.bg-success').removeClass('d-none');
                    } else {
                        resultado.children().addClass('d-none');
                        resultado.children('.bg-danger').removeClass('d-none');
                    }

                    dados.html(`
                        <li><strong>Nome:</strong> ${response.dados.nome}</li>
                        <li><strong>Estado:</strong> ${response.dados.estado}</li>
                        <li><img src='${response.dados.foto}'></li>
                    `);

                    if (response.dados.estado == "usado")
                    {
                        opcoes.hide();
                    }
                    else
                    {
                        opcoes.show();
                    }

                    $('#form_opcoes').on('submit', function(e) {
                        e.preventDefault();

                        let estado = $(this).find('button:focus').data('opcao');

                        $.ajax({
                            url: `/api/sessoes/${sessao_id}/bilhete/${bilhete_id}/estado`,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                estado: estado
                            },
                            success: function(response) {
                                if (response.permitido) {
                                    resultado.children().addClass('d-none');
                                    resultado.children('.bg-success').removeClass('d-none');
                                } else {
                                    resultado.children().addClass('d-none');
                                    resultado.children('.bg-danger').removeClass('d-none');
                                }

                                opcoes.hide();

                                $.ajax({
                                    url: `/api/sessoes/${sessao_id}`,
                                    method: 'GET',
                                    success: function(response) {
                                        totais.text(response.total_bilhetes);
                                        confirmados.text(response.total_confirmados);
                                        por_confirmar.text(response.total_por_confirmar);
                                    }
                                });
                            }
                        });
                    });
                }
            });

            $.ajax({
                url: `/api/sessoes/${sessao_id}`,
                method: 'GET',
                success: function(response) {
                    totais.text(response.total_bilhetes);
                    confirmados.text(response.total_confirmados);
                    por_confirmar.text(response.total_por_confirmar);
                }
            });
        });
    });
</script>
@endsection