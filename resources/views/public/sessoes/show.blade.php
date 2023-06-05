@extends('public.layouts.app')

@section('content')
<div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-4">
        <img src="{{ $filme->getCartazPath() }}" alt="{{ $filme->titulo }}" class="img-fluid rounded">
    </div>
    <div class="col-lg-8">
        <h1>{{ $filme->titulo }}</h1>
        <p>{{ $filme->genero->nome }} | {{ $filme->ano }}</p>

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
    <div class="col-md-4">
        <h3 class="mb-4">Sessões disponíveis</h3>
        <div class="list-group">
            @foreach($filme->sessoes as $sessao)
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        {{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }} às
                        {{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}
                    </h5>
                    <div>
                        <span class="badge text-bg-success"></span>
                    </div>
                </div>
                <small>Sala {{ $sessao->sala->nome }} ({{ $sessao->sala->id }})</small>

                <div class="mt-3 mb-2">
                    <a class="btn btn-sm btn-danger" href="{{ route('sessoes.buy', $sessao->id) }}">
                        <i class="fa-solid fa-ticket me-1"></i> Comprar
                    </a>
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
@endsection
