@extends('layouts.home')

@section('main')

<section
        class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8"
        style="background-image: url({{ asset('img/slides/slide-bg-4.jpg') }}); background-size: cover; background-position: center; min-height: 645px;">
        <div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
        <div class="container pt-lg-5 mt-5">
            <div class="row pt-3 pb-lg-0 pb-xl-0">
                <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                    <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                        <li><a href="{{ route('welcome') }}">Inicio</a></li>
                        <li class="text-color-primary"><a href="#">Panel de control</a></li>

                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Detalle de encuesta</h1>

                    <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100"
                        class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver
                        <i class="fas fa-arrow-down ms-1"></i></a>


                </div>

            </div>
        </div>
</section>	

<div role="main" class="main" id="ver"></div> 

@if(isset($survey))
<div class="container pt-3 pb-2">
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Survey Information -->
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Información básica</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Fecha de última actualización:</strong> {{ $survey->updated_at }}</li>
                        <li class="list-group-item"><strong>Nombre del cliente:</strong> {{ $survey->client_name }}</li>
                        <li class="list-group-item"><strong>Celular:</strong> {{ $survey->client_cellphone }}</li>
                        <li class="list-group-item">
                            <strong>Concretó servicio:</strong> 
                            @if($survey->service_provided)
                                Sí
                            @else
                                No
                            @endif
                        </li>
                    </ul>
                    <form action="{{ route('admin_delete_survey', $survey->id) }}" method="POST" style="margin-top: 20px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta encuesta?')">Eliminar encuesta</button>
                    </form>
                </div>
            </div>

            <!-- Survey Answers Section -->
            <h4 class="mt-5">Respuestas de la encuesta</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Calificación:</strong> {{ $survey->satisfaction }}</li>
                <li class="list-group-item"><strong>Palabras positivas:</strong>
                    @if($survey->descriptive_words)
                        @foreach($survey->positiveWords() as $word)
                            {{ $word }}@if (!$loop->last) - @endif
                        @endforeach
                    @else
                        -
                    @endif
                </li>
                <li class="list-group-item"><strong>Sugerencias para mejorar:</strong>
                    @if($survey->negative_words)
                        @foreach($survey->negativeWords() as $word)
                            {{ $word }}@if (!$loop->last) - @endif
                        @endforeach
                    @else
                        -
                    @endif
                </li>
                <li class="list-group-item"><strong>Razón por la que no concretó:</strong>
                    @if($survey->no_agreement)
                        @foreach($survey->reasonNoAgree() as $word)
                            {{ $word }}@if (!$loop->last) - @endif
                        @endforeach
                    @else
                        -
                    @endif
                </li>
                <li class="list-group-item"><strong>Reseña:</strong>
                    @if($survey->review)
                        {{ $survey->review }}
                    @else 
                        -
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
@else
<div class="container card col-md-4 p-4 rounded-lg shadow-md">
        <strong class="text-xl text-center">Esta encuesta no existe o ha sido eliminada</strong>
</div>
@endif
@endsection
