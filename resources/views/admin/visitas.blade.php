@extends('layouts.home')

@section('main')

<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
	<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
	<div class="container pt-lg-5 mt-5">
		<div class="row pt-3 pb-lg-0 pb-xl-0">
			<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
				<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
					<li><a href="{{route('welcome')}}">Inicio</a></li>
					<li class="text-color-primary"><a href="#">Panel de control</a></li>
					
				</ul>
				<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Visitas a la Publicación </h1>
				
				<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
				
				
			</div>

		</div>
	</div>
</section>



<div role="main" class="main" id="ver">

<div class="container pt-3 pb-2">
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
		<div class="col-lg-9">

			
			
			<div class="container">
				<h2>Total de visitas: {{$publicacion->visitas_all->count() }}</h2>
	<section class="card card-admin">
		
		<div class="card-body">
			
			
			<table class="table table-bordered table-striped mb-0" id="datatable-editable">
				<thead>
					<tr>	
						<th>Fecha de visita</th>
					</tr>
				</thead>
				<tbody>
					@foreach($visitas_all as $visita)
						<tr data-item-id="1">
							<td>{{ $visita->created_at->format('d/m/Y H:i:s') }} </td>
						</tr>
					@endforeach
					
				</tbody>
			</table>
			
		</div>
			<div class="form-group row">
				<div class="form-group col-lg-9">
					<a href="{{ route('prof_publicacion', ['hash_user' => $publicacion->user->hash]) }}" class="btn btn-dark btn-modern float-end">Volver a Publicaciones</a>	
				</div>
				
				<div class="form-group col-lg-3">
					
				</div>
			</div>
	</section>
	{{ $visitas_all->Links() }}
</div>
			
			

			
			

		</div>
	</div>

</div>

</div>



					




</div>
@endsection