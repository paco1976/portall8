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
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">LISTA DE PROFESIONALES</h1>
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
				</div>
			</div>
		</div>
	</section>
		
		
	<div role="main" class="main" id="ver">
		<div class="container pt-3 pb-2">
			<h2 class="font-weight-normal line-height-1">Lista de profesionales</h2>
				<div class="col-lg-12">
					
					<form id="contactForm" action="{{route('admin_profesionales')}}" method="get">
						<div class="form-group row">
							<h4 class="mb-3">BUSCAR</h4>
							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="ingrese el nombre de la persona que busca" maxlength="100"  name="name" required>
								<!--<button class="btn btn-primary" type="button" ><i class="fas fa-search"></i></button> -->
								<input  class="btn btn-primary" type="submit" value="BUSCAR">
							</div>
						</div>
					</form>

					<div class="row">
						<div class="col-sm-6">
							<div class="mb-3">
								<a href="{{ route('register_profesional') }}">
									<button id="addToTable" class="btn btn-primary">Nuevo Usuario<i class="fas fa-plus"></i></button>
								</a>
							</div>
						</div>
					</div>
					<div class="container pt-3 pb-2">
						<div class="row">
							<div class="col-lg-5">
							</div>
							<div class="col-lg-4">
								{{ $user_all->Links() }}
								<!--
								<ul class="pagination">
									<li class="page-item"><a href="#" class="page-link"><i class="fas fa-angle-left"></i></a></li>
									<li class="page-item active"><a href="#" class="page-link">1</a></li>
									<li class="page-item"><a href="#" class="page-link">2</a></li>
									<li class="page-item"><a href="#" class="page-link">3</a></li>
									<li class="page-item"><a href="#" class="page-link"><i class="fas fa-angle-right"></i></a></li>
								</ul>
								-->
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
					@if($user_all->count() > 0)
					<table class="table table-bordered table-striped mb-0" id="datatable-editable">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th class="text-center" colspan="4">Usuario</th>
								<th class="text-center" colspan="2">Publicaciones</th>
							</tr>
							<tr class="text-center">								  
													
								<th>Nombre y Apellido</th>
								<th>DNI</th>
								<th>E-Mail</th>
								<th>Celular</th>
								<th>CFP</th>
								<th class="text-1" >Activado</th><th class="text-1" >Borrar</th><th class="text-1" >Clave</th><th class="text-1"> Editar </th>
								<th class="text-1" >Cantidad</th><th class="text-1" >Mensajes</th>
							</tr>
						</thead>
						<tbody>
							@foreach($user_all as $usr)
							<tr data-item-id="1">
								<td>{{$usr->name}} {{$usr->last_name}}</td>	
								<td>{{$usr->dni}}</td>
								<td>{{$usr->email}}</td>
								<td>
									@if($usr->profile)
										{{$usr->profile->mobile}}
									@endif
								</td>
								<td>
									{{ $usr->cfp_name($usr->cfp_id) }}
								</td>

								
								<td class="actions text-center">
									@if($usr->active == 0)
										<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $usr->hash, 'origen' => 'profesionales' ]) }}" class="btn btn-danger"><i class="fa-sharp fa-solid fa-thumbs-down"></i></a>
									@else
										<a href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $usr->hash, 'origen' => 'profesionales']) }}" class="btn btn-success"><i class="fa-sharp fa-solid fa-thumbs-up"></i></a>
									@endif
								</td>
								<td class="actions text-center">
									<a href="{{ route('admin_user_delete', ['user_hash' => $usr->hash, 'origen' => 'profesionales']) }}" onclick="return confirm('Está seguro que quiere borrar el usuario y toda su informacón?')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></i></a>
								</td>
								<td class="actions text-center">
									<a href="{{ route('pass_prof', ['id_prof' => $usr->id]) }}" class="btn btn-primary"><i class="fa-solid fa-lock"></i></a>
								</td>
								
								<td class="actions text-center">
									<a href="{{ route('prof_perfil_edit', ['hash_user' => $usr->hash])  }}" class="btn btn-info"><i class="fa-solid fa-user"></i></a>
								</td>
								
								<td class="actions text-center">
									@if($usr->cant_publicaciones>0)
										@if($usr->publi_sin_aprobar>0)
										<a href="{{ route('prof_publicacion', ['hash_user' => $usr->hash]) }}" class="btn btn-danger"><strong>{{$usr->cant_publicaciones}}</strong></a>
										@else
										<a href="{{ route('prof_publicacion', ['hash_user' => $usr->hash]) }}" class="btn btn-info"><strong>{{$usr->cant_publicaciones}}</strong></a>
										@endif
									@else
										<a href="{{ route('prof_publicacion', ['hash_user' => $usr->hash]) }}" class="btn btn-danger"><strong>{{$usr->cant_publicaciones}}</strong></a>
									@endif
								</td>
								<td class="actions text-center">
									@if($usr->menssage_total> 0)
										@if($usr->menssage_not_read> 0 )
											<a href="#" class="btn btn-danger"><strong>{{$usr->menssage_total}}</strong></a>
										@else
											<a href="#" class="btn btn-info"><strong>{{$usr->menssage_total}}</strong></a>
										@endif
									@else
										<a href="" class="btn btn-info">0</a>
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
					<p>No se encontraron profesionales</p>
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
				{{ $user_all->Links() }}
				<!--
				<ul class="pagination">
					<li class="page-item"><a href="#" class="page-link"><i class="fas fa-angle-left"></i></a></li>
					<li class="page-item active"><a href="#" class="page-link">1</a></li>
					<li class="page-item"><a href="#" class="page-link">2</a></li>
					<li class="page-item"><a href="#" class="page-link">3</a></li>
					<li class="page-item"><a href="#" class="page-link"><i class="fas fa-angle-right"></i></a></li>
				</ul>
				-->
			</div>
			<div class="col-lg-3">
			</div>
		</div>
	</div>

</div>

@endsection
