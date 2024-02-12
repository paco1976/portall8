@extends('layouts.home')

@section('main')

<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{ asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
	<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
	<div class="container pt-lg-5 mt-5">
		<div class="row pt-3 pb-lg-0 pb-xl-0">
			<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
				<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
					<li><a href="{{route('welcome')}}">Inicio</a></li>
					<li class="text-color-primary"><a href="#">Panel de control</a></li>
					
				</ul>
				<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">PUBLICACIONES DEL PROFESIONAL </h1>
				
				<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
				
				<a href="#" class="btn btn-primary btn-outline btn-outline-thin btn-outline-light-opacity-2 btn-effect-5 font-weight-semi-bold px-4 btn-py-2 text-3 text-color-light text-color-hover-dark ms-2"   data-bs-toggle="modal" data-bs-target="#defaultModal">¿Como Funciona?<i class="icon-info icons ms-1"></i></a>
			</div>

		</div>
	</div>
</section>



<div role="main" class="main" id="ver">

<div class="container pt-3 pb-2">
<h2 class="font-weight-normal line-height-1">Publicaciones de <strong class="font-weight-extra-bold">{{ $user->name }} {{ $user->last_name }}</strong></h2>
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
<div class="row pt-2">
		{{-- <div class="col-lg-3 mt-4 mt-lg-0"> --}}

			{{-- <div class="d-flex justify-content-center mb-4">
				<div class="profile-image-outer-container">
					<div class="profile-image-inner-container bg-color-primary">
						<img src="{{ $user->avatar }}">
						
					</div>
					
				</div>
				
			</div> --}}

			
			
			
			{{-- <aside class="sidebar mt-2" id="sidebar">
				
				
				<ul class="nav nav-list flex-column mb-5">
					<!--
					<li class="nav-item"><a class="nav-link text-3" href="{{ route('prof_perfil', ['hash_user' => $user->hash]) }}">Perfil del profesional</a></li>
					-->
					<li class="nav-item"><a class="nav-link text-3 text-dark active" href="{{ route('prof_publicacion', ['hash_user' => $user->hash]) }}">Publicaciones del profesional</a></li>
					<!--
					<li class="nav-item"><a class="nav-link text-3" href="{{ route('logout') }}"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
							<i class="fas fa-sign-out-alt"></i> {{ __('Salir') }}
						</a></li>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					-->
					
				</ul>
			</aside> --}}

		{{-- </div> --}}
<div class="container">
	<section class="card card-admin">
		
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="mb-3">
						<a href="{{ route('prof_publicacion_new', ['hash_user' => $user->hash] ) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar publicación </a>
						
					</div>
				</div>
			</div>
			@if(!$mispublicaciones)
				<p>Por el momento no tienes publicaciones</p>
			@else
			<table class="table table-bordered table-striped mb-0" id="datatable-editable">
				<thead>
					<tr>			
						<th>Categoría</th>
						<th>Título Relacionado</th>
						<th>Estado</th>
						<th>Rating</th>
						<th>Visibilidad del rating</th>
						<th>Visitas</th>
						<th>Ver</th>
						<th>Editar</th>
						<th>Eliminar</th>

					</tr>
				</thead>
				<tbody>
					@foreach($mispublicaciones as $publicacion)
					<tr data-item-id="1">
						<td>{{$publicacion->categoria->name}}</td>	
						<td>
							{{$publicacion->titulo->name}}
						</td>

					
						<td class="actions text-center">
						@if($publicacion->aprobado)
								<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'publicaciones']) }}" class="btn btn-success"><i class="fas fa-check-circle"></i></a>
						@else
								<a href="{{ route('admin_publicaciones_aprobar_desaprobar', ['publicacion_hash' => $publicacion->hash, 'origen' => 'publicaciones']) }}" class="btn btn-danger"><i class="fas fa-times-circle"></i></a>
						@endif
						</td>
						
						<td class="actions text-center">
							{{$publicacion->rating}}
						</td>
						<td class="actions text-center">
							@if($publicacion->show_rating==0)
								<a href="{{ route('admin_publicaciones_show_rating', ['publicacion_hash' => $publicacion->hash, 'origen' => 'profesionales']) }}" class="btn btn-warning"><i class="fa fa-eye-slash"></i></a>
								@else
								<a href="{{ route('admin_publicaciones_show_rating', ['publicacion_hash' => $publicacion->hash, 'origen' => 'profesionales']) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
							@endif		
						</td>
						<td class="actions text-center">
							@if ($publicacion->cant_visitas < 1 )
								<a href="" class="btn btn-info"> {{$publicacion->cant_visitas}} </a>		
							@else
								<a href="{{ route('admin_visitas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-info"> {{$publicacion->cant_visitas}} </a>
							@endif
						</td>
						<td class="actions text-center">
							<a href="{{ route('admin_publicacion_user', ['publicacion_hash' => $publicacion->hash, 'origen'=>'profesionales' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
						</td>
						<td class="actions text-center">
							<a href="{{ route('prof_publicacion_edit', ['publicacion_hash'=> $publicacion->hash, 'hash_user'=>$user->hash]) }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
						</td>
						<td class="actions text-center">
							<a href="{{ route('admin_publicacion_delete', ['publicacion_hash' => $publicacion->hash, 'origen'=>'profesionales' ]) }}" class="btn btn-danger" onclick="return confirm('Está seguro que quiere borrar la publicación?')" ><i class="far fa-trash-alt"></i></a>
						</td>


							


						
						{{-- <td>
							@if($publicacion->cant_consultas>0)
							<a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-info"><strong>{{$publicacion->cant_consultas}}</strong></a>
							@else
							<a href="#" class="btn btn-primary"><i class="fa fa-read"><strong>NO</strong></i></a>
							@endif
						</td>
						
						
						<td class="actions text-center">
							@if ($publicacion->cant_whatsapp < 1 )
								<a href="" class="btn btn-info"> {{$publicacion->cant_whatsapp}} </a>		
							@else
								<a href="{{ route('admin_whatsapp', ['publicacion_hash' => $publicacion->hash]) }}" class="btn btn-info"> {{$publicacion->cant_whatsapp}} </a>
							@endif
						</td>
						<td class="actions">
							
							<!--
							<button class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
							<button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
							-->
						</td> --}}
					</tr>
					
					@endforeach
					
				</tbody>
			</table>
			@endif
		</div>
			<div class="form-group row">
				<div class="form-group col-lg-9">
					<a href="{{ route('admin_profesionales') }}" class="btn btn-dark btn-modern float-end">Volver a Profesionales</a>	
				</div>
				
				<div class="form-group col-lg-3">
					
				</div>
			</div>
	</section>
</div>
</div>



</div>

</div>



<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="defaultModalLabel">Qué hago?</h4>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p><strong>Cómo creo una publicación</strong><br>
										Clic en <a href="#">Agregar Publicación</a>.<br>
										<strong>Completar los datos: </strong> <br>
										1. Seleccionar categoría.<br>
										2. Describir el servicio que va a ofrecer.<br>
										3. Subir foto de los trabajos realizados.<br>
										4. Subir certificado de estudios (formato PDF).<br>
										</p>
										
						<hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
										<p><em>La publicación no serán visible hasta sea validada por la administración del Portal.</em></p>
									
									
									
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-light" data-bs-dismiss="modal">Entiendo</button>
								</div>
							</div>
						</div>
					</div>




</div>

@endsection

