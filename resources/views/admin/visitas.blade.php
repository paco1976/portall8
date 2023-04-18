@extends('layouts.admin')

@section('main')

			<div role="main" class="main">


				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
								<li class="active">Visitas al profesional {{$publicacion->user->name }} {{ $publicacion->user->last_name }}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1><a href="{{ route('admin_publicaciones') }}" > Volver a PUBLICACIONES</a></h1>
							</div>

						</div>
					</div>
				</section>



					<div class="container">
                    <!--
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
                -->

					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
								<thead>

									<tr>
										
                                        <th>Publicacion</th>
										<th>Profesional</th>
										<th>Fecha de visita</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($visitas_all as $visita)
									<tr class="gradeX">
                                        <td>{{$publicacion->categoria->name}}</td>
                                        <td>{{$publicacion->user->name}} {{$publicacion->user->last_name}}</td>
										<td> {{ $visita->created_at->format('d/m/Y H:i:s') }} </td>
									</tr>
                                @endforeach
									
									
								</tbody>
							</table>
							<a href="{{ route('admin_publicaciones') }}" class="btn btn-primary" > Volver a PUBLICACIONES</a>
						</div>

					</div>
                    <div class="row">
                        <div class="col-12 text center">
                        {{ $visitas_all->Links() }}
                        </div>
                    </div>

				</div>

			</div>

@endsection