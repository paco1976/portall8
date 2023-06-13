@extends('layouts.home')

@section('main')

<div role="main" class="main">

	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb">
						<li><a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}"> Volver a {{ $categoria->name }}</a></li>
						<li class="active">{{ $user->name}} {{ $user->last_name}}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}">
						<h1>{{ $categoria->name }}</h1>
					</a>
				</div>
			</div>
		</div>
	</section>

	<div class="container">

		<div class="row">
			<div class="col-md-4">

				<div class="owl-carousel" data-plugin-options='{"items": 1}'>
					<div>
						<div class="thumbnail">
							<img alt="" height="300" class="img-responsive" src="{{ asset($user->avatar) }}">
						</div>
					</div>
					@if($publicacion->cant_images > 0)
					@foreach($publicacion->imagenes as $imagen)
					<div>
						<div class="thumbnail">
							<img alt="" height="300" class="img-responsive" src="{{ asset($imagen->url) }}">
						</div>
					</div>
					@endforeach
					@endif
				</div>

			</div>

			<div class="col-md-8">

				<h2 class="shorter">{{ $user->name}} <strong>{{ $user->last_name}} </strong></h2>
				<!-- 							
							<span class="thumb-info-social-icons">
								@if($user_profile->facebook)
								<a data-tooltip data-placement="bottom" target="_blank" href="{{ asset($user_profile->facebook) }}" data-original-title="Facebook"><i class="fa fa-facebook"></i><span>Facebook</span></a>
								@endif
								@if($user_profile->twitter)
								<a data-tooltip data-placement="bottom" target="_blank"  href="{{ asset($user_profile->twitter) }}" data-original-title="Twitter"><i class="fa fa-twitter"></i><span>Twitter</span></a>
								@endif
								@if($user_profile->linkedin)
								<a data-tooltip data-placement="bottom" target="_blank"  href="{{ asset($user_profile->linkedin) }}" data-original-title="Linkedin"><i class="fa fa-linkedin"></i><span>Linkedin</span></a>
								@endif
								
							</span> -->

				@if($publicacion->description)
				<p class="description-profesional">{{ $publicacion->description }}</p>
				@endif
				<h2 class="shorter">Títulos <strong>relacionados</strong></h2>
				<ul class="list icons list-unstyled">

					<li><i class="fa fa-check"></i> {{ $titulo->name }}</li>
					@foreach ($publicacion->titulos_asociados as $tit)
					<li><i class="fa fa-check"></i> {{ $tit->name }}</li>
					@endforeach
				</ul>

			</div>
		</div>
	</div>

	<div class="container contact-btn">
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
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
				<a onClick="muestra_oculta('client-form')" class="btn btn-lg btn-primary" data-appear-animation="bounceIn">Ver <strong>datos</strong> de contacto</a> 
				<!-- <span class="arrow hlb hidden-xs hidden-sm hidden-md" data-appear-animation="rotateInUpLeft" style="top: -22px;"></span> -->

				<div id="client-form" class="contact-info">
				<p>Completá tus datos para ver la información de contacto del profesional</p>
				@include('clientForm', ['user_id' => $publicacion->id])
				</div>
				@endif
			</div>
		</div>
	</div>





	<div class="container">

		<div class="row">
			<div class="col-md-12">

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

				<h2 class="short"><strong>Hacé una</strong> consulta</h2>
				<form id="contactForm" action="{{ route('interaction_publicacion', ['id'=> $publicacion->id]) }}" method="POST" enctype="multipart/form-data">
					{{ method_field('PUT') }}
					@csrf
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">
								<label>Tu Nombre *</label>
								<input type="text" value="{{ old('name') }}" data-msg-required="Por favor ingresa tu Nombre." maxlength="100" class="form-control" name="name" id="name">
								@error('name')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
								@enderror
							</div>
							<div class="col-md-6">
								<label>Apellido *</label>
								<input type="text" value="{{ old('last_name') }}" data-msg-required="Por favor ingresa tu Apellido." maxlength="100" class="form-control" name="last_name" id="name">
								@error('last_name')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-6">
								<label>Celular *</label>
								<input type="text" value="{{ old('mobile') }}" data-msg-required="Por favor ingresa su celular. Ej 1155667788." maxlength="100" class="form-control" name="mobile">
								@error('mobile')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
								@enderror
							</div>
							<div class="col-md-6">
								<label>Tu E-mail *</label>
								<input type="email" value="{{ old('email') }}" data-msg-required="Por favor ingresa tu e-mail." data-msg-email="Please enter a valid Dirección de correo." maxlength="100" class="form-control" name="email" id="email">
								@error('email')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label>Asunto *</label>
								<select maxlength="100" class="form-control" name="subjet" id="subjet" require>
									<option value="">...</option>
									@foreach($subjets as $subjet)
									<option value="{{$subjet->id}}">{{$subjet->name}}</option>
									@endforeach
								</select>
								@error('subjet')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
								@enderror
								<!--<input type="text" value="" data-msg-required="Por favor ingresa tu asunto." maxlength="100" class="form-control" name="subject" id="subject" required> -->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label>Adjuntar Imagen</label>
								<input type="file" maxlength="100" class="form-control" name="file[]" multiple="multiple">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<label>Mensaje *</label>
								<textarea maxlength="5000" data-msg-required="Por favor ingresa tu mensaje." rows="10" class="form-control" name="message" id="message"></textarea>
								@error('message')
								<div class="alert alert-danger">
									<p><strong>{{ $message }}</strong></p>
								</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<!-- <input type="submit" value="Enviar Mensaje" class="btn btn-primary btn-lg" data-loading-text="Cargando..."> -->
							<button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
						</div>
					</div>
				</form>
			</div>


		</div>

	</div>

</div>


@if(count($zonas) > 0)
<section class="featured footer">
	<div class="container">
		<div class="row">
				<div id="zones">
					<p class="zones-list">
						<h2>Barrios en los que trabajo</h2>
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