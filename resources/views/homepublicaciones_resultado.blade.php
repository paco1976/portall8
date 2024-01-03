@extends('layouts.home')

@section('main')

<div role="main" class="main">
				
	<!--Tendría que dejar desde acá -->
		<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{ asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
			<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;">
			</div>
				<div class="container pt-lg-5 mt-5">
					<div class="row pt-3 pb-lg-0 pb-xl-0">
						<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
							<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
								<li><a href="{{route('welcome')}}">Inicio</a></li>
								<li class="text-color-primary"><a href="#">Resultado</a></li>
							</ul>
							<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3"> Resultado de la búsqueda</h1>
							<p class="opacity-7 text-4 negative-ls-05 pb-2 mb-4">¿Estas buscando un profesional?<br>Encontrá todo lo que buscas en nuestro sitio.</p>
							<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver Profesionales <i class="fas fa-arrow-down ms-1"></i></a>
							<a href="{{ route('contacto') }}" class="btn btn-light btn-outline btn-outline-thin btn-outline-light-opacity-2 btn-effect-5 font-weight-semi-bold px-4 btn-py-2 text-3 text-color-light text-color-hover-dark ms-2">Contactanos <i class="fas fa-external-link-alt ms-1"></i></a>
						</div>
					</div>
				</div>
		</section>

		<div id="ver" class="container py-2">

					<div class="row">
						<div class="col">

							@if ($publicaciones_all->count() > 0)
							<div class="alert alert-success">
								<p>Cantidad coincidencias {{ $publicaciones_all->count() }}</p>
							</div>
							@else
							<div class="alert alert-danger">
								<p>Cantidad coincidencias {{ $publicaciones_all->count() }}</p>
							</div>
							@endif
							

						
								<div class="row portfolio-list sort-destination">
									
									@if($publicaciones_all->count() > 0)
									@foreach($publicaciones_all as $publicacion)
									<div class="col-12 col-sm-6 col-lg-3 isotope-item">
										<div class="portfolio-item">
											<a href="{{ route('homeprofesional', ['id'=> $publicacion->id]) }}">
												<span class="thumb-info thumb-info-lighten border-radius-0">
													<span class="thumb-info-wrapper border-radius-0">
														<img src="{{ asset($publicacion->users->avatar) }}" class="img-fluid border-radius-0" alt="">
														<span class="thumb-info-title">
															<span class="thumb-info-inner"> {{ $publicacion->users->name }} {{ $publicacion->users->last_name }} </span>
															<span class="thumb-info-type">{{ $publicacion->categoria->name }}</span>
														</span>
														<span class="thumb-info-action">
															<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
														</span>
													</span>
												</span>
											</a>
										</div>
									</div>
									@endforeach
									@else
									<h2>Por el momento no hay profesionales en este rubro. Estamos trabajando para incorporlos. </h2>
									@endif
									
									
									
									
								</div>
								<p>
									<a href="{{ url('/') }}" class="btn btn-primary">Volver</a>
								</p>
						</div>
					</div>
					
		</div>

	<!--hasta acá -->


            @endsection
