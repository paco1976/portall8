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
								<h1>Herramientas</h1>
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
											<a href=""><i style="font-size:30px;margin-right:5px" class="fa fa-wrench"></i> Nuevo ingreso</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active">
											<h2 class="short"><strong>Registre </strong>la herramienta</h2>
											<form  method="POST" action="{{ route('tool_save') }}" enctype="multipart/form-data">
												
												@csrf

												<input style="display:none;" id="toolId" type="text"  name="toolId" 
															value="{{ old('toolId') ?? $tool->id ?? ''}}">
												<div class="row" >
													<div class="form-group">
														<div class="col-md-12">
															<label for="categoryId" class="col-form-label text-md-right">Categoría</label>
														</div>
														<div class="col-md-12">
															<select class="form-control @error('categoryId') is-invalid @enderror" name="categoryId"  id="categoryId" required>
																<!-- <option value="">Seleccione una opción</option> -->
																@foreach ($categories as $category)
																<option value="{{ old('categoryId') ?? $category->id ?? ''}}">{{ $category->name }}</option>
																@endforeach
															</select>
															@error('categoryId')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
												</div>
												<div class="row" >
													<div class="form-group">
														<div class="col-md-12">
															<label for="name" class="col-form-label text-md-right" >Nombre</label>
														</div>
														<div class="col-md-12">
															<input class="form-control @error('name') is-invalid @enderror" id="name" type="text"  name="name" 
															value="{{ old('name') ?? $tool->name ?? ''}}" required  autofocus>
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
															<label for="description" class="col-form-label text-md-right">Descripción</label>
														</div>

														<div class="col-md-12">										
															<textarea rows="5" id="description" class="form-control @error('description') is-invalid @enderror" name="description" 
																required autofocus >{{ old('description') ?? $tool->description ?? ''}}</textarea>
															@error('description')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
												</div>

												<div class="form-group row">											                                 		
												
												<label class="col-md-4 col-form-label text-md-right">Cargar imagen </label>

                                        		<div class="col-md-6">
                                            	<input id="nameImage" type="file" class="form-control @error('nameImage') is-invalid @enderror" name="nameImage" value="{{ old('nameImage') ?? $tool->nameImage ?? ''}}">
                                           		 @error('nameImage')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            	@enderror
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
											@if(isset($tool) && $tool->nameImage)
    											<img class="img-thumbnail" width="200" src="{{ Storage::disk('tools')->url($tool->nameImage) }}" alt="Tool Image">
												<form method="POST" action="{{ route('delete_tool_image', ['id' => $tool->id]) }}">
        										@csrf
        										@method('DELETE')
        										<button type="submit" class="btn btn-danger">Eliminar imagen</button>
    											</form>
											@endif       

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

@endsection
