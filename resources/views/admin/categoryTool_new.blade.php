@extends('layouts.home')

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
								<h1>Categorias</h1>
							</div>
						</div>
					</div>
				</section>
				@if (Session::has('message'))
                        <div class="alert alert-success" style="padding:10px;display:flex; flex-direction:row; justify-content:space-between">
                            <p >{{ Session::get('message') }}</p>
							<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button>
                        </div>									
                        @endif	

				<div class="container">
					<div class="row">
							<div class="col-md-6" style="padding:10px;display:block;justify-content:center">
								<div class="tabs" >
									<ul class="nav nav-tabs">
										<li class="active">
											<a href=""><i style="font-size:30px;margin-right:5px" class="fa fa-wrench"></i> Nuevo Ingreso</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active">
											<h2 class="short"><strong>Registre la </strong>categoria</h2>
											<form  method="POST" action="{{ route('category_save') }}"  >
												
												@csrf

												<input style="display:none;" id="id" type="text"  name="id" 
															value="{{ old('id') ?? $cat->id ?? ''}}">
												<div class="row" >
													<div class="form-group">
														<div class="col-md-12">
															<label for="name" class="col-md-4 col-form-label text-md-right" >Nombre</label>
														</div>
														<div class="col-md-12">
															<input class="form-control @error('name') is-invalid @enderror" id="name" type="text"  name="name" 
															value="{{ old('name') ?? $cat->name ?? ''}}" required  autofocus>
															@error('name')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
												</div>

											

												<div class="form-group row mb-0">
													<div class="col-md-12 offset-md-4" style="display:flex; flex-direction:row">
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
