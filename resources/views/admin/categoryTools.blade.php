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
									<h1>Categorias de herramientas</h1>
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
						</div>
						<div class="row"  style=" padding:10px;">
								<div class="col-sm-6">
									<div class="mb-md" style="margin-top:20px">
									
										<a href="{{ route('admin_categoryTool_new') }}">
											<button id="addToTable" class="btn btn-primary">Nueva Catgeoria </button>
										</a>
									</div>
								</div>
						</div>
						@if($categories)
						<div  style="padding:10px;flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-arround; margin: rigth 20px;">	

							@foreach($categories as $category)
							<div class="card" style="width: 25rem;margin: 10px;" >										
										<ul class="list-group list-group-flush" style="list-style:none">
													<li class="list-group-item" style="background-color:gainsboro;display:flex;flex-direction:row; justify-content:space-between">
														<p class="card-text">IDE {{$category->id}}</p>
														<div style="display:flex; flex-direction:row">
															<a style="text-align:center; width:100%;" href="{{ route('admin_categoryTool_edit', ['id' => $category->id] ) }}" class="btn btn-primary"><i class="bi bi-hand-thumbs-up-fill">Editar</i></a>					
														</div>
													</li>
													<li class="list-group-item" ><h5 class="card-title">{{$category->name}}</h5></li>
													<li>
													<div style="display:flex; flex-direction:row">
														<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_categoryTool_delete', ['id' => $category->id] ) }}" class="btn btn-danger"><i class="bi bi-hand-thumbs-up-fill">Eliminar</i></a>					
													</div>
													</li>
													
													
										</ul>
										
							</div>
							@endforeach
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


