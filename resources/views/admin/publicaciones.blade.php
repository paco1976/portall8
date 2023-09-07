@extends('layouts.home')

@section('main')

<div role="main" class="main">

	<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
		<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;">
		</div>
		<div class="container pt-lg-5 mt-5">
			<div class="row pt-3 pb-lg-0 pb-xl-0">
				<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
					<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
						<li><a href="{{route('welcome')}}">Inicio</a></li>
						<li class="text-color-primary"><a href="#">Panel de control</a></li>
					</ul>
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">LISTA DE PUBLICACIONES</h1>
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
				</div>
			</div>
		</div>
	</section>
		
		
	<div role="main" class="main" id="ver">
		<div class="container pt-3 pb-2">
			<h2 class="font-weight-normal line-height-1">Lista de Publicaciones</h2>
				<div class="col-lg-12">
					
					<form id="contactForm" action="{{route('admin_publicaciones')}}" method="get">
						<div class="form-group row">
							<h4 class="mb-3">BUSCAR</h4>
							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="ingrese palabra clave, EJ: Electricista" maxlength="100"  name="name" required>
								<!--<button class="btn btn-primary" type="button" ><i class="fas fa-search"></i></button> -->
								<input  class="btn btn-primary" type="submit" value="BUSCAR">
							</div>
						</div>
					</form>

					
					<div class="container pt-3 pb-2">
						<div class="row">
							<div class="col-lg-5">
							</div>
							<div class="col-lg-4">
								{{ $publicaciones->Links() }}
							</div>
							<div class="col-lg-3">
							</div>
						</div>
					</div>
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
					
					@if($publicaciones)
					<table class="table table-bordered table-striped mb-0" id="datatable-editable">
						<thead>
							<tr>
								
								<th class="text-center" colspan="4">Usuario</th>
								<th class="text-center" colspan="9">Publicaciones</th>
							</tr>
							<tr class="text-center">								  
								<!-- usuario -->	
								<th>Nombre y Apellido</th>
								<th class="text-1" >CFP</th>
								<th class="text-1" >Activo</th>
								<th class="text-1" >Borrar</th>
								
								
								<!-- publicaciones -->
								<th class="text-1"> Categoría</th>
								<th class="text-1"> Titulo</th>
								<th class="text-1"> Mensajes </th>
								<th class="text-1"> Visitas </th>
								<th class="text-1"> Whatsapp </th>
								<th class="text-1"> Activado </th>
								<th class="text-1"> Editar </th>
								<th class="text-1"> Ver </th>
								<th class="text-1"> Borrar </th>
							</tr>
						</thead>
						<tbody>
							@foreach($publicaciones as $publicacion)
							<tr data-item-id="1">
								<td>{{$publicacion->user->name}} {{$publicacion->user->last_name}}</td>
								<td>{{$publicacion->cfp->name}}</td>
								<td>
									@if($publicacion->user->active == 0)
										<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $publicacion->user->hash, 'origen' => 'publicaciones']) }}" style="text-align:center" class="btn btn-danger">NO</a>
									@else
										<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $publicacion->user->hash, 'origen' => 'publicaciones']) }}" style="text-align:center" class="btn btn-success">SI</a>
									@endif
								</td>
								<td>
									<a href="{{ route('admin_user_delete', ['user_hash' => $publicacion->user->hash, 'origen' => 'publicaciones']) }}" onclick="return confirm('Está seguro que quiere borrar el usuario y toda su informacón?')" style="text-align:center" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								</td>

								<!-- publicacion -->
								<td>{{$publicacion->categoria->name}}</td>
								<td>{{$publicacion->titulo->name}}</td>
								<td>
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
								<td>
									@if ($publicacion->cant_visitas < 1 )
										<a href="" class="btn btn-primary"> {{$publicacion->cant_visitas}} </a>		
									@else
										<a href="{{ route('admin_visitas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-primary"> {{$publicacion->cant_visitas}} </a>
									@endif
								</td>
								<td>
									@if ($publicacion->cant_whatsapp < 1 )
										<a href="" class="btn btn-primary"> {{$publicacion->cant_whatsapp}} </a>		
									@else
										<a href="{{ route('admin_whatsapp', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-primary"> {{$publicacion->cant_whatsapp}} </a>
									@endif
								</td>
								<td>
								@if($publicacion->aprobado)
									<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'publicaciones']) }}" class="btn btn-success">SI</a>
								@else
									<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'publicaciones']) }}" class="btn btn-danger"> NO </a>
								@endif
								</td>
								<td>
									<a href="{{ route('prof_publicacion_edit', ['publicacion_hash'=> $publicacion->hash, 'hash_user'=>$user->hash]) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
								</td>
								<td>
									<a href="{{ route('admin_publicacion_user', ['publicacion_hash' => $publicacion->hash, 'origen'=>'publicaciones' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
								</td>
								<td>
									<a href="{{ route('admin_publicacion_delete', ['publicacion_hash' => $publicacion->hash, 'origen'=>'publicaciones' ]) }}" onclick="return confirm('Está seguro que quiere borrar la publicación?')"  class="btn btn-danger"><i class="fa fa-trash-o"></i></a></a>
								</td>
								
								
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
					<p>No se encontraron publicaciones</p>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="container pt-3 pb-2">
		<div class="row">
			<div class="col-lg-5">
			</div>
			<div class="col-lg-4">
				{{ $publicaciones->Links() }}
			</div>
			<div class="col-lg-3">
			</div>
		</div>
	</div>

</div>
@endsection
