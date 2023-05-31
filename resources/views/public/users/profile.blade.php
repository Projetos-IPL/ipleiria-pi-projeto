@extends('public.layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-md-12">
            Perfil de <span class="fw-bold h3">{{ $user->name }}</span>
        </div>
    </div>
</div>
@endsection
