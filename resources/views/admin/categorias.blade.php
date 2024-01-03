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
								<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">
									Categorías
								</h1>
								
								<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
								
							</div>
			
						</div>
					</div>
				</section>
			
				<div role="main" class="main" id="ver">



					<div class="container">

						<form id="contactForm">
							<div class="row">
								<div class="form-group">
									<div class="col-md-12">
										<label>Buscador</label>
										<input type="text" value="" data-msg-required="Ingresa palabra clave." placeholder="ingrese el nombre de la persona que busca" maxlength="100" class="form-control" name="name" id="name" required>
									</div>

								</div>
							</div>
						</form>

						<div class="row">
							<div class="form-group">
								<div class="col-sm-6">
									<div class="mb-md">
										<a href="#">
											<button id="addToTable" class="btn btn-primary">Agregar Categoria </button>
										</a>
										<br>
									</div>
								</div>
							</div>
						</div>

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
							</div>
						</div>
						

						@if($categoria_all->count() > 0)
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-striped mb-none" id="myTable">
									<thead>
									
										<tr>
											<th style="text-align:center" width="33%" >ICONO</th>
											<th style="text-align:center">NOMBRE</th>
											<th style="text-align:center">TIPO</th>
											<th style="text-align:center"colspan="4">Acciones <br> Activa / Ver / Editar / Borrar</th>
										</tr>
									</thead>
									<tbody>
									@foreach($categoria_all as $categoria)
										<tr class="gradeX">
											<th style="text-align:center">
												<img src="{{ asset($categoria->icon) }}" class="img-thumbnail" width="100" > <br>
												<form action="{{ route('admin_categoria_icon') }}" method="POST" enctype="multipart/form-data" >
													{{ method_field('PUT') }}
													@csrf
												<input type="hidden" name="categoria_id" value="{{$categoria->id}}">
													<input type="file" name="file" class="form-control" required>
													<br>
													@error('file')
														<div class="alert alert-danger">
															<strong>{{ $message }}</strong>
														</div>
													@enderror
		
													<button type="submit" class="btn btn-default fileupload-new">Cambiar imagen</button>
													
												</form>
											</th>
											<td style="text-align:center">{{$categoria->name}}</td>
											<td style="text-align:center">{{$categoria->tipo($categoria->categoria_tipo_id)}}</td>

																					
											<td style="text-align:center">
											@if($categoria->active == 0)
												<a href="{{ route('admin_categoria_activar_desactivar',  $categoria->id ) }}" style="text-align:center" class="btn btn-danger">NO</a>
											@else
												<a href="{{ route('admin_categoria_activar_desactivar',  $categoria->id) }}" style="text-align:center" class="btn btn-success">SI</a>
											@endif
											</td>

											<td style="text-align:center">
												<a href="#" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
											</td>

											<td style="text-align:center">
												<a href="" class="btn btn-primary"><i class="fa fa-edit"></i></a>
											</td>
											
											<td style="text-align:center">
												<a href="#" onclick="return confirm('¿Está seguro/a que quiere borrar la categoría?')" style="text-align:center" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
											</td>


										</tr>
									@endforeach


									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-12 text center">
							{{ $categoria_all->Links() }}
							</div>
						</div>
						@else
						<div class="row">
							<div class="col-12 text center">
							No hay profesionales dados de alta en su CFP.
							</div>
						</div>

						@endif
					</div>
				</div>

			</div>

@endsection
