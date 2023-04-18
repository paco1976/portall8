@extends('layouts.home')

@section('main')

@if($user_profile->mobile)
<!-- <a href="https://api.whatsapp.com/send?phone=549{{ $user_profile->mobile }}&text=Hola!%20Te%20Contacto%20de%20CEFEPERES%20y%20queria%20hacerte%20una%20consulta!" class="whatsapp" target="_blank"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>-->	
<!--<a href="https://wa.me/549{{ $user_profile->mobile }}?text=Hola!%20Te%20Contacto%20de%20CEFEPERES%20y%20queria%20hacerte%20una%20consulta!" class="whatsapp" target="_blank"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>-->
<a href="{{ route('publicacion_whatsapp', ['hash'=> $publicacion->hash]) }}" class="whatsapp" > <i class="fa fa-whatsapp whatsapp-icon"></i></a>
@endif
			<div role="main" class="main">

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}"> Volver a {{ $categoria->name }}</a></li>
									<li class="active">{{ $user->name}} {{ $user->Last_name}}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}"> <h1>{{ $categoria->name }}</h1></a>
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
							<!--<h4>Diseñador Web</h4>-->
							
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
								
							</span>

							@if($publicacion->description)
							<p>{{ $publicacion->description }}</p>
							@endif
							<h2 class="shorter">Títulos <strong>relacionados</strong></h2>
							<ul class="list icons list-unstyled">

								<li><i class="fa fa-check"></i> {{ $titulo->name }}</li>
								@foreach ($publicacion->titulos_asociados as $tit)
									<li><i class="fa fa-check"></i> {{ $tit->name }}</li>
								@endforeach
								<!--
								<li><i class="fa fa-check"></i> Phasellus in risus quis lectus iaculis vulputate id quis nisl.</li>
								<li><i class="fa fa-check"></i> Iaculis vulputate id quis nisl.</li>
								-->
							</ul>

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
											<input type="text" value="{{ old('mobile') }}" data-msg-required="Por favor ingresa su celular. Ej 1155667788." maxlength="100" class="form-control" name="mobile" >
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
											<option value="" >...</option>
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
											<textarea maxlength="5000" data-msg-required="Por favor ingresa tu mensaje." rows="10" class="form-control" name="message" id="message" ></textarea>
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
			
			

			<section class="call-to-action featured footer">
				<div class="container">
					<div class="row">
						<div class="center">

							
							<h3>Ver <strong>datos</strong> de contacto del profesional <a onClick="muestra_oculta('contenido')" class="btn btn-lg btn-primary" data-appear-animation="bounceIn">Clic aca</a> <span class="arrow hlb hidden-xs hidden-sm hidden-md" data-appear-animation="rotateInUpLeft" style="top: -22px;"></span></h3>
														
							<div id="contenido">
								<h3>Telefono: {{ $user_profile->mobile }} <br>
								Mail: {{ $user->email }} <br>
								@if($zonas)
									Barrios en los que trabajo: <br>
									@foreach($zonas as $zona)
									{{ $zona->name }}, 
									@endforeach
								@endif
								</h3>
								<div class="social-icons">
								<ul class="social-icons">
									@if($user_profile->facebook)
									<li class="facebook"><a href="{{ $user_profile->facebook }}" target="_blank" data-placement="bottom" data-tooltip title="Facebook">Facebook</a></li>
									@endif
									@if($user_profile->instagram)
									<li class="instagram"><a href="{{$user_profile->instagram}}" target="_blank" data-placement="bottom" data-tooltip title="Instagram">Instagram</a></li>
									@endif

									@if($user_profile->linkedin)
									<li class="linkedin"><a href="{{$user_profile->linkedin}}" target="_blank" data-placement="bottom" data-tooltip title="Linkedin">Linkedin</a></li>
									@endif

									@if($user_profile->twitter)
									<li class="twitter"><a href="{{$user_profile->twitter}}" target="_blank" data-placement="bottom" data-tooltip title="Linkedin">Linkedin</a></li>
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