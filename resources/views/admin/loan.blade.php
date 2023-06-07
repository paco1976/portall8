@extends('layouts.admin')

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
									<h1>Prestamos</h1>
								</div>

							</div>
						</div>
					</section>


						<!-- <label>Session</label> -->
						
				<div class="container">
					<div class="row" style="display:flex; flex-direction:row;justify-content: speace-arround;margin-left:1px">
						<form id="contactForm" action="{{route('getLoansByName')}}" method="get" class="col" style="margin-right :20px;width:45%">
								<div class="form-group" style="display:flex; flex-direction:row;" >
										<input type="text" placeholder="Nombre del profesional" 
										maxlength="100" class="form-control" name="name" id="name" required>
									<button id="addToTable" type="submit" class="btn btn-secondary" >Buscar </button>
								</div>
							</form>
						<form  id="contactForm" action="{{route('getLoansByState')}}" method="get" class="col" style="width:45%">
								<div class="form-group" style="display:flex; flex-direction:row;">
											<select id="filter" name="filter" class="form-control">
												<option value="all">Todos</option>
												<option value="approved">Aprobados</option>
												<option value="refused">No Aprobados</option>
												<option value="pending">Pendientes</option>
											</select>
										<button id="addToTable" type="submit" class="btn btn-secondary" >Filtrar </button>
								</div>
						</form>
						<a href="{{ route('loansByDate') }}" style="margin-left:10px">
									<button id="addToTable" class="btn btn-info">Ordenar por Fecha </button>
						</a>
					</div>
				<div class="row">
						<div class="col-md-12">
							@if (Session::has('message'))
							<div class="alert alert-success">
								<p>{{ Session::get('message') }}</p>
							</div>
							@endif
							@if (Session::has('error'))
							<div class="alert alert-danger">
								<p>{{ Session::get('error') }}</p>
							</div>
							@endif
						</div>
						<div class="col-sm-6">
							<div class="mb-md">
							
								<a href="{{ route('admin_loan_new') }}">
									<button id="addToTable" class="btn btn-primary">Nuevo Prestamo </button>
								</a>
							</div>
						</div>
					</div>
					
					<br><br>
					@if($loans)
					<div  style="flex-wrap: wrap;display:flex;flex-direction:row; justify-content:space-between; margin: rigth 20px;
					 ">	

						@foreach($loans as $loan)
								<div class="card" style="width: 25rem;" >										
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
													@if($loan->approved == 0 )
													<p style="font-weight: 600;" >Rechazado</p>
													@elseif($loan->approved == 1)
													<p style="font-weight: 600;" >Aprobado</p>
													@elseif($loan->approved == -1)
													<p style="font-weight: 600;" >Pendiente</p>
													@endif
												</li>
												
												<li class="list-group-item">PROFESIONAL</li>
												<li class="list-group-item">{{$loan->name}} {{$loan->lastName}}</li>
												<li class="list-group-item">
												@if($loan->approved == 0 || $loan->approved == null || $loan->approved == -1)
												<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId,'state' => 1] ) }}" class="btn btn-success"> HABILITAR PRESTAMO </a>
												@else($loan->approved == 1)
												<a style="text-align:center;width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_enable',['loan_id' => $loan->loanId, 'state' => 0] ) }}" class="btn btn-danger"> CANCELAR PRESTAMO </a>
												@endif
												</li>
									</ul>
									
								</div>
						@endforeach
						</div>

					@else
					<div class="row">
                        <div class="col-12 text center">
                        No hay prestamos a profesionales de tu CFP por el momento.
                        </div>
                    </div>
					@endif
		
				</div>

		</div>

@endsection
