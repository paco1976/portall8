@extends('layouts.admin')

@section('main')


			<div role="main" class="main">

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#"> Volver a publiaciones</a></li>
									<li class="active">{{ $publicacion->user->name}} {{ $publicacion->user->Last_name}}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<a href="#"> <h1>{{ $publicacion->categoria->name }}</h1></a>
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
										<img alt="" height="200" class="img-responsive" src="{{ asset($publicacion->user->avatar) }}">
									</div>
								</div>
								@if($publicacion->cant_imagenes > 0)
									@foreach($publicacion->imagenes as $imagen)
									<div>
										<div class="thumbnail">
											<img alt="" height="200" class="img-responsive" src="{{ asset($imagen->url) }}"> 
										</div>
									</div>
									@endforeach
								@endif
							</div>
						</div>

						<div class="col-md-8">

							<h2 class="shorter">{{ $publicacion->user->name}} <strong>{{ $publicacion->user->last_name}} </strong></h2>
							<!--<h4>Diseñador Web</h4>-->
							
							<span class="thumb-info-social-icons">
								@if($publicacion->user->profile->facebook)
								<a data-tooltip data-placement="bottom" target="_blank" href="{{ asset($publicacion->user->profile->facebook) }}" data-original-title="Facebook"><i class="fa fa-facebook"></i><span>Facebook</span></a>
								@endif
								@if($publicacion->user->profile->twitter)
								<a data-tooltip data-placement="bottom" target="_blank"  href="{{ asset($publicacion->user->profile->twitter) }}" data-original-title="Twitter"><i class="fa fa-twitter"></i><span>Twitter</span></a>
								@endif
								@if($publicacion->user->profile->linkedin)
								<a data-tooltip data-placement="bottom" target="_blank"  href="{{ asset($publicacion->user->profile->linkedin) }}" data-original-title="Linkedin"><i class="fa fa-linkedin"></i><span>Linkedin</span></a>
								@endif
								
							</span>

							@if($publicacion->description)
							<p>{{ $publicacion->description }}</p>
							@endif
							<h2 class="shorter">Títulos <strong>relacionados</strong></h2>
							<ul class="list icons list-unstyled">

								<li><i class="fa fa-check"></i> {{ $publicacion->titulo->name }}</li>
								@foreach ($publicacion->titulos_asociados as $tit)
									<li><i class="fa fa-check"></i> {{ $tit->name }}</li>
								@endforeach
								<!--
								<li><i class="fa fa-check"></i> Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
								<li><i class="fa fa-check"></i> Iaculis vulputate id quis nisl.</li>
								-->
							</ul>
							<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => $origen]) }}" class="btn btn-primary btn-lg">
								@if($publicacion->aprobado == 0)
								Activar publicación
								@else
								Desactivar publicación
								@endif
							</a>
							@if($origen == 'profesionales')
							<a href="{{ route('admin_publicaciones_user', ['user_hash' => $publicacion->user->hash]) }}" class="btn btn-primary btn-lg">VOLVER</a>
							@else
							<a href="{{ route('admin_publicaciones') }}" class="btn btn-primary btn-lg">VOLVER</a>
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

							<br>	
							<br>
							<br>
							<br>

							

						
						</div>
						

					</div>

				</div>

			</div>
			
			

			<section class="call-to-action featured footer">
				<div class="container">
					<div class="row">
						<div class="center">

							
							<h3>Ver <strong>datos</strong> de contacto del profesional <a onClick="muestra_oculta('contenido')" class="btn btn-lg btn-primary" data-appear-animation="bounceIn">Clic aca</a> <span class="arrow hlb hidden-xs hidden-sm hidden-md" data-appear-animation="rotateInUpLeft" style="top: -22px;"></span></h3>
														
							<div id="contenido">
								<h3>Telefono: {{ $publicacion->user->profile->mobile }} <br>
								Mail: {{ $publicacion->user->email }} <br>
								@if($publicacion->zonas)
									Barrios en los que trabajo: <br>
									@foreach($publicacion->zonas as $zona)
									{{ $zona->name }}, 
									@endforeach
								@endif
								</h3>
								<div class="social-icons">
								<ul class="social-icons">
									@if($publicacion->user->profile->facebook)
									<li class="facebook"><a href="{{ $publicacion->user->profile->facebook }}" target="_blank" data-placement="bottom" data-tooltip title="Facebook">Facebook</a></li>
									@endif
									@if($publicacion->user->profile->instagram)
									<li class="instagram"><a href="{{$publicacion->user->profile->instagram}}" target="_blank" data-placement="bottom" data-tooltip title="Instagram">Instagram</a></li>
									@endif

									@if($publicacion->user->profile->linkedin)
									<li class="linkedin"><a href="{{$publicacion->user->profile->linkedin}}" target="_blank" data-placement="bottom" data-tooltip title="Linkedin">Linkedin</a></li>
									@endif

									@if($publicacion->user->profile->twitter)
									<li class="twitter"><a href="{{$publicacion->user->profile->twitter}}" target="_blank" data-placement="bottom" data-tooltip title="Linkedin">Linkedin</a></li>
									@endif
								</ul>
								<p>IMPORTANTE: Al contactar al Profesional está aceptando los términos y condiciones del sitio. Leer <a href="{{ url('/condiciones') }}">condiciones de uso.</a> </p>
							</div>

						</div>
						

					</div>
				</div>
			</div>
			</section>
@endsection