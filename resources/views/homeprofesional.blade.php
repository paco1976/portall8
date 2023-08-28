@extends('layouts.home')

@section('main')

 <!-- desde acá-->
 <div role="main" class="main">

	<section
		class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8"
		style="background-image: url({{ asset('img/slides/slide-bg-4.jpg') }}); background-size: cover; background-position: center; min-height: 645px;">
		<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;">
		</div>
		<div class="container pt-lg-5 mt-5">
			<div class="row pt-3 pb-lg-0 pb-xl-0">
				<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
					<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
						<li><a href="{{route('welcome')}}">Inicio</a></li>
						<li class="text-color-primary"><a
								href="{{ route('homepublicaciones', ['id' => $categoria->id]) }}">{{ $categoria->categoriatipo->name }}</a>
						</li>
						<li class="active text-color-primary">{{ $categoria->name }}</li>
					</ul>
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">{{ $categoria->name }}</h1>
					<p class="opacity-7 text-4 negative-ls-05 pb-2 mb-4">¿Estas buscando un profesional?<br>Encontrá
						todo lo que buscas en nuestro sitio.</p>
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100"
						class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver
						Profesionales <i class="fas fa-arrow-down ms-1"></i></a>
					<a href="{{ route('contacto') }}"
						class="btn btn-light btn-outline btn-outline-thin btn-outline-light-opacity-2 btn-effect-5 font-weight-semi-bold px-4 btn-py-2 text-3 text-color-light text-color-hover-dark ms-2">Contactanos
						<i class="fas fa-external-link-alt ms-1"></i></a>
				</div>
			</div>
		</div>
	</section>

	<div role="main" class="main" id="ver">
		<div class="container pt-5">
			<div class="row py-4 mb-2">
				<div class="col-md-7 order-2">
					<div class="overflow-hidden">
						<h2 class="text-color-dark font-weight-bold text-12 mb-2 pt-0 mt-0 appear-animation"
							data-appear-animation="maskUp" data-appear-animation-delay="300">{{ $user->name }}
							{{ $user->Last_name }}</h2>
					</div>
					
					@if($publicacion->show_rating)
					<div class="star-rating">
						@for ($i = 1; $i <= 5; $i++) @if ($rating < 3) <i class="bi bi-star "></i>
							@else
							@if ($i <= floor($rating)) <i class="bi bi-star-fill" style="color:gold;"></i>
								@elseif ($i <= ceil($rating)) <i class="bi bi-star-half" style="color:gold;"></i>
									@else
									<i class="bi bi-star" style="color:gold;"></i>
									@endif
									@endif
									@endfor

									@if ($rating < 3) <small>No hay suficientes calificaciones</small>
									@endif
					</div>
					@endif

					<div class="overflow-hidden mb-3">
						<p class="font-weight-bold text-primary text-uppercase mb-0 appear-animation"
							data-appear-animation="maskUp" data-appear-animation-delay="500">{{ $categoria->name }}</p>
					</div>
					<p class="lead appear-animation" data-appear-animation="fadeInUpShorter"
						data-appear-animation-delay="700">{{ $publicacion->description }}</p>
					<h2 class="shorter">Títulos <strong>relacionados</strong></h2>
					<ul class="list icons list-unstyled">
						<li><i class="fa fa-check"></i> {{ $titulo->name }}</li>
						@foreach ($publicacion->titulos_asociados as $tit)
						<li><i class="fa fa-check"></i> {{ $tit->name }}</li>
						@endforeach
					</ul>
					<p class="pb-3 appear-animation" data-appear-animation="fadeInUpShorter"
						data-appear-animation-delay="800"></p>
					<hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter"
						data-appear-animation-delay="900">
					<div class="row align-items-center appear-animation" data-appear-animation="fadeInUpShorter"
						data-appear-animation-delay="1000">
						<div class="col-lg-8">
							@if ($info)
							<div class="contactInfo">
								<h5>Información de contacto</h5>
								@if($user_profile->mobile)
								<a class="bi bi-whatsapp contact-link" href="{{ $whatsapp_url }}" target="_blank" data-tooltip title="WhatsApp"> {{$user_profile->mobile}}</a></br>
								@endif
								@if($user->email)
								<a class="bi bi-envelope-at contact-link" href="mailto:{{ $user->email }}" target="_blank" data-tooltip title="Email"> {{ $user->email }}</a></br>
								@endif
								<div class="contact-icons">
									<ul class="social-icons">
										@if($user_profile->facebook)
										<li class="facebook"><a href="https://www.facebook.com/{{ $user_profile->facebook }}" target="_blank" data-placement="bottom" data-tooltip title="Facebook">Facebook</a></li>
										@endif
										@if($user_profile->instagram)
										<li class="instagram"><a href="https://www.instagram.com/{{ $user_profile->instagram }}" target="_blank" data-placement="bottom" data-tooltip title="Instagram">Instagram</a></li>
										@endif

										@if($user_profile->linkedin)
										<li class="linkedin"><a href="https://www.linkedin.com/in/{{ $user_profile->linkedin }}" target="_blank" data-placement="bottom" data-tooltip title="Linkedin">Linkedin</a></li>
										@endif

										@if($user_profile->twitter)
										<li class="twitter"><a href="https://www.twitter.com/{{ $user_profile->twitter }}" target="_blank" data-placement="bottom" data-tooltip title="Twitter">Twitter</a></li>
										@endif
									</ul>
								</div>

							</div>
							@endif

							
							@if (!$info)
							
							
							<button type="button" class="btn btn-modern btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#myModal">
								Ver datos de contacto
							  </button>
							
							
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
									  	<div class="modal-header border-bottom-0">
											<h5 class="modal-title" id="exampleModalLabel">Completá tus datos para ver la información de contacto del profesional</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal"
                           					 aria-hidden="true">&times;</button>
										</div>
										<div class="modal-body">
												@include('clientForm', ['user_id' => $user->id, 'publicacion_id' => $publicacion->id])
										</div>
									</div>
								</div>
							</div>

							@endif


							<a href="#individual" class="btn btn-modern btn-dark mt-3" data-hash data-hash-offset="0"
								data-hash-offset-lg="100">Hacé una consulta</a>
							
						</div>

						<div class="col-sm-4 text-lg-end my-4 my-lg-0">
							@if ($user_profile->facebook || $user_profile->twitter || $user_profile->linkedin)
								<strong class="text-uppercase text-1 me-3 text-dark">Seguime</strong>
							@endif
							<ul class="social-icons float-lg-end">
								@if ($user_profile->facebook)
									<li class="social-icons-facebook"><a href="{{ asset($user_profile->facebook) }}"
											target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
								@endif
								@if ($user_profile->twitter)
									<li class="social-icons-twitter"><a href="{{ asset($user_profile->twitter) }}"
											target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
								@endif
								@if ($user_profile->linkedin)
									<li class="social-icons-linkedin"><a href="{{ asset($user_profile->linkedin) }}"
											target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
								@endif
							</ul>
						</div>

					</div>
				</div>
				<div class="col-md-5 order-md-2 mb-4 mb-lg-0 appear-animation" data-appear-animation="fadeInRightShorter">
					<div class="thumb-gallery-wrapper">
						<div class="thumb-gallery-detail owl-carousel owl-theme manual nav-inside nav-style-1 nav-dark mb-3">
							@if ($user->avatar)
								<div>
									<img src="{{ asset($user->avatar) }}" class="img-fluid" alt="Presentation">
								</div>
							@endif
							@if ($publicacion->cant_images > 0)
								@foreach ($publicacion->imagenes as $imagen)
									<div>
										<img src="{{ asset($imagen->url) }}"class="img-fluid" alt="Presentation">
									</div>
								@endforeach
							@endif

						</div>
						<div class="thumb-gallery-thumbs owl-carousel owl-theme manual thumb-gallery-thumbs">
							@if ($user->avatar)
								<div>
									<span class="d-block cur-pointer">
										<img alt="Presentation" src="{{ asset($user->avatar) }}" class="img-fluid">
									</span>
								</div>
							@endif
							@if ($publicacion->cant_images > 0)
								@foreach ($publicacion->imagenes as $imagen)
									<div>
										<span class="d-block cur-pointer">
											<img alt="Presentation" src="{{ asset($imagen->url) }}"
												class="img-fluid">
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



	<div id="individual" class="container py-2">

		<div class="row">

			<div class="col-lg-12 order-1 order-lg-2">

				<div class="overflow-hidden mb-1">
					<h2 class="font-weight-normal text-7 mb-0"><strong class="font-weight-extra-bold">Hacé
							una</strong> consulta</h2>
				</div>
				<div class="overflow-hidden mb-4 pb-3">
					<p class="mb-0">Sentite libre de pedir detalles, ¡no te guardes ninguna pregunta!</p>
				</div>

				<form class="contact-form" action="{{ route('interaction_publicacion', ['id' => $publicacion->id]) }}"
					method="POST" enctype="multipart/form-data">
					{{ method_field('PUT') }}
					@csrf

					@if (Session::has('message'))
						<div class="alert alert-success">
							{{ Session::get('message') }}
						</div>
					@endif
					@if (Session::has('error'))
						<div class="alert alert-danger">
							{{ Session::get('error') }}
						</div>
					@endif

					<div class="row">
						<div class="form-group col-lg-6">
							<label class="form-label mb-1 text-2">Nombre</label>
							<input type="text" value="{{ old('name') }}"
								data-msg-required="Por favor, escribí tu nombre." maxlength="100"
								class="form-control text-3 h-auto py-2" name="name" required>
							@error('name')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
							@enderror
						</div>
						<div class="form-group col-lg-6">
							<label class="form-label mb-1 text-2">Apellido </label>
							<input type="text" value="{{ old('last_name') }}"
								data-msg-required="Por favor, escribí tu apellido."
								data-msg-email="Por favor, escribí tu apellido." maxlength="100"
								class="form-control text-3 h-auto py-2" name="last_name" required>
							@error('last_name')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
							@enderror
						</div>
					</div>
					<div class="row">
						<div class="form-group col-lg-6">
							<label class="form-label mb-1 text-2">Email </label>
							<input type="email" value="{{ old('email') }}"
								data-msg-required="Por favor, escribí tu correo electrónico."
								data-msg-email="Por favor, escribí tu correo electrónico." maxlength="100"
								class="form-control text-3 h-auto py-2" name="email" required>
							@error('email')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
							@enderror
						</div>
						<div class="form-group col-lg-6">
							<label class="form-label mb-1 text-2">Celular</label>
							<input type="text" value="{{ old('mobile') }}"
								data-msg-required="Por favor, escribí tu teléfono." maxlength="100"
								class="form-control text-3 h-auto py-2" name="mobile" required>
							@error('email')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
							@enderror
						</div>
					</div>
					<div class="form-group col">
						<label class="form-label mb-1 text-2">Adjuntar Imagen</label>
						<input type="file" value="" maxlength="100" class="form-control text-3 h-auto py-2"
							name="file[]" multiple="multiple">
					</div>
					<div class="row">
						<div class="form-group col">
							<label class="form-label">Asunto</label>
							<div class="custom-select-1">
								<select class="form-select form-control h-auto"
									data-msg-required="Por favor, elija el asunto del contacto" name="subjet"
									required>
									<option value="">...</option>
									@foreach ($subjets as $subjet)
										<option value="{{ $subjet->id }}">{{ $subjet->name }}</option>
									@endforeach
								</select>
								@error('subjet')
									<div class="alert alert-danger">
										<p><strong>{{ $message }}</strong></p>
									</div>
								@enderror
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label class="form-label mb-1 text-2">Mensaje</label>
							<textarea maxlength="5000" data-msg-required="Por favor, ingrese su mensaje o consulta." rows="8"
								class="form-control text-3 h-auto py-2" name="message" required></textarea>
							@error('message')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
							@enderror
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<!-- <input type="submit" value="Enviar Mensaje" class="btn btn-primary btn-modern" data-loading-text="Cargando..."> -->
							<button type="submit" class="btn btn-primary btn-modern">Enviar Mensaje</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>








@if(count($zonas) > 0)
<section class="featured footer">
	<div class="container">
		<div class="row">
			<div id="zones">
				<h2><i class="bi bi-geo-alt"></i> Zona de cobertura</h2>
				<p class="zones-list">
					@foreach($zonas as $zona)
					{{ $zona->name }}@if(!$loop->last),@endif
					@endforeach
				</p>
			</div>
		</div>
	</div>
</section>
@endif
@endsection