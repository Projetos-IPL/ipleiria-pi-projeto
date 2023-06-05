@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header">Controlo de Acesso</div>
                <div class="card-body mt-2">
                    <form id="pesquisa">
                        <div class="row">
                            <div class="col">
                                <h5 class="mb-4">Sessão</h5>
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
                            <div class="col">
                                <h5 class="mb-4">Estatística</h5>
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
                                <h5 class="mb-4">ID do bilhete</h5>
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="bilhete_id" id="bilhete_id">
                                        <button class="btn btn-dark" type="submit">
                                            <i class="fas fa-search me-1"></i> Pesquisar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-4">Resultado</h5>

                                <div class="row">
                                    <div class="col">
                                        <h4 id="resultado">
                                            <span class="text-light bg-success fw-bold p-2 d-none">PERMITIDO</span>
                                            <span class="text-light bg-danger fw-bold p-2 d-none">NEGADO</span>
                                        </h4>
                                    </div>
                                    <div class="col">
                                        <ul id="dados_bilhete"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

        // on form submission, ajax request to /api/sessoes/{sessao_id}/bilhete/{bilhete_id}
        $('#pesquisa').on('submit', function(e) {
            e.preventDefault();

            let sessao_id = $('#sessao_id').val();
            let bilhete_id = $('#bilhete_id').val();

            $.ajax({
                url: `/api/sessoes/${sessao_id}/bilhete/${bilhete_id}`,
                method: 'GET',
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

                    // update dados_bilhete with the name and estado from the response data array
                    dados.html(`
                        <li><strong>Nome:</strong> ${response.dados.nome}</li>
                        <li><strong>Estado:</strong> ${response.dados.estado}</li>
                    `);
                },
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