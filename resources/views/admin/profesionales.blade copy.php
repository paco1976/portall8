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
								<h1>Profesionales</h1>
							</div>

						</div>
					</div>
				</section>



					<div class="container">

					<form id="contactForm" action="{{route('admin_profesionales')}}" method="get">
						<div class="row">
							<div class="form-group">
								<div class="col-md-12">
									<label>Buscador</label>
									<input type="text" placeholder="ingrese el nombre de la persona que busca" maxlength="100" class="form-control" name="name" id="name" required>
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
						<div class="col-sm-6">
							<div class="mb-md">
							
								<a href="{{ route('register_profesional') }}">
									<button id="addToTable" class="btn btn-primary">Nuevo Profesional </button>
								</a>
							</div>
						</div>
					</div>
					
					<br>

					@if($user_all->count() > 0)
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="myTable">
								<thead>
								
									<tr>
										<th style="text-align:center" onclick="sortTable(0, 'str')"><a class="link" href="#">Nombre y Apellido</a></th>
										<th style="text-align:center">DNI</th>
										<th style="text-align:center">E-Mail</th>
										<th style="text-align:center">Celular</th>
										<th style="text-align:center">CFP</th>
										<th style="text-align:center" colspan="3">Usuario<br>Activado / Borrar / Clave</th>
										<th style="text-align:center">Perfil</th>
										<th style="text-align:center" colspan="2">Publicaciones <br> Cantidad / Mensajes </th>
									</tr>
								</thead>
								<tbody>
								@foreach($user_all as $usr)
									<tr class="gradeX">
										<th>{{$usr->name}} {{$usr->last_name}}</th>
										<td style="text-align:center">{{$usr->dni}}</td>
										<td>{{$usr->email}}</td>

										<td style="text-align:center">
										@if($usr->profile)
										{{$usr->profile->mobile}}
										@endif
										</td>
										<td style="text-align:center">
											{{ $usr->cfp_name($usr->cfp_id) }}
										</td>
										
										<td style="text-align:center">
										@if($usr->active == 0)
											<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $usr->hash, 'origen' => 'profesionales' ]) }}" style="text-align:center" class="btn btn-danger">NO</a>
										@else
											<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $usr->hash, 'origen' => 'profesionales']) }}" style="text-align:center" class="btn btn-success">SI</a>
										@endif
										</td>

										<td style="text-align:center">
											<a href="{{ route('admin_user_delete', ['user_hash' => $usr->hash, 'origen' => 'profesionales']) }}" onclick="return confirm('Está seguro que quiere borrar el usuario y toda su informacón?')" style="text-align:center" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
										</td>

										<td style="text-align:center">
											<a href="{{ route('pass_prof', ['id_prof' => $usr->id]) }}" style="text-align:center" class="btn btn-success"><i class="fa fa-edit"></i></a>
										</td>

										<td style="text-align:center">
											<a href="{{ route('prof_perfil', ['hash_user' => $usr->hash]) }}" style="text-align:center" class="btn btn-success"><i class="fa fa-edit"></i></a>
										</td>
										
										<td style="text-align:center">
										@if($usr->cant_publicaciones>0)
											@if($usr->publi_sin_aprobar>0)
											<a href="{{ route('admin_publicaciones_user', ['user_hash' => $usr->hash]) }}" class="btn btn-danger"><strong>{{$usr->cant_publicaciones}}</strong></a>
											@else
											<a href="{{ route('admin_publicaciones_user', ['user_hash' => $usr->hash]) }}" class="btn btn-success"><strong>{{$usr->cant_publicaciones}}</strong></a>
											@endif
										@else
											<a href="#" class="btn btn-info">0</a>
										@endif
										</td>
										<!--
										<td style="text-align:center">
										@if($usr->menssage_not_read> 0 && $usr->menssage_total> 0 )
										<a href="#" class="btn btn-danger" >{{$usr->menssage_total}}</a>
										@elseif($usr->menssage_not_read == 0 && $usr->menssage_total > 0 )
										<a href="#" class="btn btn-info">{{$usr->menssage_total}}</a>
										@else
										<a href="#" class="btn btn-info">0</a>
										@endif
										</td>
										-->
										<td style="text-align:center">
										@if($usr->menssage_total> 0)
											@if($usr->menssage_not_read> 0 )
												<a href="#" class="btn btn-danger"><strong>{{$usr->menssage_total}}</strong></a>
											@else
												<a href="#" class="btn btn-success"><strong>{{$usr->menssage_total}}</strong></a>
											@endif
										@else
											<a href="" class="btn btn-success">0</a>
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
                        {{ $user_all->Links() }}
                        </div>
                    </div>
					@else
					<div class="row">
                        <div class="col-12 text center">
                        No hay profesionales dados de alta en su CFP.
                        </div>
                    </div>

					@endif
				</div>

			</div>

@endsection
