
@extends('layouts.home')

@section('main')
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
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Estadísticas</h1>
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
				</div>
			</div>
		</div>
</section>
<div role="main" class="main">

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div role="main" class="main" id="ver">
					<div class="container pt-3 pb-2">
							<h2 class="font-weight-normal line-height-1">Estadísticas</h2>
							<div class="col-lg-12">
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
							<!-- Visitas recientes -->
							@if($recentView)
							<div class=" col-md-10" id="totalVistas" style="width:99%;" >
								<h3>Visitas más recientes</h3>
								<div style="display:flex; flex-direction:row; overflow: auto; white-space: nowrap; margin-bottom: 50px">
									@foreach($recentView as $rv)
									<div class="col-md-4" style="margin: 5px;">
										<div class="card text-center">
												<div class="card-header" style="background-color:#17a2b8 ; color:white; font-size:18px">
													{{$rv->cat}}
												</div>
											<div class="card-body" >
												<h5 class="card-title">Profesional</h5>
												<a class="card-text" href="{{ route('admin_publicacion_user', ['publicacion_hash' => $rv->hash, 'origen'=>'publicaciones' ]) }}" target="_blank">{{$rv->name}} {{$rv->last_name}}</a>
												<p class="card-text" style="font-size:18px">{{date('d/m/Y H:i:s',strtotime($rv->created_at))}}</p>

											</div>
											
										</div>
									</div>	
									@endforeach
								</div>																	
							</div>
							@endif	
							<!-- Botones Generales Visitas -->
							<div class="col-md-12" style="margin-bottom:5%">
									<h3>Visitas</h3>
									<div class=" container" style="display: flex; justify-content: space-between;">										
										<button onclick="showHide('views')" style="pointer-events: none;border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
												<caption> Vistas del mes</caption>
												<h2 style="margin-bottom: 0px">{{ $viewsMonth }}</h2>
										</button>
										<button onclick="showHide('category_views')"  style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
												<caption>Categoría más visitada</caption>
											<h2 style="margin-bottom: 0px" id="categoryViewsDisplay">
											@if($categoryViews)
												{{ $categoryViews['name'] }} con {{ $categoryViews['view_count'] }} visitas
											@else
												No hay categorías visitadas.
											@endif
										</h2>		
										</button>
										<button onclick="showHide('publicacion_views')" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
											<caption>Publicación más visitada</caption>
											<h2 style="margin-bottom: 0px" id="publicacionesViewsDisplay">
												@if($publicacionesViews)
												{{ $publicacionesViews['name'] }} {{ $publicacionesViews['last_name'] }} </br> con {{ $publicacionesViews['view_count'] }} visitas
												@else
												No hay categorías visitadas.
												@endif
											</h2>
										</button>										
									</div>										
							</div>
						
							<!-- Detalle Vistas por categorias-->
							<div class="col-md-10 info" id="category_views" style="text-aligne:center; display:none;width:99%" >
								<!-- Month Selector for Category Views -->
								<div id="month-year-selector" style="margin-bottom: 20px;">
										  <form id="filterForm" method="GET" action="">
											  <label for="month">Mes:</label>
											  <select id="month" name="month">
												  <option value=""></option>
												  @foreach ($months as $monthValue => $monthName)
													  <option value="{{ $monthValue }}" {{ $month == $monthValue ? 'selected' : '' }}>
														  {{ $monthName }}
													  </option>
												  @endforeach
											  </select>
							  
											  <label for="year">Año:</label>
											  <select id="year" name="year">
												  <option value=""></option>
												  @foreach ($years as $yearValue)
													  <option value="{{ $yearValue }}" {{ $year == $yearValue  ? 'selected' : '' }}>
														  {{ $yearValue }}
													  </option>
												  @endforeach
											  </select>

											  <label for="periodo">Período:</label>
											  <select id="periodo" name="periodo">
												  <option value=""></option>
												  @foreach ($periodos as $periodoKey => $periodoValue)
													<option value="{{ $periodoKey }}" {{ (string) $periodo === (string) $periodoKey ? 'selected' : '' }}>
														{{ $periodoValue }}
													</option>
												@endforeach
											  </select>
							  
											  <button type="submit">Filtrar</button>
											  <button type="button" id="allTimeButton">Deseleccionar</button>
										  </form>
								</div>
								<div id="categoryViewsContainer">
        						@if($allCategoryViews)
            						@include('admin.partials.category_views', ['filteredCategories' => $allCategoryViews])
								@endif
								</div>
							</div>
								
							<div class="col-md-10 info" id="publicacion_views" style="text-aligne:center; display:none;width:99%" >
								<!-- Month Selector -->
								<div id="month-year-selector" style="margin-bottom: 20px;">
										  <form id="filterPublicaciones" method="GET" action="">
											  <label for="month_pub">Mes:</label>
											  <select id="month_pub" name="month">
												  <option value=""></option>
												  @foreach ($months as $monthValue => $monthName)
													  <option value="{{ $monthValue }}" {{ $month == $monthValue ? 'selected' : '' }}>
														  {{ $monthName }}
													  </option>
												  @endforeach
											  </select>
							  
											  <label for="year_pub">Año:</label>
											  <select id="year_pub" name="year">
												  <option value=""></option>
												  @foreach ($years as $yearValue)
													  <option value="{{ $yearValue }}" {{ $year == $yearValue  ? 'selected' : '' }}>
														  {{ $yearValue }}
													  </option>
												  @endforeach
											  </select>
							  
											  <label for="periodo_pub">Período:</label>
											  <select id="periodo_pub" name="periodo">
												  <option value=""></option>
												  @foreach ($periodos as $periodoKey => $periodoValue)
													<option value="{{ $periodoKey }}" {{ (string) $periodo === (string) $periodoKey ? 'selected' : '' }}>
														{{ $periodoValue }}
													</option>
												@endforeach
											  </select>

											  <button type="submit">Filtrar</button>
											  <button type="button" id="allTimeButtonPubs">Deseleccionar</button>
										  </form>
								</div>
								<div id="publicacionViewContainer">
        						@if($allPublicacionesViews)
            						@include('admin.partials.publicacion_views', ['filteredPublicaciones' => $allPublicacionesViews])
								@endif
								</div>
							</div>

							<!--PROFESIONALES-->
							<div class="col-md-12" style="margin-bottom:5%; margin-top:5%">
								<h3>Encuestas</h3>
								<!-- Filters -->
								<div id="month-year-selector-surveys" style="margin-bottom: 20px;">
										  <form id="filterSurveys" method="GET" action="">
											  <label for="month_surveys">Mes:</label>
											  <select id="month_surveys" name="month">
												  <option value=""></option>
												  @foreach ($months as $monthValue => $monthName)
													  <option value="{{ $monthValue }}" {{ $month == $monthValue ? 'selected' : '' }}>
														  {{ $monthName }}
													  </option>
												  @endforeach
											  </select>
							  
											  <label for="year_surveys">Año:</label>
											  <select id="year_surveys" name="year">
												  <option value=""></option>
												  @foreach ($years as $yearValue)
													  <option value="{{ $yearValue }}" {{ $year == $yearValue  ? 'selected' : '' }}>
														  {{ $yearValue }}
													  </option>
												  @endforeach
											  </select>

											  <label for="periodo_surveys">Período:</label>
											  <select id="periodo_surveys" name="periodo">
												  <option value=""></option>
												  @foreach ($periodos as $periodoKey => $periodoValue)
													<option value="{{ $periodoKey }}" {{ (string) $periodo === (string) $periodoKey ? 'selected' : '' }}>
														{{ $periodoValue }}
													</option>
												@endforeach
											  </select>
							  
											  <button type="submit">Filtrar</button>
											  <button type="button" id="allTimeButtonSurveys">Deseleccionar</button>
										  </form>
								</div>
								<div id="surveysContainer">
								@if($allSurveys)
            						@include('admin.partials.survey_statistics')
								@endif
								</div>
								
							
				</div>
			</div>
		</div>
	</div>


