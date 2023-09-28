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
						<li class="text-color-primary"><a href="#">Panel de control</a></li>
						
					</ul>
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">EDICIÓN DE PUBLICACION</h1>
					
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
					
					<a href="#" class="btn btn-primary btn-outline btn-outline-thin btn-outline-light-opacity-2 btn-effect-5 font-weight-semi-bold px-4 btn-py-2 text-3 text-color-light text-color-hover-dark ms-2"   data-bs-toggle="modal" data-bs-target="#defaultModal">¿Como Funciona?<i class="icon-info icons ms-1"></i></a>
				</div>

			</div>
		</div>
	</section>
	
	
	
<div role="main" class="main" id="ver">
	
	<div class="container pt-3 pb-2">
		<h2 class="font-weight-normal line-height-1">Publicación de <strong class="font-weight-extra-bold">{{ $user->name }} {{ $user->last_name }}</strong></h2>
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
		<div class="row pt-2">
			<div class="col-lg-3 mt-4 mt-lg-0">

				<div class="d-flex justify-content-center mb-4">
					<div class="profile-image-outer-container">
						<div class="profile-image-inner-container bg-color-primary">
							<img src="{{ $publicacion->user->avatar }}">
						</div>
						
					</div>
					
				</div>

				
				
				
				<aside class="sidebar mt-2" id="sidebar">
					
					<ul class="nav nav-list flex-column mb-5">
						<li class="nav-item"><a class="nav-link text-3 text-dark active" href="{{ route('prof_publicacion', ['hash_user' => $user->hash]) }}">Publicaciones del profesional</a></li>
					</ul>
				</aside>

			</div>
			<div class="col-lg-9">

				
				<form role="form" class="needs-validation" action="{{ route('prof_publicacion_update', ['hash_user' => $user->hash]) }}" method="POST" enctype="multipart/form-data" >
					{{ method_field('PUT') }}
					@csrf
					<input type="hidden" name="publicacion_hash" value="{{$publicacion->hash}}" >

					<div class="form-group row">
						<label class="col-lg-3 control-label text-lg-end pt-2" for="textareaDefault">Títulos para asociar de la categoría {{$publicacion->categoria->name}}</label>
						<div class="col-lg-9">
							
								<ul class="portfolio-list" data-sort-id="portfolio">
								@if($titulos_asociados)
									@foreach($titulos_asociados as $titulo)
									@if($publicacion->titulo_id != $titulo->id)
										<li class="col-md-4 col-sm-6 col-xs-12 isotope-item websites">
										@if($publicacion->hasTitulo($titulo))
											<label for="">
											<input type="checkbox" name="titulos[]" value="{{ $titulo->name }}" multiple ria-label="Radio button for following text input" checked> {{ $titulo->name }}
											</label><br>
										@else
										<label for="">
										<input type="checkbox" name="titulos[]" value="{{ $titulo->name }}" multiple ria-label="Radio button for following text input"> {{ $titulo->name }}
										</label><br>
										@endif
										</li>
									@endif
									@endforeach
								@else  
									<p>Ups! Algo ocurrio con los títulos</p>
								@endif
								</ul>
							
						</div>
					</div>
					<!-- 
					<div class="form-group row">
						<label class="col-lg-3 control-label text-lg-end pt-2" for="textareaDefault">ELEGIR CATEGORÍA</label>
						<div class="col-lg-9">
							<div class="custom-select-1">
								
								@if ($categoria_all->count() > 0 )
								<select  class="form-control text-3 h-auto py-2" name="categoria_id">
								@foreach($categoria_all as $categoria)
									@if ($categoria->id == $publicacion->categoria->id)
										<option value="{{$categoria->id}}" selected>{{$categoria->name}}</option>
									@else
										<option value="{{$categoria->id}}">{{$categoria->name}}</option>
									@endif
								@endforeach
								</select>	
								@else
									<p>Debe exister por lo menos una categoría para crear una publicación. Comuniquese con el administrador</p>
								@endif
							</div>
						</div>
					</div>
				-->
						<input type="hidden" name="publicacion_hash" value="{{$publicacion->hash}}" >
					
							<div class="form-group row pb-4">
								<label class="col-lg-3 control-label text-lg-end pt-2" for="textareaDefault">DESCRIPCIÓN</label>
								<div class="col-lg-9">
									<textarea class="form-control" name="description"  rows="4" id="textareaDefault">{{$publicacion->description}}</textarea>
									@error('description')
										<div class="alert alert-danger">
											<strong>{{ $message }}</strong>
										</div>
									@enderror
								</div>
							</div>
					
					
							<div class="form-group row pb-4">
								<label class="col-lg-3 control-label text-lg-end pt-2" for="textareaDefault">SUBIR IMAGENES DE TU TRABAJO</label>
								
								<div class="col-lg-9">

									<div class="input-group mb-3">
										<div class="row mt-lg-5">
											@if($publicacion->cant_images>0)
											@foreach ($publicacion->imagenes as $imagen)
											<div class="col-lg-4">
												<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-centered-info thumb-info-hide-info-hover">
													<span class="thumb-info-wrapper">
														<img src="{{ asset($imagen->url) }}" class="img-fluid" alt="">
														<span class="thumb-info-title">
															<!--<button class="btn btn-danger"><i class="far fa-trash-alt"></i></button> -->
															<a href="{{ route('prof_publicacion_imagen_delete', $imagen->id) }}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
														</span>
													</span>
												</span>
												</a>
											</div>
											@endforeach
											@endif
															
										</div>
									</div>


									@for ($i = $publicacion->cant_images; $i <= 4; $i++)
									<div class="input-group mb-3">
										<button class="btn btn-primary" type="button">SUBIR</button>
										<input type="file" name="file[]" class="form-control">
									</div>
									@endfor
									
									<div class="input-group mb-3">
										<label class=" text-lg-end pt-2" for="textareaDefault">Puede subir como máximo 5 imagenes</label>
									</div>
								</div>
							</div>
							
							
					
					
					<div class="form-group row">
						<div class="form-group col-lg-9">
							<a href="{{ route('prof_publicacion', ['hash_user' => $publicacion->user->hash]) }}" class="btn btn-dark btn-modern float-end" >Volver</a>
						</div>
						<div class="form-group col-lg-3">
							<button type="submit" class="btn btn-primary btn-modern float-end">Guardar publicación</button>
						</div>
					</div>
				</form>

			</div>
		</div>

	</div>

</div>


	
	<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel">Qué hago?</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
				<p><strong>Cómo creo una publicación</strong><br>
					Clic en <a href="#">Agregar Publicación</a>.<br>
					<strong>Completar los datos: </strong> <br>
					1. Seleccionar categoría.<br>
					2. Describir el servicio que va a ofrecer.<br>
					3. Subir foto de los trabajos realizados.<br>
					4. Subir certificado de estudios (formato PDF).<br>
					</p>
					
	<hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
					<p><em>La publicación no serán visible hasta sea validada por la administración del Portal.</em></p>
					
					
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Entiendo</button>
				</div>
			</div>
		</div>
	</div>


	
</div>

@endsection
