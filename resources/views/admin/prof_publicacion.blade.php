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
								<h1>Publicaciones de {{ $user->name }} {{ $user->last_name }}</h1>
							</div>
						</div>
					</div>
				</section>




				<div class="container">





					<div class="row">
						<div class="col-md-9">
							<div class="tabs">
								<ul class="nav nav-tabs">
									<li>
										<a href="{{ route('prof_perfil', ['hash_user' => $user->hash]) }} " ><i class="fa fa-user"></i> Perfil</a>
									</li>
									<li class="active">
									<!-- "{{ route('publicacion', ['id'=> $user->id]) }}" -->
										<a href="{{ route('prof_publicacion', ['hash_user' => $user->hash])  }}"><i class="fa fa-file-powerpoint-o"></i> Publicaciones</a>
									</li>


								</ul>
								<div class="tab-content">

									<div id="publicacion" class="tab-pane active">


							<div class="row">
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
								<div class="col-sm-6">
									<div class="mb-md">
									
										<a href="{{ route('prof_publicacion_new', ['hash_user' => $user->hash] ) }}">
										    <button id="addToTable" class="btn btn-primary">Agregar Publicación </button>
                                        </a>
                                    </div>
								</div>
							</div>
							<div class="table-responsive">
							<br>
							
							<!--Acá va el ir para chequear las publicaciones -->
							@if(!$mispublicaciones)
								<p>Por el momento no tienes publicaciones</p>
							@else
								<table class="table table-bordered table-striped mb-none" id="datatable-editable">
									<thead>

										<tr aliegn="center">
											<th>Título Relacionado</th>
											<th>Categoría</th>
											<th>Visitas</th>
											<th>Aprobado</th>
											<th>Consultas</th>
											<th style="text-align:center"  colspan="3">Acción <br> Editar / Ver / Borrar </th>
											
										</tr>
									</thead>
									<tbody>
										@foreach($mispublicaciones as $publicacion)
										<tr class="gradeX">
											<td>
												{{$publicacion->titulo->name}}
											</td>
											<td>{{$publicacion->categoria->name}}</td>
											<td>{{$publicacion->view}}</td>
											<td>
											@if($publicacion->aprobado==0)
												<strong>Pendiente</strong>
											@else
												<strong>Aprobado</strong>
											@endif
											</td>
											<td>
											@if($publicacion->cant_consultas>0)
												<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-primary"><strong>{{$publicacion->cant_consultas}} - Ver</strong></a>
											@else
												<a href="#" class="btn btn-primary"><i class="fa fa-read"><strong>ninguna</strong></i></a>
											@endif
											</td>
									
											<td>
												<a href="{{ route('prof_publicacion_edit', ['publicacion_hash'=> $publicacion->hash, 'hash_user'=>$user->hash]) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
											</td>
											
											<td>
												<a href="{{ route('admin_publicacion_user', ['publicacion_hash' => $publicacion->hash, 'origen'=>'profesionales' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
											</td>

											<td>
												<a href="{{ route('admin_publicacion_delete', ['publicacion_hash' => $publicacion->hash, 'origen'=>'profesionales' ]) }}" onclick="return confirm('Está seguro que quiere borrar la publicación?')"  class="btn btn-danger"><i class="fa fa-trash-o"></i></a></a>
											<!--<a href="#" class="on-default remove-row"><i class="fa fa-trash-o">Delete </i></a>-->
											</td>
											
										</tr>
										@endforeach
											
											
									</tbody>
								</table>
							@endif
							
						</div>
						</div>


								</div>
							</div>
						</div>


						<div class="col-md-3">
						<button class="btn btn-info btn-small " data-toggle="modal" data-target="#myModal">
								<i class="fa fa-question-circle"></i> ¿Como funciona?
							</button>

							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">Qué hago?</h4>
										</div>
										<div class="modal-body">

											<h4 class="panel-title">
												<strong>Cómo cambio mis datos?</strong>
										</h4>
											<div class="panel-body">
										  Entra en <a href="#">Modificar los detalles</a> y actualizá tu perfil. </div>


											<h4 class="panel-title">
												<strong>Cómo creo mis publicaciones?</strong>
										</h4>

											<div class="panel-body">
										  1. Agregá los cursos que hiciste en el CFP clickeando en el menú Títulos.<br>
2. Una vez que hayas cargado tus tíulos, ya podés crear tus publicaciones clickeando en el menú Publicaciones. </div>





                                        <div class="alert alert-info">
								<strong>Las publicaciones no serán publicadas hasta que los títulos que cargaste sean validados por la administración del CFP.</strong>
							</div>


										</div>





										<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>

										</div>
									</div>
								</div>
							</div>


						</div>





					</div>






				</div>

			</div>

@endsection

