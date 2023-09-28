@extends('layouts.home')

@section('main')

		<div role="main" class="main" >




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
										Categorías de herramientas
									</h1>
									
									<!-- <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a> -->
									
								</div>
				
							</div>
						</div>
					</section>
				
					

					@if (Session::has('message'))
                        <div class="alert alert-success" style="display:flex; flex-direction:row; justify-content:space-between">
                            <p >{{ Session::get('message') }}</p>
							<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button>
                        </div>									
                        @endif				
						<div class="container" style="margin:auto; padding:10px; width:100%">
							<form  id="contactForm" action="{{route('admin_categoryTools')}}" method="get" style="display:flex; flex-direction:row;justify-content: space-between;">
									<div style="width:30%" >
										<input type="text" placeholder="Nombre de la categoria" maxlength="100" class="form-control" name="name" id="name">
									</div>
									<div style="width:5%">
										<button id="addToTable" type="submit" class="btn btn-secondary" >Filtrar </button>
									</div>
							</form>
						
						<div class="row"  style=" padding:10px;">
								<div class="col-sm-6">
									<div class="mb-md" style="margin-top:20px">
									
										<a href="{{ route('admin_categoryTool_new') }}">
											<button id="addToTable" class="btn btn-primary">Nueva categoría </button>
										</a>
									</div>
								</div>
						</div>
						@if($categories)
						<div  style="padding:10px;flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-arround; margin: rigth 20px;">	

							@foreach($categories as $category)
							<div class="card" style="width: 20rem;margin: 10px;" >										
								<ul class="list-group list-group-flush" style="list-style:none">
									<li class="list-group-item" style="background-color:gainsboro;display:flex;flex-direction:row; justify-content:space-between">
										<small class="text-muted">ID {{$category->id}}</small>
									</li>
									<li class="list-group-item" ><h5 class="card-title">{{$category->name}}</h5></li>
									<li>
									<div style="display:flex; flex-direction:column">
											<a style="text-align:center; width:100%; margin-bottom: 10px" href="{{ route('admin_categoryTool_edit', ['id' => $category->id] ) }}" class="btn btn-primary"><span class="bi bi-pencil-square"> Editar</span></a>					
									@if($category->active == 1)
										<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_categoryTool_delete', ['id' => $category->id] ) }}" class="btn btn-danger"><span class="bi bi-x-circle"> Deshabilitar</span></a>					
										@else
										<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_categoryTool_delete', ['id' => $category->id] ) }}" class="btn btn-success"><span class="bi bi-hand-thumbs-up-fill"> Habilitar</span></a>					
										@endif						
									</div>
									</li>
								</ul>
										
							</div>
							@endforeach
						</div>
					</div>

						@else
						<div class="row">
							<div class="col-12 text center">
							No hay categorias  por el momento.
							</div>
						</div>
						@endif
		</div>

@endsection


