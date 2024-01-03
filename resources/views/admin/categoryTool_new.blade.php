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
								
								<!-- <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a> -->
								
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
											<h2 class="short"><strong>Registre la </strong>categoría</h2>
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
