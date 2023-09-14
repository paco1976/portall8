@extends('layouts.home')

@section('main')

<div role="main" class="main">

	<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
		<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
		<div class="container pt-lg-5 mt-5">
			<div class="row pt-3 pb-lg-0 pb-xl-0">
				<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
					<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
						<li><a href="{{route('welcome')}}">Inicio</a></li>
						<li class="text-color-primary"><a href="#">Panel de control</a></li>
						
					</ul>
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Mensajes del profesional {{$publicacion->user->name }} {{ $publicacion->user->last_name }}</h1>
					
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
					
					
				</div>

			</div>
		</div>
	</section>
	
	
	
	
	
	
<div role="main" class="main" id="ver">

	<div class="container pt-3 pb-2">
<h2 class="font-weight-normal line-height-1">Mensajes de la publicación {{$publicacion->categoria->name}}</h2>

		<div class="row pt-2">
			<div class="col-lg-3 mt-4 mt-lg-0">

				<div class="d-flex justify-content-center mb-4">
					<div class="profile-image-outer-container">
						<div class="profile-image-inner-container bg-color-primary">
							<img src="{{ $publicacion->user->avatar }}">
							
						</div>
						
					</div>
					
				</div>

				
				
				
				<aside class="sidebar mt-2" id="sidebar">
					
					
					<ul class="nav nav-list flex-column mb-5">
						<li class="nav-item"><a class="nav-link text-3 text-dark active" href="{{ route('prof_publicacion', ['hash_user' => $user->hash]) }}">Publicaciones del profesional</a></li>
					</ul>
				</aside>

			</div>
			<div class="col-lg-9">

				   
					
					
					<div class="form-group row pb-4">
					<div class="input-group mb-3">
						<!--
						<input type="text" class="form-control" placeholder="BUSCAR">
						<button class="btn btn-primary" type="button" ><i class="fas fa-search"></i></button>
						-->
					</div>
				</div>
		
					
					
					
					
					
					
		
			

				
				<table class="table table-bordered table-striped mb-0" id="datatable-editable">
					<thead>
						<tr>			
							<th>Contacto</th>
							<th>Asunto</th>
							<th>Mail</th>
							<th>Teléfono</th>
							<th>Fecha</th>
							<th>Mensajes</th>
						</tr>
					</thead>
												
					<tbody>
						@foreach($interactionhead_all as $interactionhead)
						<tr data-item-id="1">
							<td>{{$interactionhead->name}} {{$interactionhead->last_name}}</td>	
							<td>{{$interactionhead->subjet->name}}</td>
							<td>{{$interactionhead->email}}</td>
							<td>{{$interactionhead->mobile}}</td>
                            <td><h6>{{$interactionhead->date}}</h6></td>
							<td class="actions">
									@if($interactionhead->message_not_read > 0)
									<a href="{{ route('admin_mensajes', ['hash'=> $interactionhead->hash]) }}" class="btn btn-danger"><i class="fa fa-comments"></i></a>
									@else
									<a href="{{ route('admin_mensajes', ['hash'=> $interactionhead->hash]) }}" class="btn btn-primary"><i class="fa fa-comments"></i></a>
									@endif
							</td>
						</tr>
						@endforeach
						
						
					</tbody>
				</table>
				<br>
				<div class="col-12 text center">
					{{ $interactionhead_all->Links() }}
				</div>
			</div>

			
					

		</div>

	</div>

</div>


	
</div>
@endsection
