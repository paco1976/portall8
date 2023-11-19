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
				<div class="container" style="margin-top: 20px">
					<h4>Visitas</h4>
					<div class="row" style="display: flex; justify-content: space-between">
						@if(request('visits'))
						<button onclick="toggleFilter('visits')" id="visitsButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Vistas del mes</caption>
							<h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
						</button>
						@else
						<button onclick="toggleFilter('visits')" id="mustPickUpTodayButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Visitas del mes</caption>
							<h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
						</button>
						@endif

						@if(request('expiring_today'))
						<button onclick="toggleFilter('expiring_today')" id="expiringTodayButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categoria mas visitada</caption>
							<h2 style="margin-bottom: 0px">{{ $expiringTodayCount }}</h2>	
						</button>
						@else
						<button onclick="toggleFilter('expiring_today')" id="expiringTodayButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categoria mas visitada</caption>
							<h2 style="margin-bottom: 0px">{{ $expiringTodayCount }}</h2>	
						</button>
						@endif

						@if(request('expired'))
						<button onclick="toggleFilter('expired')" id="expiredButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categoria mas visitadas con perfiles</caption>
							<h2 style="margin-bottom: 0px">{{ $expiredCount }}</h2>		
						</button>
						@else
						<button onclick="toggleFilter('expired')" id="expiredButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Categoria mas visitadas con perfiles</caption>
							<h2 style="margin-bottom: 0px">{{ $expiredCount }}</h2>
						</button>
						@endif

						@if(request('pending'))
						<button onclick="toggleFilter('pending')" id="pendingButton" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Perfiles mas visitados</caption>
							<h2 style="margin-bottom: 0px">{{ $pendingApproval }}</h2>
						</button>
						@else
						<button onclick="toggleFilter('pending')" id="pendingButton" style="border: none; background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
							<caption>Perfiles mas visitados</caption>
							<h2 style="margin-bottom: 0px">{{ $pendingApproval }}</h2>
						</button>
						@endif

					</div>
				</div>
		
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
			urlParams.delete('expiring_today');
			urlParams.delete('expired');
			urlParams.delete('visits');
			urlParams.delete('pending');

			// Apply the clicked filter
			urlParams.set(filter, 1);
		}

		// Construct the new URL with updated query parameters
		const newUrl = window.location.pathname + '?' + urlParams.toString();
		window.location.href = newUrl;
	}
</script>