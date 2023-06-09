@extends('public.layouts.app')

@section('content')
<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-4">
        <img src="{{ $filme->getCartazPath() }}" alt="{{ $filme->titulo }}" class="img-fluid rounded shadow">
    </div>
    <div class="col-lg-8">
        <h1>{{ $filme->titulo }}</h1>
        <p><span class="fw-bold">Género:</span> {{ $filme->genero->nome }} | <span class="fw-bold">Ano:</span> {{
            $filme->ano }}</p>

        @if ($filme->trailer_url != null)
        <button type="button" class="btn btn-dark p-3 my-3" data-bs-toggle="modal" data-bs-target="#trailerModal">
            <h5 class="m-0"><i class="fa-solid fa-clapperboard me-2"></i> Ver Trailer</h5>
        </button>
        @endif

        <p>{{ $filme->sumario }}</p>
    </div>
</div>

<hr class="my-4" />

<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <h2>Sessões</h2>
    <small>A mostrar {{ $filme->sessoes->count() }} resultados</small>

    <div class="col mt-5">
        <div class="row text-center">
            @foreach($filme->sessoes as $sessao)
            <div class="col-md-3 mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h3>{{ \Carbon\Carbon::parse($sessao->data)->format('d M Y') }}</h3>
                            <h4>{{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}</h4>
                        </div>
                        <div>
                            @php
                            $isFull = $sessao->isFull();
                            @endphp

                            @if ($isFull)
                            <h5 class="mb-0"><span class="badge text-bg-danger pill">Ocupado</span></h5>
                            @else
                            <h5 class="mb-0"><span class="badge text-bg-success pill">Livre</span></h5>
                            @endif
                        </div>

                        @if (!$isFull)

                        @php
                        if (Auth::check()) {
                        $isAvailable = auth()->user()->tipo == 'C';
                        } else {
                        $isAvailable = true;
                        }
                        @endphp

                        <div class="mt-4">
                            <a href="{{ route('sessoes.buy', $sessao->id) }}"
                                class="btn btn-sm btn-outline-secondary {{$isAvailable ? '' : 'disabled' }}">
                                <i class="fa-solid fa-ticket me-2"></i> Comprar Bilhete
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                Sala {{ $sessao->sala->nome }} ({{ $sessao->sala->id }})
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal do trailer -->
<div class="modal fade" id="trailerModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Trailer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe src="https://www.youtube.com/embed/{{ $filme->trailer_url }}" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    style="width: 100%; height: 600px"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    $('#trailerModal').on('hidden.bs.modal', function (e) {
        $('#trailerModal iframe').attr("src", $("#trailerModal iframe").attr("src"));
    });
</script>
@endsection