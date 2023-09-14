@extends('layouts.home')

@section('main')


<!-- desde acá-->
<div role="main" class="main">

	<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{ asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
		<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;">
		</div>
			<div class="container pt-lg-5 mt-5">
				<div class="row pt-3 pb-lg-0 pb-xl-0">
					<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
						<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
							<li><a href="{{route('welcome')}}">Inicio</a></li>
							<li class="text-color-primary"><a href="{{ route('homepublicaciones', ['id'=> $publicacion->categoria->id]) }}">{{ $publicacion->categoria->categoriatipo->name }}</a></li>
							<li class="active text-color-primary">{{ $publicacion->categoria->name }}</li>
						</ul>
						<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">{{ $publicacion->categoria->name }}</h1>
						<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
						
					</div>
				</div>
			</div>
	</section>
	
	
	
	
	
	
<div role="main" class="main" id="ver">

	<div class="container pt-5">

		<div class="row py-4 mb-2">
			<div class="col-md-7 order-2">
				<div class="overflow-hidden">
					<h2 class="text-color-dark font-weight-bold text-12 mb-2 pt-0 mt-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="300">{{ $publicacion->user->name}} {{ $publicacion->user->last_name}}</h2>
				</div>
				<div class="overflow-hidden mb-3">
					<p class="font-weight-bold text-primary text-uppercase mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="500">{{ $publicacion->categoria->name }}</p>
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


				<p class="lead appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">{{ $publicacion->description }}</p>
				<p class="pb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800"></p>
				<hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
				<div class="row align-items-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
					<div class="col-lg-8">
						<button class="btn btn-modern btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#defaultModal">
							Ver datos de contacto
						</button>
						<a href="{{ route('prof_publicacion', ['hash_user' => $publicacion->user->hash]) }}" class="btn btn-modern btn-dark mt-3" data-hash data-hash-offset="0" data-hash-offset-lg="100">volver a publicaciones</a>
						@if ($publicacion->doc)
						<a href="{{ $publicacion->doc }}" class="btn btn-modern btn-danger mt-3" target="_blank" data-hash data-hash-offset="0" data-hash-offset-lg="100">Ver certificado</a>	
						@endif
						<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => $origen]) }}" class="btn btn-modern btn-info mt-3" data-hash data-hash-offset="0" data-hash-offset-lg="100">
							@if($publicacion->aprobado == 0)
							Activar publicación
							@else
							Desactivar publicación
							@endif
						</a>
						
					</div>
					<div class="col-sm-4 text-lg-end my-4 my-lg-0">
						@if($publicacion->user->profile->facebook || $publicacion->user->profile->instagram )
						<strong class="text-uppercase text-1 me-3 text-dark">Seguime</strong>
						@endif
						<ul class="social-icons float-lg-end">
							@if($publicacion->user->profile->facebook)
							<li class="social-icons-facebook"><a href="{{ asset($publicacion->user->profile->facebook) }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
							@endif
							@if($publicacion->user->profile->instagram)
							<li class="social-icons-instagram"><a href="{{ asset($publicacion->user->profile->instagram) }}" target="_blank" title="Twitter"><i class="fab fa-instagram"></i></a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-5 order-md-2 mb-4 mb-lg-0 appear-animation" data-appear-animation="fadeInRightShorter">
				<div class="thumb-gallery-wrapper">
					<div class="thumb-gallery-detail owl-carousel owl-theme manual nav-inside nav-style-1 nav-dark mb-3">
						@if ($publicacion->user->avatar) 
						<div>
							<img src="{{ asset($publicacion->user->avatar) }}" class="img-fluid" alt="Presentation">
						</div>	
						@endif
						
						@if($publicacion->imagenes->count() > 0)
							@foreach($publicacion->imagenes as $imagen)
							<div>
								<img src="{{ asset($imagen->url) }}"class="img-fluid" alt="Presentation">
							</div>
							@endforeach
						@endif
						
					</div>
					<div class="thumb-gallery-thumbs owl-carousel owl-theme manual thumb-gallery-thumbs">
						@if ($publicacion->user->avatar)
						<div>
							<span class="d-block cur-pointer">
								<img alt="Presentation" src="{{ asset($publicacion->user->avatar) }}" class="img-fluid">
							</span>
						</div>	
						@endif
						@if($publicacion->cant_images > 0)
							@foreach($publicacion->imagenes as $imagen)
							<div>
								<span class="d-block cur-pointer">
									<img alt="Presentation" src="{{ asset($imagen->url) }}" class="img-fluid">
								</span>
							</div>
							@endforeach
						@endif

					</div>
				</div>
				<!-- hasta acá llega el carrusel -->

			</div>
			
		</div>
	</div>

	

	

</div>		
	
@if(count($publicacion->zonas) > 0)
<section class="featured footer">
	<div class="container">
		<div class="row">
			<div id="zones">
				<h2><i class="bi bi-geo-alt"></i> Zona de cobertura</h2>
				<p class="zones-list">
					@foreach($publicacion->zonas as $zona)
					{{ $zona->name }}@if(!$loop->last),@endif
					@endforeach
				</p>
			</div>
		</div>
	</div>
</section>
@endif
	
	
	
	
	
	
	
	
	
	
	
	
	<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="defaultModalLabel">Datos de contacto del profesional</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
									  <p><strong>{{ $publicacion->user->name}} {{ $publicacion->user->last_name}}</strong><br>
										  <strong>Telefono:</strong> 
										  @if($publicacion->user->profile->mobile)
										  {{ $publicacion->user->profile->mobile }}
										  @endif
										  <br>
										<strong>Mail:</strong> <a href="mailto:{{ $publicacion->user->email }}"> {{ $publicacion->user->email }} </a></p>
										<div class="col-sm-12 text-lg-end my-4 my-lg-0">
						@if($publicacion->user->profile->facebook || $publicacion->user->profile->instagram )
						<strong class="text-uppercase text-1 me-3 text-dark">Seguime</strong>
						@endif
						<ul class="social-icons float-lg-end">
							@if($publicacion->user->profile->facebook)
							<li class="social-icons-facebook"><a href="{{ asset($publicacion->user->profile->facebook) }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
							@endif
							@if($publicacion->user->profile->instagram)
							<li class="social-icons-instagram"><a href="{{ asset($publicacion->user->profile->instagram) }}" target="_blank" title="Twitter"><i class="fab fa-instagram"></i></a></li>
							@endif
							
						</ul>
					</div>
						<hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
						<!-- <p><strong><em>IMPORTANTE:</strong> Al contactar al Profesional está aceptando los términos y condiciones del sitio. Leer <a href="#">condiciones de uso</a>.</em></p> -->
										
										
										
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
									</div>
								</div>
</div>
	
	
	
	
	
	
</div>
@endsection