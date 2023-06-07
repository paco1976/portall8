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
								<h1>Herramientas</h1>
							</div>
						</div>
					</div>
				</section>


				<div class="container">
					<div class="row">
							<div class="col-md-6" style="display:block;justify-content:center">
								<div class="tabs" >
									<ul class="nav nav-tabs">
										<li class="active">
											<a href=""><i style="font-size:30px;margin-right:5px" class="fa fa-wrench"></i> Nuevo Ingreso</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active">
											<h2 class="short"><strong>Registro </strong>de la herramienta</h2>
											<form  method="POST" action="{{ route('tool_save') }}"  >
												
												@csrf
												<div class="row" >
													<div class="form-group">
														<div class="col-md-12">
															<label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
														</div>
														<div class="col-md-12">
															<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required  autofocus>
															@error('name')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
												</div>

												<div class="row">
													<div class="form-group">
														<div class="col-md-12">
															<label for="description" class="col-md-4 col-form-label text-md-right">Descripcion</label>
														</div>

														<div class="col-md-12">
															<textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required ></textarea>

															@error('description')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
												</div>

												<div class="form-group row mb-0">
													<div class="col-md-12 offset-md-4">
														<button type="submit" class="btn btn-primary">
															Guardar
														</button>
			
													</div>
												</div>
											</form>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

@endsection
