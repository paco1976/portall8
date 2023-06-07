@extends('layouts.admin')
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('main')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
								<h1>Prestamos</h1>
							</div>
						</div>
					</div>
				</section>
				<div class="alert alert-primary alert-dismissible fade show" role="alert">
						@if (Session::has('message'))
							<p style="text-aligne:center">{{ Session::get('message') }}</p>
						@endif
						@if (Session::has('error'))
							<p style="text-aligne:center">{{ Session::get('error') }}</p>
						@endif
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<!-- <div class="tab-pane active col-md-12 mx-auto "  >
					<div class="row">
						@if (Session::has('message'))
							<p style="text-aligne:center">{{ Session::get('message') }}</p>
						@endif
						@if (Session::has('error'))
						<p style="text-aligne:center">{{ Session::get('error') }}</p>
						@endif
				</div>	 -->

				<div class="container">
					<div class="row">
							<div class="col-md-6" style="display:block;justify-content:center">
								<div class="tabs" >
									<ul class="nav nav-tabs">
										<li class="active">
											<a href=""><i style="font-size:30px;margin-right:5px" class="fa fa-wrench"></i> Nuevo Prestamos</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active">
											<h2 class="short"><strong>Registro </strong></h2>
												
												@if ($tool_selectd)
												<form  method="post" action="{{ route('admin_loan_save') }}"  id="save">	
													@csrf										
													<div class="form-group row">
													<div class="col-md-12">
														<label for="tool" class="col-md-8 col-form-label text-md-right">
															<h5>Herramienta Seleccionada: {{$tool_selectd->name}}</h5>	
														</label>
													</div>
													<div class="col-sm-9 mt-2">
														<input type="hidden"  id="tool_selectd" class="form-control" name="tool_selectd" required
														placeholder=" {{$tool_selectd->name}}" value=" {{$tool_selectd->id}}" />
													</div> 
														@error('user_type')
                                                		<span class="invalid-feedback" role="alert">
                                                    		<strong>{{ $message }}</strong>
                                               			 </span>
                                            			@enderror
                                    				</div>
													<div class="form-group row">
													<div class="col-md-12">
														<label for="name" class="col-md-4 col-form-label text-md-right">Dias disponibles</label>
													</div>
													<div class="col-sm-9 mt-2">
														<input type="datetime-local"  id="dates" class="form-control" name="dates" required 
														placeholder=""  />
													</div>
														@error('user_type')
                                                		<span class="invalid-feedback" role="alert">
                                                    		<strong>{{ $message }}</strong>
                                               			 </span>
                                            			@enderror
                                    				</div>
													<div class="form-group row mb-0"><br>
													<div class="col-md-12 offset-md-4">
														<button type="submit" class="btn btn-primary">
															Guardar
														</button>
														<button  class="btn btn-danger">
																<a href="{{ Url('/admin_loan_new') }}" style="text-decoration:none; color:white" >Cancelar</a>
														</button>
													</div>
													</div>
												</form>
											@else
											<form  method="GET" action="{{ route('admin_loan_dates') }}" id="dates" >											
												@csrf										
												<div class="form-group row">
													<div class="col-md-12">
														<label for="tool_id" class="col-md-4 col-form-label text-md-right">Herramienta</label>
													</div>

                                        			<div class="col-md-12">
                                           				<select class="form-control" name="tool_id"  id="tool_id" required>
                                                			<option value="">Seleccione una opción</option>
                                               				@foreach ($tools as $tool)
                                                        	<option value='{{ $tool->id }}'>{{ $tool->name }}IDE {{ $tool->id }}</option>
                                                			@endforeach
                                           				</select>

                                            			@error('user_type')
                                                		<span class="invalid-feedback" role="alert">
                                                    		<strong>{{ $message }}</strong>
                                               			 </span>
                                            			@enderror
                                        			</div>
                                    			</div>
												<div class="form-group row mb-0"><br>
													<div class="col-md-12 offset-md-4">
														<button type="submit" class="btn btn-primary">
															Disponibilidad
														</button>
													</div>
												</div>
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

@push('script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
	$(document).ready(function() {
		var js_array = [<?php echo '"'.implode('","', $dates_).'"' ?>];
		console.log(js_array)
		var date= $("input[type='datetime'], input[type='datetime-local']").flatpickr({
		// 	onReady: function () {
		// 	this.jumpToDate("2025-01")
		// },
		disable: js_array,
		dateFormat: "Y-m-d",
		mode: "range",
		minDate: new Date(),
      });
	});

	

</script>
@endpush