</div>
@endsection

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
function showHide(eleme) {
    var allElements = document.getElementsByClassName('info'); 

    for (var i = 0; i < allElements.length; i++) {
        allElements[i].style.display = 'none';
    }

    document.getElementById(eleme).style.display = 'block';
}
</script>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
        function setupSelectListeners(monthSelect, yearSelect, periodSelect) {
        monthSelect.addEventListener('change', function() {
            if (monthSelect.value) {
                periodSelect.value = ''; // Deselect period
            }
        });

        yearSelect.addEventListener('change', function() {
            if (yearSelect.value) {
                periodSelect.value = ''; // Deselect period
            }
        });

        periodSelect.addEventListener('change', function() {
            if (periodSelect.value) {
                monthSelect.value = ''; // Deselect month
                yearSelect.value = ''; // Deselect year
            }
        });
    }

    setupSelectListeners(
        document.getElementById('month'),
        document.getElementById('year'),
        document.getElementById('periodo')
    );

    setupSelectListeners(
        document.getElementById('month_pub'),
        document.getElementById('year_pub'),
        document.getElementById('periodo_pub')
    );

    setupSelectListeners(
        document.getElementById('month_surveys'),
        document.getElementById('year_surveys'),
        document.getElementById('periodo_surveys')
    );
    });

