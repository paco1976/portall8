@extends( 'layouts.home')

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
								@if(Auth::user()->user_type()->first()->name=='Administrador')
									<h1>Préstamos</h1>
								@else
									<h1>Mis préstamos</h1>
								@endif
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
			@if(Auth::user()->user_type()->first()->name=='Administrador')			
			<div class="container" style="margin:0px; padding:10px; width:100%">
							<form  id="contactForm" action="{{route('loans')}}" method="get" style="display:flex; flex-direction:row;justify-content: space-between;">
								<!-- Filtro Por profesional -->		
								<div style="width:30%" >
									<input type="text" placeholder="Nombre del profesional" maxlength="100" class="form-control" name="name" id="name">
								</div>
								<!-- Filtro Por estado prestamo -->
								<div style="width:30%" >
											<select id="state" name="state" class="form-control">
												<option value="">Todos los Estados</option>
												<option value="approved">Aprobados</option>
												<option value="refused">No Aprobados</option>
												<option value="close">Cerrados</option>
												<option value="pending">Pendientes</option>
											</select>
								</div>
								<!-- Filtro Por dia -->
								<div style="width:30%" >
									<div class="col-sm-9 mt-2">
										<input type="month"  id="date" class="form-control" name="date" value=""/>
									</div>
								</div>
								<div style="width:5%">
								<button id="addToTable" type="submit" class="btn btn-secondary" >Filtrar </button>
								</div>

							</form>
			</div>
			@endif
			<div class="row"  style=" padding:10px;">
				<div class="col-sm-6">
					<div class="mb-md" style="margin-top:20px">
					
						<a href="{{ route('toolsList') }}">
							<button id="addToTable" class="btn btn-primary">Nuevo préstamo </button></a>
					</div>
				</div>
			</div>
			
			<!-- Si es admin -->
			<br><br>
			@if($loans)
			<div  style="padding:10px;flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-arround; margin: rigth 20px;">	
				@foreach($loans as $loan)
				<div class="card" style="width: 25rem;margin: 10px;" >										
					<ul class="list-group list-group-flush">
							<li class="list-group-item" style="background-color:gainsboro;display:flex;flex-direction:row; justify-content:space-between">
								<P>PRESTAMO</P>
								<p class="card-text">{{$loan->loanId}}</p>
							</li>
							<li class="list-group-item" ><h5 class="card-title">{{$loan->toolName}}</h5></li>
							<li class="list-group-item">{{$loan->descirption}}</li>
							<li class="list-group-item" style="background-color:whitesmoke;display:flex;flex-direction:row; justify-content:space-between">
							<P>Herramienta Id</P>
							<P class="card-text">{{$loan->toolId}}</P>
							</li>
							<li class="list-group-item">Desde {{date('d/ m/ Y', strtotime($loan->init))}}</li>
							<li class="list-group-item">Hasta {{date('d/ m/ Y', strtotime($loan->finish))}}</li>
							<li class="list-group-item" style="background-color:whitesmoke;display:flex;flex-direction:row; justify-content:space-between">
								<P>Estado</P>
								@if($loan->state_id == 2 )
								<p style="font-weight: 600; color:red" >Rechazado</p>
								@elseif($loan->state_id == 4)
									<p style="font-weight: 600; color:black" >Finalizado</p>
									<li class="list-group-item">Cerrado {{date('d/ m/ Y', strtotime($loan->close))}}</li>
								@elseif($loan->state_id == 1)
								<p style="font-weight: 600;" >Aprobado</p>
								@else($loan->state_id == 3)
								<p style="font-weight: 600;" >Pendiente</p>
								@endif
							</li>												
							<!-- Si es admin -->
							@if(Auth::user()->user_type()->first()->name=='Administrador')
								<li class="list-group-item">{{$loan->name}} {{$loan->lastName}}</li>
								@if($loan->state_id == 1)
								<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId,'state' => 4] ) }}" class="btn btn-primary">Finalizar</a>					
								@elseif($loan->state_id == 3)
								<div style="display:flex; flex-direction:row">
									<a style="text-align:center; width:50%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId,'state' => 1] ) }}" class="btn btn-success">Habilitar</a>					
									<a style="text-align:center;width:50%; margin-bottom: 30px;" href="{{ route('admin_loan_enable',['loan_id' => $loan->loanId, 'state' => 2] ) }}" class="btn btn-danger"> Rechazar </a>													
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
				No hay prestamos a profesionales de tu CFP por el momento.
				</div>
			</div>
			@endif
	</div>
@endsection


