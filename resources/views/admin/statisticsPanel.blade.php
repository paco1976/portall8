@extends( 'layouts.home')

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
					@if(Auth::user()->user_type()->first()->name=='Administrador')
					<h1>Estadisticas</h1>
					<!-- @else
					<h1>Mis estadisticas</h1>
					@endif -->
				</div>

			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@if (Session::has('message'))
				<div class="alert alert-success" style="display:flex; flex-direction:row; justify-content:space-between">
					<p>{{ Session::get('message') }}</p>
					<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if (Session::has('error'))
				<div class="alert alert-danger" style="display:flex; flex-direction:row; justify-content:space-between">
					<p>{{ Session::get('error') }}</p>
					<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
					
				<!-- Botones Visitas -->
				<div class="col-md-12" style="margin-bottom:5%">
				<h3>Visitas</h3>
				<div class="row container" style="display: flex; justify-content: space-between;">
						@if(request('visits'))
						<button onclick="toggleFilter('visits')" id="visitsButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Vistas del mes</caption>
							<h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
						</button>
						@else
						<button onclick="toggleFilter('visits')" id="visitsButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Visitas del mes</caption>
						</button>
						@endif

						@if(request('category_visits'))
						<button onclick="toggleFilter('category_visits')" id="category_visits_btn" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categoria mas visitadas</caption>
							<h2 style="margin-bottom: 0px">{{ $categoryVisits['name']}} con {{$categoryVisits['view_count']}} visitas</h2>		
						</button>
						@else
						<button onclick="toggleFilter('category_visits')" id="category_visits_btn" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categoria mas visitadas</caption>
						</button>
						@endif

						
						<!-- @if(request('category_Profile'))
						<button onclick="toggleFilter('category_Profile')" id="category_ProfileButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categoria con perfiles mas visitados</caption>
							<h2 style="margin-bottom: 0px">{{ $category_Profile['name']}} con {{$category_Profile['view_count']}} visitas</h2>	
						</button>
						@else
						<button onclick="toggleFilter('category_Profile')" id="category_ProfileButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categorias con perfiles mas visitados</caption>
						</button>
						@endif -->

						@if(request('perfilVisitado'))
						<button onclick="toggleFilter('perfilVisitado')" id="perfilVisitadoButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Perfil mas visitado</caption>
							<h2 style="margin-bottom: 0px">{{ $perfilVisitado['name']}} con {{$perfilVisitado['view_count']}} visitas</h2>
						</button>
						@else
						<button onclick="toggleFilter('perfilVisitado')" id="perfilVisitadoButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Perfiles mas visitados</caption>
						</button>
						@endif

					</div>
				
				</div>
				@if(request('category_visits'))
					@if($allCategoryVisits)
					<div class="row col-md-12">
						<h2>Vistas por categorias</h2>
						<table class="table table-bordered table-striped mb-none" id="myTable">
								<thead>
									<tr align="center">
										<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Categoria</a></th>
										<th style="text-align:center">Nombre</th>
									</tr>
								</thead>
								<tbody>
								@foreach($allCategoryVisits as $category)
									<tr class="gradeX">
										<td>{{$category->name}}</td>
										<td>{{$category->view_count}}</td>								
									</tr>
								@endforeach
								</tbody>
							</table>
					</div>
					@endif
				@endif
				@if(request('visits'))
					@if($recentView)
						<div class="row" style="text-aligne:center" class="col-md-12">
							<h2>Visitas mas recientes</h2>
								<table class="table table-bordered table-striped mb-none" id="myTable">
									<thead>
										<tr align="center">
											<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Profesional</a></th>
											<th style="text-align:center">Publicacion</th>
											<th style="text-align:center">Categoria</th>
											<th style="text-align:center">Fecha</th>
										</tr>
									</thead>
									<tbody>
									@foreach($recentView as $rv)
										<tr class="gradeX">
											<td>{{$rv->name}} {{$rv->last_name}}</td>
											<td style="text-align:center">
												<a href="{{ route('admin_publicacion_user', ['publicacion_hash' => $rv->hash, 'origen'=>'publicaciones' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
											</td>		
											<td>{{$rv->cat}}</td>								
											<td>{{$rv->created_at}}</td>								
										</tr>
									@endforeach
									</tbody>
								</table>
						</div>
					@endif
				@endif
	
			
		</div>
	</div>
</div>
@endsection

<script>
	function toggleFilter(filter) {
		const urlParams = new URLSearchParams(window.location.search);

		// If the filter is already active, clear it
		if (urlParams.has(filter)) {
			urlParams.delete(filter);
		} else {
			// Clear all other filters
			urlParams.delete('category_Profile');
			urlParams.delete('category_visits');
			urlParams.delete('visits');
			urlParams.delete('perfilVisitado');

			// Apply the clicked filter
			urlParams.set(filter, 1);
		}

		// Construct the new URL with updated query parameters
		const newUrl = window.location.pathname + '?' + urlParams.toString();
		window.location.href = newUrl;
	}
</script>