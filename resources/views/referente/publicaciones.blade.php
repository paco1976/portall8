@extends('layouts.referente')

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
								<h1>Publicaciones</h1>
							</div>

						</div>
					</div>
				</section>



				<div class="container">

					<!-- <form id="contactForm" action="#" method="POST">-->
					<form id="contactForm" >
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Buscador</label>
											<input type="text" value="" data-msg-required="Ingresa palabra clave." placeholder="ingrese palabra clave, EJ: Electricista" maxlength="100" class="form-control" name="name" id="name" required>
										</div>

									</div>
								</div>
					</form>

					@if($publicaciones)
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
								<thead>
								
									<tr align="center">
										<th style="text-align:center">Profesional</th>
										<th style="text-align:center">Mail</th>
										<th style="text-align:center">Categoría</th>
										<th style="text-align:center">Titulo</th>
										<th style="text-align:center" colspan="2"> Mensajes <br>totales/no leidos </th>
										
										<th style="text-align:center" colspan="2">Acciones <br> Activado / ver </th>
										
									</tr>
								</thead>
								<tbody>
								@foreach($publicaciones as $publicacion)
									<tr class="gradeX">
										<th>{{$publicacion->user->name}} {{$publicacion->user->last_name}}</th>
										<td>{{$publicacion->user->email}}</td>
										<td>{{$publicacion->categoria->name}}</td>
										<td>{{$publicacion->titulo->name}}</td>

										

										<td style="text-align:center">
										@if($publicacion->cant_consultas>0)
											@if($publicacion->cant_not_read>0)
												<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-danger"><strong>{{$publicacion->cant_not_read}}</strong></a>
											@else
												<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-success"><strong>{{$publicacion->cant_consultas}}</strong></a>
											@endif
										@else
											<a href="" class="btn btn-success">0</a>
										@endif
										</td>
										
										@if($publicacion->cant_not_read)
										<td style="text-align:center">
										<a href="#" class="btn btn-danger" >{{$publicacion->cant_not_read}}</a>
										</td>
										@else
										<td style="text-align:center">
										<a href="" class="btn btn-success">0</a>	
										</td>
										@endif

										@if($publicacion->aprobado==false)
										<td style="text-align:center">
											<a href="" class="btn btn-danger"> NO </a>
										</td>
										@else
										<td style="text-align:center">
											<a href="" class="btn btn-success">SI</a>
										</td>
										@endif

										<td style="text-align:center">
										<a href="{{ route('publicacion_user', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
											
										</td>
										
									</tr>
								@endforeach


								</tbody>
							</table>
						</div>

					</div>
					<div class="row">
                        <div class="col-12 text center">
                        {{ $publicaciones->Links() }}
                        </div>
                    </div>

					@else
					<div class="row">
                        <div class="col-12 text center">
                        No hay publiaciones de profesionales de tu CFP por el momento.
                        </div>
                    </div>
					@endif


				</div>

			</div>

@endsection
