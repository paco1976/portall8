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
						Pañol de Herramientas
					</h1>
					
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
					
					<a href="#" class="btn btn-primary btn-outline btn-outline-thin btn-outline-light-opacity-2 btn-effect-5 font-weight-semi-bold px-4 btn-py-2 text-3 text-color-light text-color-hover-dark ms-2"   data-bs-toggle="modal" data-bs-target="#defaultModal">¿Como Funciona?<i class="icon-info icons ms-1"></i></a>
				</div>

			</div>
		</div>
	</section>

	<div role="main" class="main" id="ver">

	@if (Session::has('message'))
	<div class="alert alert-success" style="display:flex; flex-direction:row; justify-content:space-between">
		<p>{{ Session::get('message') }}</p>
		<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	<div class="container">
	<div class="row">
	<div class="col-sm-4">
		<form id="contactForm" action="{{route('toolsList')}}" method="get" >
			<div>
				<select class="form-control @error('category') is-invalid @enderror" name="categoryId" id="categoryId" onchange="this.form.submit();" required>
					<option value="" disabled selected>Seleccione una opción</option>
					@foreach ($categories as $category)
					<option value='{{ $category->id }}' {{ $categoryId == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
					@endforeach
				</select>
			</div>
			<!-- <div style="width:50%">
				<button id="addToTable" type="submit" class="btn btn-secondary">Filtrar</button>
			</div> -->
		</form>
	</div>
		<!-- Botón de cómo funciona con modal -->
	@if(Auth::user()->user_type()->first()->name!='Administrador')
	<div class="col-sm-2">
		<button class="btn btn-info btn-small " data-toggle="modal" data-target="#myModal">
			<i class="fa fa-question-circle"></i> ¿Cómo funciona?
		</button>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Bienvenido al pañol de herramientas comunitario</h4>
					</div>
					<div class="modal-body">

						<h4 class="panel-title">
							<strong>¿Cómo solicito un préstamo?</strong>
						</h4>
						<div class="panel-body">
						En el pañol de herramientas verás todas las herramientas disponibles. 
						Hacé click en la que te interese, y al ingresar se te mostrará un calendario con las fechas disponibles.
						Una vez solicitado el préstamo, deberás esperar la aprobación del administrador para ir a buscar la herramienta.
						</div>
						<h4 class="panel-title">
							<strong>¿Cuándo tengo que devolver la herramienta?</strong>
						</h4>
						<div class="panel-body">
						Podrás solicitar el préstamo de la herramienta que necesites por un máximo de 7 días. Si querés prolongar el préstamo deberás ingresar nuevamente a la página para renovarlo.
						</div>
						<h4 class="panel-title">
							<strong>¿Cómo puedo ver los préstamos que solicité?</strong>
						</h4>
						<div class="panel-body">
						En el menú Panel de control, entrando a "Mis préstamos" vas a poder ver todos los préstamos solicitados y sus estados. 
								
						</div>		

						<div class="alert alert-info">
							<strong>Por cualquier duda, comunicate con el/la administracidor/a del pañol.</strong>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
	@endif
	<!-- Fin modal -->
	</div>
	</div>

	

	</div>
	@if(Auth::user()->user_type()->first()->name=='Administrador')
	<div class="container" style="padding:10px;flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-arround; ">
		<div class="col-sm-2" style="margin-top:20px">
			<a href="{{ route('admin_tool_new') }}">
				<button id="addToTable" class="btn btn-primary">Nueva herramienta</button>
			</a>
		</div>
		<div class="col-sm-2" style="margin-top:20px">
			<a href="{{ route('admin_categoryTools') }}">
				<button id="addToTable" class="btn btn-secondary">Administrar categorías</button>
			</a>
		</div>
	</div>
	@endif

	<br><br>

	@if($tools)
	<div class="container" style="padding:10px;flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-arround; ">

		@foreach($tools as $tool)
		<a href="{{ route('admin_loan_dates', ['id' => $tool->id] ) }}" style="text-decoration: none;">
		<div class="card" style="width: 15rem;margin: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
			<ul class="list-group list-group-flush" style="border: none;">
				<!-- Administrar para Admin -->
				@if(Auth::user()->user_type()->first()->name=='Administrador')
				<li class="list-group-item" style="background-color:gainsboro;">
				<small class="text-muted">ID {{$tool->id}}</small>
				 </li> 
				@endif
				<div style="height: 200px; position: relative; overflow: hidden;">
    			<div class="img-responsive" style="background-image: url('{{ empty($tool->nameImage) ? Storage::disk('tools')->url('tool_default.jpg') : Storage::disk('tools')->url($tool->nameImage) }}'); width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform 0.3s;"
                            onmouseover="this.style.transform = 'scale(1.1)';"
                            onmouseout="this.style.transform = 'scale(1)';"></div>
				</div>	

				
					<h6 class="card-title" style="margin-left: 15px; margin-top: 25px; font-size: 1rem; color: black;">{{$tool->name}}</h6>
				<!-- @if($tool->active == 1) -->
				<!-- Seleccionar para prestamos Todos -->
				<!-- <div style="display:flex; flex-direction:row">
					<a style="text-align:center; width:100%; margin-bottom: 3px;" href="{{ route('admin_loan_dates', ['id' => $tool->id] ) }}" class="btn btn-primary"><i class="bi bi-hand-thumbs-up-fill">Seleccionar para prestamo</i></a>
				</div> -->
				<!-- @endif -->
				<!-- Administrar para Admin -->
				@if(Auth::user()->user_type()->first()->name=='Administrador')
				@if($tool->active == 1)
				<!-- Seleccionar para prestamos Todos -->
				<div style="display:flex; flex-direction:column">
					<a style="text-align:center; width:100%; margin-bottom: 10px" href="{{ route('admin_tool_edit', ['id' => $tool->id] ) }}" class="btn btn-primary"><span class="bi bi-pencil-square"> Editar</span></a>
					<a style="text-align:center; width:100%;" href="{{ route('admin_tool_state', ['id' => $tool->id] ) }}" class="btn btn-danger"><span class="bi bi-x-circle"> Deshabillitar</span></a>
				</div>
				@else
				<div style="display:flex; flex-direction:row">
					<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_tool_state', ['id' => $tool->id] ) }}" class="btn btn-success"><i class="bi bi-hand-thumbs-up-fill">Habilitar</i></a>
				</div>
				@endif
				@endif
			</ul>
			</a>

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
			No hay herramientas disponibles en este momento.
		</div>
	</div>
	@endif
</div>
</div>


@endsection