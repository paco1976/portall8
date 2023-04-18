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
								<h1>Publicaciones</h1>
							</div>

						</div>
					</div>
				</section>



				<div class="container">

					<!-- <form id="contactForm" action="#" method="POST">-->
					<form id="contactForm" action="{{route('admin_publicaciones')}}" method="get">
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Buscador</label>
											<input type="text" value="" data-msg-required="Ingresa palabra clave." placeholder="ingrese palabra clave, EJ: Electricista" maxlength="100" class="form-control" name="name" id="name" required>
										</div>

									</div>
								</div>
					</form>

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

					@if($publicaciones)
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="myTable">
								<thead>
								
									<tr align="center">
										<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Nombre y Apellido</a></th>
										<!--<th style="text-align:center">Mail</th>-->
										<th style="text-align:center">CFP</th>
										<th style="text-align:center">Categoría</th>
										<th style="text-align:center">Titulo</th>
										<th style="text-align:center" colspan="2" >Usuario<br>Activo / Borrar </th>
										<th style="text-align:center">Mensajes</th>
										<th style="text-align:center">Visitas</th>
										<th style="text-align:center">Whatsapp</th>
										<th style="text-align:center" colspan="4">Publicaciones <br> Activado / Editar / Ver / Borrar</th>
										
									</tr>
								</thead>
								<tbody>
								@foreach($publicaciones as $publicacion)
									<tr class="gradeX">
										<td>{{$publicacion->user->name}} {{$publicacion->user->last_name}}</td>
										<!-- <td>{{$publicacion->user->email}}</td> -->
										<td>{{$publicacion->cfp->name}}</td>
										<td>{{$publicacion->categoria->name}}</td>
										<td>{{$publicacion->titulo->name}}</td>

										<td style="text-align:center">
											@if($publicacion->user->active == 0)
												<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $publicacion->user->hash, 'origen' => 'publicaciones']) }}" style="text-align:center" class="btn btn-danger">NO</a>
											@else
												<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $publicacion->user->hash, 'origen' => 'publicaciones']) }}" style="text-align:center" class="btn btn-success">SI</a>
											@endif
										</td>
										
										<td style="text-align:center">
											<a href="{{ route('admin_user_delete', ['user_hash' => $publicacion->user->hash, 'origen' => 'publicaciones']) }}" onclick="return confirm('Está seguro que quiere borrar el usuario y toda su informacón?')" style="text-align:center" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
										</td>
										

										<td style="text-align:center">
										@if($publicacion->cant_consultas>0)
											@if($publicacion->menssage_not_read>0)
												<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-danger"><strong>{{$publicacion->cant_consultas}}</strong></a>
											@else
												<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-success"><strong>{{$publicacion->cant_consultas}}</strong></a>
											@endif
										@else
											<a href="" class="btn btn-success">0</a>
										@endif
										</td>

										<td style="text-align:center">
											@if ($publicacion->cant_visitas < 1 )
												<a href="" class="btn btn-primary"> {{$publicacion->cant_visitas}} </a>		
											@else
												<a href="{{ route('admin_visitas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-primary"> {{$publicacion->cant_visitas}} </a>
											@endif
										</td>

										<td style="text-align:center">
											@if ($publicacion->cant_visitas < 1 )
												<a href="" class="btn btn-primary"> {{$publicacion->cant_whatsapp}} </a>		
											@else
												<a href="{{ route('admin_whatsapp', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-primary"> {{$publicacion->cant_whatsapp}} </a>
											@endif
										</td>

										@if($publicacion->aprobado)
										<td style="text-align:center">
											<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'publicaciones']) }}" class="btn btn-success">SI</a>
										</td>
										@else
										<td style="text-align:center">
											<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'publicaciones']) }}" class="btn btn-danger"> NO </a>
										</td>
										@endif

										<td style="text-align:center">
											<a href="{{ route('prof_publicacion_edit', ['publicacion_hash'=> $publicacion->hash, 'hash_user'=>$user->hash]) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
										</td>

										<td style="text-align:center">
											<a href="{{ route('admin_publicacion_user', ['publicacion_hash' => $publicacion->hash, 'origen'=>'publicaciones' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
										</td>
										<td style="text-align:center">
											<a href="{{ route('admin_publicacion_delete', ['publicacion_hash' => $publicacion->hash, 'origen'=>'publicaciones' ]) }}" onclick="return confirm('Está seguro que quiere borrar la publicación?')"  class="btn btn-danger"><i class="fa fa-trash-o"></i></a></a>
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
