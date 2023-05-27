@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="mb-4">
                <h2><i class="fa-solid fa-cog me-3"></i>Configurações</h2>
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

            <form method="post" action="{{ route('configuracoes.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">Alterar configurações</div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Preço Bilhete (sem IVA)*</label>
                                    <input type="text" class="form-control" id="preco_bilhete_sem_iva"
                                        name="preco_bilhete_sem_iva" value="{{ $configuracao->preco_bilhete_sem_iva }}"
                                        required onchange="atualizarPrecoBilhete(this.value);">
                                </div>
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Percentagem IVA*</label>
                                    <input type="text" class="form-control" id="percentagem_iva" name="percentagem_iva"
                                        value="{{ $configuracao->percentagem_iva }}" required
                                        onchange="atualizarPrecoBilhete(this.value);">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Preço Bilhete (com IVA)</label>
                                    <input type="text" class="form-control" id="preco_bilhete_com_iva" disabled>
                                    <div class="form-text">Este valor é calculado automaticamente.</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check me-2"></i> Guardar alterações
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function atualizarPrecoBilhete(preco_bilhete_sem_iva) {
        var preco_bilhete_com_iva = preco_bilhete_sem_iva * (1 + (document.getElementById('percentagem_iva').value / 100));
        document.getElementById('preco_bilhete_com_iva').value = preco_bilhete_com_iva.toFixed(2);
    }

    atualizarPrecoBilhete(document.getElementById('preco_bilhete_sem_iva').value);
</script>
@endsection
