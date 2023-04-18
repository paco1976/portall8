@extends('layouts.referente')

@section('main')

			<div role="main" class="main">


				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
								<li class="active">Mensajes del profesional {{$publicacion->user->name }} {{ $publicacion->user->last_name }}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1><a href="{{ route('publicaciones_user', ['user_hash' => $publicacion->user->hash]) }}" > Volver a PUBLICACIONES</a></h1>
							</div>

						</div>
					</div>
				</section>



					<div class="container">

					<form id="contactForm" action="#" method="POST">
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Buscador</label>
											<input type="text" value="" data-msg-required="Ingresa palabra clave." maxlength="100" class="form-control" name="name" id="name" required>
										</div>

									</div>
								</div>
					</form>


					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
								<thead>

									<tr>
										
                                        <th>Contacto</th>
										<th>Asunto</th>
										<th>Mail</th>
										<th>Teléfono</th>
                                        <th>Fecha</th>
										
										<th>Mensajes</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($interactionhead_all as $interactionhead)
									<tr class="gradeX">
                                    
                                        <td>{{$interactionhead->name}} {{$interactionhead->last_name}}</td>
										<td>{{$interactionhead->subjet->name}}</td>
										<td>{{$interactionhead->email}}</td>
										<td>{{$interactionhead->mobile}}</td>
                                        <td>{{$interactionhead->date}}</td>
										<td class="actions" style="text-align:center">
											@if($interactionhead->message_not_read > 0)
											<a href="{{ route('mensajes', ['head_hash'=> $interactionhead->hash]) }}" class="btn btn-danger"><i class="fa fa-comments"></i></a>
											@else
											<a href="{{ route('mensajes', ['head_hash'=> $interactionhead->hash]) }}" class="btn btn-success"><i class="fa fa-comments"></i></a>
											@endif
										</td>
									</tr>
                                @endforeach
									
									
								</tbody>
							</table>
						</div>

					</div>
                    <div class="row">
                        <div class="col-12 text center">
                        {{ $interactionhead_all->Links() }}
                        </div>
                    </div>

				</div>

			</div>

@endsection
