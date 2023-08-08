@extends('layouts.home')

@section('main')

		<div role="main" class="main" >
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
                        <div class="alert alert-success" style="display:flex; flex-direction:row; justify-content:space-between">
                            <p >{{ Session::get('message') }}</p>
							<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button>
                        </div>									
                        @endif				
						<div class="container" style="margin:0px; padding:10px; width:100%">
							<form  id="contactForm" action="{{route('toolsList')}}" method="get" style="display:flex; flex-direction:row;justify-content: space-between;">
									<div style="width:30%" >
										<select class="form-control @error('category') is-invalid @enderror" name="categoryId"  id="categoryId" required>
											<option value="">Seleccione una opción</option>
											@foreach ($categories as $category)
											<option value='{{ $category->id }}'>{{ $category->name }}</option>
											@endforeach
										</select>
									</div>
									<div style="width:5%">
										<button id="addToTable" type="submit" class="btn btn-secondary" >Filtrar</button>
									</div>
							</form>
						</div>
						@if(Auth::user()->user_type()->first()->name=='Administrador')			
						<div class="row"  style=" padding:10px;">
							<div class="col-sm-2" style="margin-top:20px">
								<a href="{{ route('admin_tool_new') }}" >
									<button id="addToTable" class="btn btn-primary">Nueva Herramienta</button>
								</a>
							</div>
							<div class="col-sm-2" style="margin-top:20px">
								<a href="{{ route('admin_categoryTools') }}" >
									<button id="addToTable" class="btn btn-secondary">Administrar Categorias</button>
								</a>
							</div>
						</div>	
						@endif	
						<br><br>
						@if($tools)
						<div  style="padding:10px;flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-arround; ">	

							@foreach($tools as $tool)
									<div class="card" style="width: 15rem;margin: 10px;" >										
										<ul class="list-group list-group-flush">
											<li class="list-group-item" style="background-color:gainsboro;display:flex;flex-direction:row; justify-content:space-between">
												<p class="card-text">Ide {{$tool->id}}</p>
												<!-- Administrar para Admin -->
												@if(Auth::user()->user_type()->first()->name=='Administrador')			
												<div style="display:flex; flex-direction:row">
													<a style="text-align:center; width:100%;" href="{{ route('admin_tool_edit', ['id' => $tool->id] ) }}" class="btn btn-primary"><i class="bi bi-hand-thumbs-up-fill">Editar</i></a>					
												</div>
												@endif
											</li>
											<li class="list-group-item" ><h5 class="card-title"> <span style="color:black">Categoria</span> {{$tool->categoryName}}</h5></li>
											<li class="list-group-item" ><h5 class="card-title">{{$tool->name}}</h5></li>
											<li class="list-group-item">{{$tool->description}}</li>
											@if($tool->active == 1)
												<!-- Seleccionar para prestamos Todos -->
												<div style="display:flex; flex-direction:row">
													<a style="text-align:center; width:100%; margin-bottom: 3px;" href="{{ route('admin_loan_dates', ['id' => $tool->id] ) }}" class="btn btn-primary"><i class="bi bi-hand-thumbs-up-fill">Seleccionar para prestamo</i></a>					
												</div>
												@endif
											<!-- Administrar para Admin -->
											@if(Auth::user()->user_type()->first()->name=='Administrador')								
												@if($tool->active == 1)
												<!-- Seleccionar para prestamos Todos -->
												<div style="display:flex; flex-direction:row">
													<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_tool_state', ['id' => $tool->id] ) }}" class="btn btn-danger"><i class="bi bi-hand-thumbs-up-fill">Deshabillitar</i></a>					
												</div>
												@else
												<div style="display:flex; flex-direction:row">
													<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_tool_state', ['id' => $tool->id] ) }}" class="btn btn-success"><i class="bi bi-hand-thumbs-up-fill">Habilitar</i></a>					
												</div>
												@endif
											@endif
										</ul>
										
									</div>
							@endforeach
						</div>
							<div class="row">
								<div class="col-12">
									{{ $tools->Links() }}
								</div>
                   			</div>
						@else
							<div class="row">
								<div class="col-12 text center">
								No hay Herramientas disponibles en CFP por el momento.
								</div>
							</div>
						@endif
						</div>
		</div>

@endsection