function updateCategoryVisitButton(categoryViews) {
    const displayElement = document.getElementById('categoryViewsDisplay');
    if (categoryViews && categoryViews[0]) {
        displayElement.innerHTML = `${categoryViews[0].nameCat} con ${categoryViews[0].view_count} visitas`;
    } else {
        displayElement.innerHTML = 'No hay categorías visitadas.';
    }
}

function updatePublicacionesViews(views) {
    const displayElement = document.getElementById('publicacionesViewsDisplay');
    if (views && views[0]) {
        displayElement.innerHTML = `${views[0].name} ${views[0].last_name} </br> con ${views[0].view_count} visitas`;
    } else {
        displayElement.innerHTML = 'No hay categorías visitadas.';
    }
}

    $(document).ready(function() {
        $('#filterForm').on('submit', function(event) {
            event.preventDefault(); 

            $.ajax({
                url: $(this).attr('action'), 
                type: 'GET',
                data: $(this).serialize(), 
                success: function(response) {
					console.log(response)
                    $('#categoryViewsContainer').html(response.html);
					updateCategoryVisitButton(response.categoryViews); 
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        });

		$('#allTimeButton').on('click', function() {
            $('#month').val(''); 
            $('#year').val('');  
			$('#periodo').val('');  
            $('#filterForm').submit();
        });

		$('#filterPublicaciones').on('submit', function(event) {
            event.preventDefault(); 

            $.ajax({
                url: $(this).attr('action'), 
                type: 'GET',
                data: $(this).serialize(), 
                success: function(response) {
					console.log(response)
                    $('#publicacionViewContainer').html(response.html_pubs);
					updatePublicacionesViews(response.publicacionesViews); 
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        });

		$('#allTimeButtonPubs').on('click', function() {
            $('#month_pub').val(''); 
            $('#year_pub').val('');  
			$('#periodo_pub').val('');  
            $('#filterPublicaciones').submit();
        });

		$('#filterSurveys').on('submit', function(event) {
            event.preventDefault(); 

            $.ajax({
                url: $(this).attr('action'), 
                type: 'GET',
                data: $(this).serialize(), 
                success: function(response) {
					console.log(response)
                    $('#surveysContainer').html(response.html_surveys);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        });

		$('#allTimeButtonSurveys').on('click', function() {
            $('#month_surveys').val(''); 
            $('#year_surveys').val('');  
			$('#periodo_surveys').val('');  
            $('#filterSurveys').submit();
        });
    });
</script>

