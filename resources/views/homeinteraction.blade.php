
@extends('layouts.home')

@section('main')


<div role="main" class="main">

	<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
		<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
		<div class="container pt-lg-5 mt-5">
			<div class="row pt-3 pb-lg-0 pb-xl-0">
				<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
					<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
						<li><a href="{{route('welcome')}}">Inicio</a></li>
						<li class="text-color-primary"><a href="#">Respuesta de mensaje</a></li>
						
					</ul>
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">MENSAJES</h1>
					
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">VER <i class="fas fa-arrow-down ms-1"></i></a>
					
				</div>

			</div>
		</div>
	</section>
	
	
	
	
	
	
<div role="main" class="main" id="ver">

<section class="section section-height-2 border-0 mt-5 mb-0 pt-5">

		<div class="container py-2">
			<div class="row mt-3 pb-4">
				<div class="col text-center">
					<h2 class="font-weight-bold mb-0">Mensajes de {{ $publicacion->user->name }} {{ $publicacion->user->last_name }} por la publicación de {{ $publicacion->categoria->name }}</h2>
				</div>
			</div>

			@if (Session::has('message'))
			<div class="alert alert-success">
				<p>{{ Session::get('message') }}</p>
			</div>
			@endif
			@if (Session::has('error'))
			<div class="alert alert-danger">
				<p>{{ Session::get('error') }}</p>
			</div>
			@endif
			
			
			@foreach($mensajes_all as $mensaje)
                @if($mensaje->is_reply==false)
			
				<div class="col-lg-12 order-1 order-lg-2"> 
					<div class="row">
						<div class="form-group col-lg-6">
							<div class="alert alert-info">
								<strong>Cliente {{ $interactionhead->name }} {{ $interactionhead->last_name }}: </strong> {{ $mensaje->message }} 
								@foreach($mensaje->imagenes as $imagen)
									<div class="lightbox" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}, 'mainClass': 'mfp-with-zoom', 'zoom': {'enabled': true, 'duration': 300}}">
										<a class="d-inline-block img-thumbnail img-thumbnail-no-borders img-thumbnail-hover-icon mb-1 me-1" href="{{ asset($imagen->url) }}">
										<img class="img-fluid" src="{{ asset($imagen->url) }}" alt="Titulo" width="110" height="110">
										</a>
									</div>
									@endforeach
									<br>
									<small class="text-muted">{{ $mensaje->date }}</small>
							</div>
						</div>
						<div class="form-group col-lg-6 text-end ">
						</div>
					</div>
										
					@else
					<div class="row">
						<div class="form-group col-lg-6">
						</div>
						<div class="form-group col-lg-6 text-end ">
							<div class="alert alert-warning">
							<strong>Yo digo: </strong> {{ $mensaje->message }}.
							<div class="lightbox" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}, 'mainClass': 'mfp-with-zoom', 'zoom': {'enabled': true, 'duration': 300}}">
								@foreach($mensaje->imagenes as $imagen)
								<a class="d-inline-block img-thumbnail img-thumbnail-no-borders img-thumbnail-hover-icon mb-1 me-1" href="{{ asset($imagen->url) }}">
								<img class="img-fluid" src="{{ asset($imagen->url) }}" alt="Titulo" width="110" height="110">
								</a>
								@endforeach
							</div>
							<small class="text-muted">{{ $mensaje->date }}</small>
						</div>
					</div>
					

				</div>
				@endif
				@endforeach
				<form class="contact-form"  action="{{ route('interaction_publicacion_respuesta', ['hash'=> $interactionhead->hash]) }}" method="POST" enctype="multipart/form-data" >
					{{ method_field('PUT') }}
					@csrf
					<input type="hidden" value="{{ $interactionhead->id }}" name="interactionhead_id" >
					<div class="form-group col">
						<label class="form-label mb-1 text-2">Adjuntar Imagen</label>
						<input type="file" maxlength="100" class="form-control text-3 h-auto py-2" name="file[]" multiple="multiple">
					</div>
					<div class="row">
						<div class="form-group col">
							<label class="form-label mb-1 text-2">Mensaje</label>
							<textarea maxlength="5000" data-msg-required="Por favor, ingrese su mensaje o consulta." rows="8" class="form-control text-3 h-auto py-2" name="respuesta" required></textarea>
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<button type="submit" class="btn btn-primary btn-modern">Responder</button>        
						</div>
					</div>
				</form>

		</div>	
</section>
</div>
</div>
@endsection