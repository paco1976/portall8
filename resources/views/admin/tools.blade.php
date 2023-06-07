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



				<div class="container">
					<div style="display:flex;flex-direction:row" class="col-lg-12">
						<form id="contactForm" action="{{route('getLoansByName')}}" method="get" class="row col-lg-6">
							<div class="form-group" style="display:flex; flex-direction:row" class="col-lg-6">
								<div>
									<!-- <label>Buscador</label> -->
									<input type="text" placeholder="Nombre del profesional" 
									maxlength="100" class="form-control" name="name" id="name" required>
								</div>
								<button id="addToTable" type="submit" class="btn btn-secondary" >Buscar </button>
							</div>
						</form>
						<form class="row" id="contactForm" action="{{route('toolsFilters')}}" method="get" class="row col-lg-6">
							<div class="form-group" style="display:flex; flex-direction:row;" class="col-lg-6" >
									<div>
										<input class="form-control col-lg-6" list="browsers" 
											placeholder="Seleccione el filtro"  name="filter" id="browser">
										<datalist id="browsers">
											<option value='1'>Aprobados</option>
											<option value="Firefox">No Aprobados</option>
											<option value="Chrome">Pendientes</option>
											<option value="Opera">Proximos a vencer</option>
											<option value="Safari">Vencen Hoy</option>
										</datalist>
									</div>
									<button id="addToTable" type="submit" class="btn btn-secondary" >Filtrar </button>
							</div>
						</form>
						<!-- <label>Session</label> -->
						<div class="row" class="col-lg-3">
							<div>
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
							<div class="col-md-1" style="float:right">
								<div class="mb-md">
								
									<a href="{{ route('admin_loan_new') }}">
										<button id="addToTable" class="btn btn-primary">Iniciar Prestamo </button>
									</a>
								</div>
							</div>
						</div>
					</div>
					
					
					
					@if($loans)
					<div class="row">
						<div class="col-md-12">
						<br><br>

								<tbody>
								@foreach($loans as $loan)

								<div class="card" style="width: 18rem;">
									<div class="card-img-top"></div>
									<div class="card-body">	
										<div class="card" style="width: 18rem;">										
											<ul class="list-group list-group-flush">
												<li class="list-group-item" style="display:flex;flex-direction:row; justify-content:space-between">
													<P>PRESTAMO</P>
													<p class="card-text">{{$loan->prestamoId}}</p>
												</li>
												<li class="list-group-item" style="text-align:right"><h5 class="card-title">{{$loan->herramientaNombre}}</h5></li>
												<li class="list-group-item" style="display:flex;flex-direction:row; justify-content:space-between">
													<P>ESTADO</P>
													<p class="card-text">{{$loan->estado}}</p>
												</li>
												<li class="list-group-item">{{$loan->nombre}}</li>
												<li class="list-group-item">{{$loan->apellido}}</li>
											</ul>
											<ul class="list-group list-group-flush">
												<li class="list-group-item">{{$loan->descripcion}}</li>
												<li class="list-group-item">Identificador: {{$loan->herramientaId}}</li>
												<li class="list-group-item">{{$loan->inicio}}</li>
												<li class="list-group-item">{{$loan->fin}}</li>
												<li style="font-weight: 600;" class="list-group-item">{{$loan->aprobado == 0 ? "PRESTAMO NO APROBADO":"PRESTADA"}}</li>

											</ul>
										
										</div>
										<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
										@if($loan->aprobado)
										<td style="text-align:center; width:100%">
											<a href="{{ route('admin_loan_enable', ['loan_id' => $loan->prestamoId] ) }}" class="btn btn-danger">CANCELAR PRESTAMO</a>
										</td>
										@else
										<td style="text-align:center;width:100%">
											<a href="{{ route('admin_loan_enable',['loan_id' => $loan->prestamoId] ) }}" class="btn btn-success"> HABILITAR PRESTAMO </a>
										</td>
										@endif
									</div>
								</div>
								
								@endforeach


								</tbody>
						</div>

					</div>
					<div class="row">

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
