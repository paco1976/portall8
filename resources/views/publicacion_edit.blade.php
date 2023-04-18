@extends('layouts.panel')

@section('main')
			<div role="main" class="main">


				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
									<li class="active">Panel de Control</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>MI PUBLICACION</h1>
							</div>


						</div>
					</div>
				</section>



				<div class="container">

					<div class="row">
						<div class="col-md-9">
							<div class="tabs">
								<ul class="nav nav-tabs">
									<li>
										<a href="{{ Url('/perfil') }}" ><i class="fa fa-user"></i> Perfil</a>
									</li>
									<li class="active">
										<a href="{{ route('publicacion') }}"><i class="fa fa-file-powerpoint-o"></i> Publicaciones</a>
									</li>
									<li>

									</li>

								</ul>
								<div class="tab-content">

									<div id="publicacion" class="tab-pane active">

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
										<div class="col-sm-6">
											<div class="mb-md">
												
												
												
												
											</div>
										</div>
									</div>	
							<div class="panel-body">
								
									<form class="form-horizontal form-bordered" action="{{ route('publicacion_update') }}" method="POST" enctype="multipart/form-data" >
                        			{{ method_field('PUT') }}
									@csrf
										
									<input type="hidden" name="publicacion_hash" value="{{$publicacion->hash}}" >
										<div class="form-group">
											<h3 class="col-md-9" align="center">Publicación editada</h3>
										</div>
                                            
											
										<div class="form-group">
										<h5 class="col-md-9" align="center">títulos para asociar de la categoría {{$publicacion->categoria->name}}</h5>
										</div>
										<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
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
											<p>Ups! Algo ocurrio con las zonas</p>
										@endif
										</ul>




                                </div>
                                <div class="form-group">
                                <label class="col-md-3 control-label">Descripción</label>
                                    <div class="col-md-6">
									<textarea id="input" name="description" style="width:100%; height:200px">{{$publicacion->description}}</textarea>
										@error('description')
											<div class="alert alert-danger">
												<strong>{{ $message }}</strong>
											</div>
										@enderror
                                    </div>
                                </div>




								<a href="#" class="btn btn-default fileupload-new" data-dismiss="fileupload">Subir imágenes de tu trabajo </a>

								<div class="alert alert-info">
									@if($publicacion->cant_images>0)
									@foreach ($publicacion->imagenes as $imagen)
										<img src="{{ asset($imagen->url) }}" class="img-thumbnail" width="100" >
										<a href="{{ route('imagen_delete', $imagen->id) }}" class="btn btn-default fileupload-exists" data-dismiss="fileupload">quitar imagen</a>
									@endforeach
									@endif
									@for ($i = $publicacion->cant_images; $i <= 4; $i++)
									<input type="file" name="file[]">	
									@endfor
									<br>
									<strong>Puede subir como máximo 5 imagenes</strong>
								</div>



											<!-- <button id="ms_example7-toggle" class="btn btn-primary">Seleccionar</button> -->
										</div>


                                    <button type="submit" class="btn btn-primary">Guardar publicación</button>
									<!-- <a href="#" class="btn btn-primary" data-dismiss="fileupload">Guardar modificaciones</a> -->


								</div>
                            </form>
								</div>
							</div>
						</div>


						<div class="col-md-3">
						<button class="btn btn-info btn-small " data-toggle="modal" data-target="#myModal">
								<i class="fa fa-question-circle"></i> ¿Como funciona?
							</button>

							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">Qué hago?</h4>
										</div>
										<div class="modal-body">

											<h4 class="panel-title">
												<strong>Cómo cambio mis datos?</strong>
										</h4>
											<div class="panel-body">
										  Entra en <a href="#">Modificar los detalles</a> y actualizá tu perfil. </div>


											<h4 class="panel-title">
												<strong>Cómo creo mis publicaciones?</strong>
										</h4>

											<div class="panel-body">
										  1. Agregá los cursos que hiciste en el CFP clickeando en el menú Títulos.<br>
2. Una vez que hayas cargado tus tíulos, ya podés crear tus publicaciones clickeando en el menú Publicaciones. </div>





                                        <div class="alert alert-info">
								<strong>Las publicaciones no serán publicadas hasta que los títulos que cargaste sean validados por la administración del CFP.</strong>
							</div>


										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>

										</div>
									</div>
								</div>
							</div>


						</div>





					</div>

				</div>

			</div>

@endsection
