@extends('layouts.admin')

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
								<h1>Categorías</h1>
							</div>

						</div>
					</div>
				</section>



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

@endsection
