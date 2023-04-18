@extends('layouts.home')

@section('main')



			<div role="main" class="main">
				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
									<li class="active">Mensaje de Whatsapp</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1><a href="{{ url()->previous() }}" > Volver a la publicación</a></h1>
							</div>
						</div>
					</div>
				</section>

				<section  class="parallax" data-stellar-background-ratio="0.5" style="background-image: url( {{ asset('parallax-transparent.jpg') }} );">
					<div class="container">

						<div class="row">
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
							<div class="col-md-12">
								<h1>CONTACTO</h1>
							</div>
						</div>
                        
							<div class="col-md-12">
								<div class="col-md-8 left">
									<div class="alert alert-success">
										<strong>Hola! Soy {{ $user->name }} {{ $user->last_name }}:</strong>. ofrezco servicios como {{ $titulo->name }} en Cefeperes. Gracias por contactarte. 
										Ingresá tu teléfono para que podamos comunicarnos vía Whatsapp. Debés ingresar el código de área sin 0 y sin 15. Ejemplo: 1125447788<br>
										
									</div>
								</div>
                           		<div class="col-md-4"></div>
							</div>
                        
    						<div class="col-md-12">
                                <div class="col-md-4"></div>
                                	<div class="col-md-8 right">
										<form action="{{ route('publicacion_whatsapp_save') }}" method="POST" enctype="multipart/form-data" >
											{{ method_field('PUT') }}
											@csrf
												<input type="hidden" value="{{ $publicacion->hash }}" name="publicacion_hash" >
				
												<div class="row">
													<div class="form-group">
														<div class="col-md-12">
															<label>CELULAR *</label>
															<input maxlength="100" onkeypress="validate(event)" data-msg-required="Por favor ingresa tu celular." rows="3" class="form-control" name="celular" id="message" required>
														</div>
													</div>
												</div>
												
												<div class="input-group mb-md">
													<br>
													<button type="submit" class="btn btn-success">Ir a Whatsapp</button>        
													<!--<a href="{{ url()->previous() }}" class="btn btn-primary">Volver a la publicacion</strong></a>-->
												</div>
												
											</form>
                                    </div>
                                </div>
							</div>
                            
                            
                            
							</div>


						</div>
					</div>
				</section>





				<div class="container">


					<div class="row">
						<div class="col-md-12">

						</div>


					</div>

				</div>

			</div>

@endsection
