@extends('layouts.home')

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
					<h1>Publicaciones del profesional {{$user_publicacion->name}} {{$user_publicacion->last_name}}</h1>
					<p> {{$user_publicacion->email}}</p>

				</div>

			</div>
		</div>
	</section>



	<div class="container">

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
		</div>


		<!-- <form id="contactForm" action="#" method="POST">-->
		<form id="contactForm">
			<div class="row">
				<div class="form-group">
					<div class="col-md-12">
						<label>Buscador</label>
						<input type="text" value="" data-msg-required="Ingresa palabra clave." placeholder="ingrese palabra clave, EJ: Electricista" maxlength="100" class="form-control" name="name" id="name" required>
					</div>

				</div>
			</div>
		</form>

		@if($user_publicacion->publicaciones)
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered table-striped mb-none" id="datatable-editable">
					<thead>

						<tr align="center">

							<th style="text-align:center; vertical-align: middle;" rowspan="2">Categoría</th>
							<th style="text-align:center; vertical-align: middle;" rowspan="2">Titulo</th>
							<th style="text-align:center; vertical-align: middle;" colspan="2"> Mensajes</th>
							<th style="text-align:center; vertical-align: middle;" colspan="3">Encuestas</th>
							<th style="text-align:center; vertical-align: middle;" colspan="2">Rating</th>
							<!-- <th style="text-align:center; vertical-align: middle;" colspan="2">Palabras</th> -->
							<th style="text-align:center; vertical-align: middle;" colspan="4">Publicaciones</th>

						</tr>
						<tr align="center">
							<!-- Subheaders de Mensajes -->
							<th style="text-align:center; vertical-align: middle;">Totales</th>
							<th style="text-align:center; vertical-align: middle;">No leidos</th>

							<!-- Subheaders de Encuestas -->
							<th style="text-align:center; vertical-align: middle;">Respondidas</th>
							<th style="text-align:center; vertical-align: middle;">Enviadas</th>
							<th style="text-align:center; vertical-align: middle;">Registradas</th>
							
							<!-- Subheaders de Rating -->
							<th style="text-align:center; vertical-align: middle;">Promedio</th>
							<th style="text-align:center; vertical-align: middle;">Mostrar/ocultar</th>
							
							<!-- Subheaders de Palabras -->
							<!-- <th style="text-align:center; vertical-align: middle;">3 más usadas</th>
							<th style="text-align:center; vertical-align: middle;">Mostrar/ocultar</th> -->

							<!-- Subheaders de Publicaciones -->
							<th style="text-align:center; vertical-align: middle;">Activado</th>
							<th style="text-align:center; vertical-align: middle;">Ver</th>
							<th style="text-align:center; vertical-align: middle;">Editar</th>
							<th style="text-align:center; vertical-align: middle;">Borrar</th>
						</tr>
					</thead>
					<tbody>
						@foreach($user_publicacion->publicaciones as $publicacion)
						<tr class="gradeX">

							<td>{{$publicacion->categoria->name}}</td>
							<td>{{$publicacion->titulo->name}}</td>

							<td style="text-align:center">
								@if($publicacion->cant_consultas>0)
								@if($publicacion->menssage_not_read>0)
								<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-danger"><strong>{{$publicacion->menssage_not_read}}</strong></a>
								@else
								<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-success"><strong>{{$publicacion->menssage_total}}</strong></a>
								@endif
								@else
								<a href="" class="btn btn-success">0</a>
								@endif
							</td>

							@if($publicacion->menssage_not_read)
							<td style="text-align:center">
								<a href="#" class="btn btn-danger">{{$publicacion->menssage_not_read}}</a>
							</td>
							@else
							<td style="text-align:center">
								<a href="" class="btn btn-success">0</a>
							</td>
							@endif

							<td style="text-align:center">
								@if($publicacion->surveys_accepted>0)
								<a href="{{ route('admin_surveys', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-success"><strong>{{$publicacion->surveys_accepted}}</strong></a>
								@else
								<a href="" class="btn btn-success">0</a>
								@endif
							</td>
							<td style="text-align:center">
								{{$publicacion->surveys_sent}}
							</td>
							<td style="text-align:center">
								{{$publicacion->clients_registered}}
							</td>

							<td style="text-align:center">
								{{$publicacion->rating}}
							</td>
							@if($publicacion->show_rating==0)
							<td style="text-align:center">
								<a href="{{ route('admin_publicaciones_show_rating', ['publicacion_hash' => $publicacion->hash, 'origen' => 'profesionales']) }}" class="btn btn-warning"><i class="fa fa-eye-slash"></i></a>
							</td>
							@else
							<td style="text-align:center">
								<a href="{{ route('admin_publicaciones_show_rating', ['publicacion_hash' => $publicacion->hash, 'origen' => 'profesionales']) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
							</td>
							@endif							

							@if($publicacion->aprobado==0)
							<td style="text-align:center">
								<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'profesionales']) }}" class="btn btn-danger"> NO </a>
							</td>
							@else
							<td style="text-align:center">
								<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'profesionales']) }}" class="btn btn-success">SI</a>
							</td>
							@endif

							<td style="text-align:center">
								@if($user_publicacion->cant_publicaciones)
								<a href="{{ route('admin_publicacion_user', ['publicacion_hash' => $publicacion->hash, 'origen'=>'profesionales' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
								@else
								<a href="#" class="btn btn-warning"><i class="fa fa-eye"></i></a></a>
								@endif
							</td>
							<td>
								<a href="{{ route('prof_publicacion_edit', ['publicacion_hash'=> $publicacion->hash, 'hash_user'=> $user->hash]) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
							</td>
							<td style="text-align:center">
								<a href="{{ route('admin_publicacion_delete', ['publicacion_hash' => $publicacion->hash, 'origen'=>'profesionales' ]) }}" onclick="return confirm('Está seguro que quiere borrar la publicación?')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></a>
							</td>

						</tr>
						@endforeach


					</tbody>
				</table>
				<a href="{{ route('admin_profesionales') }}" class="btn btn-primary"> Volver</a>
			</div>
		</div>

		<div class="row">
			<div class="col-12 text center">
				{{ $user_publicacion->publicaciones->Links() }}
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