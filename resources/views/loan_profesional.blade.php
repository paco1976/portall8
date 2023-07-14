@extends('layouts.panel')

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
									<h1>Prestamos</h1>
								</div>
							</div>
						</div>
					</section>
					@if (Session::has('message'))
                        <div class="alert alert-success" style="display:flex; flex-direction:row; justify-content:space-between">
                            <p >{{ Session::get('message') }}</p>
							<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
                        </div>									
                        @endif				
						<div class="container" style="margin:0px; padding:10px; width:100%">
							<form  id="contactForm" action="{{route('admin_loan')}}" method="get" 
										style="display:flex; flex-direction:row;justify-content: space-between;">
									<div style="width:40%" >
												<select id="state" name="state" class="form-control">
													<option value="">Todos los Estados</option>
													<option value="approved">Aprobados</option>
													<option value="refused">No Aprobados</option>
													<option value="pending">Pendientes</option>
												</select>
									</div>
									<div style="width:40%" >
										<div class="col-sm-9 mt-2">
											<input type="month"  id="date" class="form-control" name="date" value=""/>
										</div>
									</div>
									<div style="width:10%">
									<button id="addToTable" type="submit" class="btn btn-secondary" >Filtrar </button>
									</div>

							</form>
						</div>
						<div class="row"  style=" padding:10px;">
								<div class="col-sm-6">
									<div class="mb-md" style="margin-top:20px">
									
										<a href="{{ route('loan_new_profesional') }}">
											<button id="addToTable" class="btn btn-primary">Nuevo Prestamo </button>
										</a>
									</div>
								</div>
						</div>
					
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
														@elseif($loan->state_id == 1)
														<p style="font-weight: 600;" >Aprobado</p>
														@else($loan->state_id == 3)
														<p style="font-weight: 600;" >Pendiente</p>
														@endif
													</li>												
													@if($loan->state_id == 1 || $loan->state_id == 3)
													<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('loan_cancel', ['loan_id' => $loan->loanId] ) }}" class="btn btn-success"><i class="bi bi-hand-thumbs-up-fill">Cancelar</i></a>					
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


