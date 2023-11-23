@extends( 'layouts.home')

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
						@if(Auth::user()->user_type()->first()->name=='Administrador')
							Préstamos
						@else
							Mis préstamos
						@endif
					</h1>
					
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
					
					<a href="#" class="btn btn-primary btn-outline btn-outline-thin btn-outline-light-opacity-2 btn-effect-5 font-weight-semi-bold px-4 btn-py-2 text-3 text-color-light text-color-hover-dark ms-2"   data-bs-toggle="modal" data-bs-target="#defaultModal">¿Como Funciona?<i class="icon-info icons ms-1"></i></a>
				</div>

			</div>
		</div>
	</section>

	<div role="main" class="main" id="ver">
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@if (Session::has('message'))
				<div class="alert alert-success" style="display:flex; flex-direction:row; justify-content:space-between">
					<p>{{ Session::get('message') }}</p>
					<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if (Session::has('error'))
				<div class="alert alert-danger" style="display:flex; flex-direction:row; justify-content:space-between">
					<p>{{ Session::get('error') }}</p>
					<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if(Auth::user()->user_type()->first()->name=='Administrador')
				<div class="row">
						<div class="col-sm-6">
							<div class="mb-md" style="margin-top:10px; margin-bottom:30px">

								<a href="{{ route('toolsList') }}">
									<button id="addToTable" class="btn btn-primary">Nuevo préstamo </button></a>
							</div>
						</div>
				</div>
				
					<div>
						<form id="filterLoans" action="{{route('loans')}}" method="get" style="display:flex; flex-direction:row;justify-content: space-between; ">
							<!-- Filtro Por profesional -->
							<div style="width:30%">
								<input type="text" placeholder="Nombre del profesional" maxlength="100" class="form-control" name="name" id="name" value="{{ request('name') }}">
							</div>
							<!-- Filtro Por estado prestamo -->
							<div style="width:30%">
								<select id="state" name="state" class="form-control">
									<option value="" {{ request('state') === '' ? 'selected' : '' }}>Todos los Estados</option>
									<option value="approved" {{ request('state') === 'approved' ? 'selected' : '' }}>Aprobados</option>
									<option value="refused" {{ request('state') === 'refused' ? 'selected' : '' }}>No Aprobados</option>
									<option value="close" {{ request('state') === 'close' ? 'selected' : '' }}>Cerrados</option>
									<option value="pending" {{ request('state') === 'pending' ? 'selected' : '' }}>Pendientes</option>
								</select>
							</div>
							<!-- Filtro Por dia -->
							<div style="width:20%">
								<input type="month" id="date" class="form-control" name="date" value="{{ request('date') }}" />
							</div>
							<div style="width:15%">
								<button id="addToTable" type="submit" class="btn btn-secondary">Filtrar </button>
								<a href="{{ route('loans') }}"><button class="btn btn-secondary">X</button></a>
							</div>

						</form>
					</div>
					@endif
					
					<!-- Botones -->
					<div class="container" style="margin-top: 20px">
					<div class="row" style="display: flex; justify-content: space-between">
						@if(request('must_pick_up_today'))
						<button onclick="toggleFilter('must_pick_up_today')" id="mustPickUpTodayButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Retiran hoy</caption>
							<h2 style="margin-bottom: 0px">{{ $mustPickUpTodayCount }}</h2>
						</button>
						@else
						<button onclick="toggleFilter('must_pick_up_today')" id="mustPickUpTodayButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Retiran hoy</caption>
							<h2 style="margin-bottom: 0px">{{ $mustPickUpTodayCount }}</h2>
						</button>
						@endif

						@if(request('expiring_today'))
						<button onclick="toggleFilter('expiring_today')" id="expiringTodayButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Devuelven hoy</caption>
							<h2 style="margin-bottom: 0px">{{ $expiringTodayCount }}</h2>	
						</button>
						@else
						<button onclick="toggleFilter('expiring_today')" id="expiringTodayButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Devuelven hoy</caption>
							<h2 style="margin-bottom: 0px">{{ $expiringTodayCount }}</h2>	
						</button>
						@endif

						@if(request('expired'))
						<button onclick="toggleFilter('expired')" id="expiredButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Vencidos</caption>
							<h2 style="margin-bottom: 0px">{{ $expiredCount }}</h2>		
						</button>
						@else
						<button onclick="toggleFilter('expired')" id="expiredButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Vencidos</caption>
							<h2 style="margin-bottom: 0px">{{ $expiredCount }}</h2>
						</button>
						@endif

						@if(request('pending'))
						<button onclick="toggleFilter('pending')" id="pendingButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Pendientes de aprobación</caption>
							<h2 style="margin-bottom: 0px">{{ $pendingApproval }}</h2>
						</button>
						@else
						<button onclick="toggleFilter('pending')" id="pendingButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Pendientes de aprobación</caption>
							<h2 style="margin-bottom: 0px">{{ $pendingApproval }}</h2>
						</button>
						@endif

					</div>
					<!-- Si es admin -->
					<br><br>
					@if($loans)
					<div style="flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-evenly;">
						@foreach($loans as $loan)
						<div class="card" style="width: 20rem;">
							<ul class="list-group list-group-flush">
								<li class="list-group-item" style="background-color:gainsboro;display:flex;flex-direction:row; justify-content:space-between">
									<small>PRÉSTAMO</small>
									<small class="card-text">{{$loan->loanId}}</small>
								</li>
								@if(Auth::user()->user_type()->first()->name=='Administrador')
								<li class="list-group-item" style="display:flex;flex-direction:row; justify-content:space-between">
									<span>Profesional</span>
									<span><b>{{$loan->name}} {{$loan->lastName}}</b></span>
								</li>
								@endif
								<li class="list-group-item">
									<h5>{{$loan->toolName}}</h5>
									<span>ID {{$loan->toolId}}</span>
								</li>
								<li class="list-group-item" style="display:flex;flex-direction:row; justify-content:space-between">
									<span>Fecha de retiro</span>
									<span><b>{{date('d/m/Y', strtotime($loan->init))}}</b></span>
								</li>
								<li class="list-group-item" style="display:flex;flex-direction:row; justify-content:space-between">
									<span>Fecha de devolución</span>
									<span><b>{{date('d/m/Y', strtotime($loan->finish))}}</b></span>
								</li>
								<li class="list-group-item" style="background-color:whitesmoke;display:flex;flex-direction:row; justify-content:space-between">
									<span>Estado</span>
									@if($loan->state_id == 2 )
									<span style="font-weight: 600; color:red">Rechazado</span>
									@elseif($loan->state_id == 4)
									<span style="font-weight: 600; color:black">Finalizado</span>
								<li class="list-group-item">Cerrado {{date('d/m/Y', strtotime($loan->close))}}</li>
								@elseif($loan->state_id == 1)
								<span style="font-weight: 600;">Aprobado</span>
								@else($loan->state_id == 3)
								<span style="font-weight: 600;">Pendiente</span>
								@endif
								</li>
								<!-- Visualizar si la herramienta retirada y devuelta -->
								<li class="list-group-item" style="background-color:whitesmoke;display:flex;flex-direction:row; justify-content:space-between">
									<P>Herramienta</P>
									@if($loan->removed == 1)
									<p style="font-weight: 600; ">Retirada</p>
									@elseif($loan->removed == 0)
									<p style="font-weight: 600;">Sin retirar</p>
									@endif
								</li>
								<li class="list-group-item" style="background-color:whitesmoke;display:flex;flex-direction:row; justify-content:space-between">
									<P>Herramienta</P>
									@if($loan->returned == 1)
									<p style="font-weight: 600; ">Devuelta</p>
									@elseif($loan->returned == 0)
									<p style="font-weight: 600; ">Sin devolver</p>
									@endif
								</li>
								@if(Auth::user()->user_type()->first()->name=='Administrador')
								@if($loan->state_id == 1)
								@if($loan->removed == 0)
								<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_removedTool', ['loan_id' => $loan->loanId] ) }}" class="btn btn-success">Retiró herramienta</a>
								@endif
								@if($loan->removed == 1 && $loan->returned == 0)
								<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_returnedTool', ['loan_id' => $loan->loanId] ) }}" class="btn btn-info">Devolvió herramienta</a>
								@endif
								@endif
								@endif
								<!-- Si es admin -->
								@if(Auth::user()->user_type()->first()->name=='Administrador')
								@if($loan->state_id == 1 && $loan->removed == 1 && $loan->returned == 1 )
								<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId,'state' => 4] ) }}" class="btn btn-primary">Finalizar</a>
								@elseif($loan->state_id == 3)
								<div style="display:flex; flex-direction:row; justify-content: space-between;">
									<a style="text-align:center; width:49.5%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId,'state' => 1] ) }}" class="btn btn-success">Habilitar</a>
									<a style="text-align:center;width:49.5%; margin-bottom: 30px;" href="{{ route('admin_loan_enable',['loan_id' => $loan->loanId, 'state' => 2] ) }}" class="btn btn-danger"> Rechazar </a>
								</div>
								@endif
								@else
								@if($loan->state_id == 1 || $loan->state_id == 3)
								<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId, 'state' => 4] ) }}" class="btn btn-success"><i class="bi bi-hand-thumbs-up-fill">Cancelar</i></a>
								@endif
								@endif



							</ul>

						</div>
						@endforeach
					</div>
					<div class="row">
						<div class="col-12 text center">
							{{ $loans->Links() }}
						</div>
					</div>
				</div>
				@else
				<div class="row">
					<div class="col-12 text center">
						No hay préstamos a profesionales de tu CFP por el momento.
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>

	<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel">Qué hago?</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p><strong>Cómo creo una publicación</strong><br>
						Clic en <a href="#">Agregar Publicación</a>.<br>
						<strong>Completar los datos: </strong> <br>
						1. Seleccionar categoría.<br>
						2. Describir el servicio que va a ofrecer.<br>
						3. Subir foto de los trabajos realizados.<br>
						4. Subir certificado de estudios (formato PDF).<br>
						</p>
						
		<hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
						<p><em>La publicación no serán visible hasta sea validada por la administración del Portal.</em></p>
					
					
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Entiendo</button>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection

<script>
	function toggleFilter(filter) {
		const urlParams = new URLSearchParams(window.location.search);

		// If the filter is already active, clear it
		if (urlParams.has(filter)) {
			urlParams.delete(filter);
		} else {
			// Clear all other filters
			urlParams.delete('expiring_today');
			urlParams.delete('expired');
			urlParams.delete('must_pick_up_today');
			urlParams.delete('pending');

			// Apply the clicked filter
			urlParams.set(filter, 1);
		}

		// Construct the new URL with updated query parameters
		const newUrl = window.location.pathname + '?' + urlParams.toString();
		window.location.href = newUrl;
	}
</script>



