@extends('layouts.admin')

@section('main')

			<div role="main" class="main">


				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
								<li class="active">Whatsapp al profesional {{$publicacion->user->name }} {{ $publicacion->user->last_name }}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1><a href="{{ url()->previous() }}" > Volver a la publicación </a></h1>
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
										<th>Celular</th>
										<th>Fecha de visita</th>
										<th>Enviar mensaje</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($whatsapp_all as $whatsapp)
									<tr class="gradeX">
                                        <td>{{$publicacion->categoria->name}}</td>
                                        <td>{{$whatsapp->celular}}</td>
										<td> {{ $whatsapp->created_at->format('d/m/Y H:i:s') }} </td>
										<td> <a href=" https://wa.me/549{{ $whatsapp->celular }}?text=Hola!%20Te%20Contacto%20de%20CEFEPERES%20y%20queria%20hacerte%20una%20consulta!" class="btn btn-success"><i class="fa fa-comments"></i></td>
									</tr>
                                @endforeach
									
									
								</tbody>
							</table>
							<a href="{{ url()->previous() }}" class="btn btn-primary" > Volver a la Publicacion</a>
						</div>

					</div>
                    <div class="row">
                        <div class="col-12 text center">
                        {{ $whatsapp_all->Links() }}
                        </div>
                    </div>

				</div>

			</div>

@endsection