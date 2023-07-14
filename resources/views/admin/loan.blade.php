@extends('layouts.admin')

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
							<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button>
                        </div>									
                        @endif				
						<div class="container" style="margin:0px; padding:10px; width:100%">
							<form  id="contactForm" action="{{route('admin_loan')}}" method="get" style="display:flex; flex-direction:row;justify-content: space-between;">
									<div style="width:30%" >
										<input type="text" placeholder="Nombre del profesional" maxlength="100" class="form-control" name="name" id="name">
									</div>
									<div style="width:30%" >
												<select id="state" name="state" class="form-control">
													<option value="">Todos los Estados</option>
													<option value="approved">Aprobados</option>
													<option value="refused">No Aprobados</option>
													<option value="pending">Pendientes</option>
												</select>
									</div>
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
						<div class="row"  style=" padding:10px;">
								<div class="col-sm-6">
									<div class="mb-md" style="margin-top:20px">
									
										<a href="{{ route('loan_new_admin') }}">
											<button id="addToTable" class="btn btn-primary">Nuevo Prestamo </button>
										</a>
										<a href="{{ route('loan_debt_admin') }}">
											<button id="addToTable" class="btn btn-secondary">Actualizar Deudas</button>
										</a>
									</div>
								</div>
						</div>
						
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
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
													
													<!-- <li class="list-group-item">PROFESIONAL</li> -->
													<li class="list-group-item">{{$loan->name}} {{$loan->lastName}}</li>
													@if($loan->state_id == 1)
													<a style="text-align:center; width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId,'state' => 2] ) }}" class="btn btn-danger"><i class="bi bi-hand-thumbs-up-fill">Rechazar</i></a>					
													@elseif($loan->state_id == 3)
													<div style="display:flex; flex-direction:row">
													<a style="text-align:center; width:50%; margin-bottom: 30px;" href="{{ route('admin_loan_enable', ['loan_id' => $loan->loanId,'state' => 1] ) }}" class="btn btn-success"><i class="bi bi-hand-thumbs-up-fill">Habilitar</i></a>					
													<a style="text-align:center;width:50%; margin-bottom: 30px;" href="{{ route('admin_loan_enable',['loan_id' => $loan->loanId, 'state' => 2] ) }}" class="btn btn-danger"> Rechazar </a>													
													</div>
													@elseif($loan->state_id == 2)
													<a style="text-align:center;width:100%; margin-bottom: 30px;" href="{{ route('admin_loan_enable',['loan_id' => $loan->loanId, 'state' => 1] ) }}" class="btn btn-success"> Habilitar</a>
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


<script>

$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
</script>