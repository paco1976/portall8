
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
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Estadisticas</h1>
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
				</div>
			</div>
		</div>
</section>
	

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div role="main" class="main" id="ver">
					<div class="container pt-3 pb-2">
							<h2 class="font-weight-normal line-height-1">Estadisticas</h2>
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
							<!-- Botones Generales Visitas -->
							<div class="col-md-12" style="margin-bottom:5%">
									<h3>Segun Visitas</h3>
									<div class=" container" style="display: flex; justify-content: space-between;">
										<button  onclick="showHide('totalVistas')" style=" border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										<caption>Total Vistas</caption>
										<h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
										</button>
										<button onclick="showHide('visits')" style="pointer-events: none;border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
												<caption> Vistas del mes</caption>
												<h2 style="margin-bottom: 0px">{{ $visitsMonth }}</h2>
										</button>
										<button onclick="showHide('category_visits')"  style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
												<caption>Categoría más visitada</caption>
												<h2 style="margin-bottom: 0px">{{ $categoryVisits['name']}} con {{$categoryVisits['view_count']}} visitas</h2>		
										</button>
										<button onclick="showHide('perfilVisitado')" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
											<caption>Perfil mas visitado</caption>
											<h2 style="margin-bottom: 0px">{{$perfilVisitado['view_count']}} visitas</h2>
										</button>
									</div>										
							</div>

							<!-- Detalle Vistas por categorias-->
							@if($allCategoryVisits)					

							<div class=" col-md-10 info" id="category_visits" style="text-aligne:center; display:none;width:99%" >
								<h2>Vistas por categorias</h2>
								<div style="display:flex; flex-direction:row; overflow: auto; white-space: nowrap;">
									@foreach($allCategoryVisits as $category)
									<div class="col-md-4" style="margin: 5px;">
											<div class="card text-center">
												<div class="card-header" style="background-color:#17a2b8 ; color:white; font-size:18px" >
												{{ $category['nameCat'] }}
												</div>
												<div class="card-body" style="max-width: 100%; white-space: normal;">
                            						<h5 class="card-title">Profesionales</h5>
                            						<ul class="list-unstyled">
                               						@foreach($category['views_by_professional'] as $professional)
                                    					<li>{{ $professional['name'] }} {{ $professional['last_name'] }}: {{ $professional['views'] }} visitas</li>
                                					@endforeach
                            						</ul>
                        						</div>
												<div class="card-footer text-muted card-title">
												<h5 class="card-title" style="font-size:18px">con {{ $category['view_count'] }} visitas</h5>
												</div>
										</div>
									</div>	
									@endforeach
								</div>																	
							</div>
							@endif
							<!-- Total de Visitas-->
							@if($recentView)
							<div class=" col-md-10 info" id="totalVistas" style="text-aligne:center; display:none;width:99%" >
								<h2>Visitas mas recientes</h2>
								<div style="display:flex; flex-direction:row; overflow: auto; white-space: nowrap;">
									@foreach($recentView as $rv)
									<div class="col-md-4" style="margin: 5px;">
											<div class="card text-center">
												<div class="card-header" style="background-color:#17a2b8 ; color:white; font-size:18px">
													{{$rv->cat}}
												</div>
											<div class="card-body" >
												<h5 class="card-title">Profesional</h5>
												<p class="card-text" >{{$rv->name}} {{$rv->last_name}}</p>
												<p class="card-text" style="font-size:18px">El dia {{date('d/m/Y H:i:s',strtotime($rv->created_at))}}</p>

											</div>
											<div class="card-footer text-muted card-title">
											    Publicacion -> <a class="btn btn-primary" href="{{ route('admin_publicacion_user', ['publicacion_hash' => $rv->hash, 'origen'=>'publicaciones' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
											</div>
										</div>
									</div>	
									@endforeach
								</div>																	
							</div>
							@endif

							<!-- Perfil mas Visitado-->
							@if($perfilVisitado)
							<div class=" col-md-10 info" id="perfilVisitado" style="text-aligne:center; display:none;width:99%" >
							<h2 >Perfil Mas Visitado</h2>
								<div class="col-md-5" style="margin: auto;">
									<div class="card text-center">
											<div class="card-header"  style="background-color:#1c5fa8; color:white; font-size:18px">
											 Con {{$perfilVisitado->view_count}} visitas
											</div>
											<div class="card-body">
												<h5 class="card-title">Profesional</h5>
												<p class="card-text">{{$perfilVisitado->name}} {{$perfilVisitado->last_name}}</p>
											</div>
									</div>
								</div>	
							</div>
							@endif

							<!--PROFESIONALES-->
							<!-- navegacion Principal profesionales -->
							<div class="col-md-12" style="margin-bottom:5%; margin-top:5%">
								<h3>Segun Profesionales</h3>
								<div class=" container" style="display: flex; justify-content: space-between;">
									<button style="pointer-events: none;border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										<caption>Total Encuestados</caption>
										<h2 style="text-aligne:center">{{ $SurveyTotal }}</h2>
									</button>		
									<button onclick="showHide('profesionalMorequalified')"  style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										<caption>Perfil Mejor Calificado</caption>
										<h2 style="margin-bottom: 0px">{{ $profesionalMorequalified['name']}}  {{$profesionalMorequalified['last_name']}} </h2>		
									</button>
									<button onclick="showHide('surveyByProfesional_')" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										<caption>Encuestas Por Profesional</caption>
									</button>
								</div>
								
							</div>
							<!--Detalle perfil mejor calificado-->

							@if($profesionalMorequalified)
							<div class=" col-md-10 info" id="profesionalMorequalified" style="text-aligne:center; display:none;width:99%" >
							<h2 >Perfil Mejor Calificado</h2>
								<div class="col-md-5" style="margin: auto;">
									<div class="card text-center">
											<div class="card-header"  style="background-color:#1c5fa8; color:white; font-size:18px">
											{{$profesionalMorequalified->name}} {{$profesionalMorequalified->last_name}}
											</div>
											<div class="card-header">
											{{$profesionalMorequalified->cat}}
											</div>
											<div class="card-body">
												<h5 class="card-title">Por el cliente</h5>
												<p class="card-text">{{$profesionalMorequalified->client_name}}</p>
												<p class="card-text">Email: {{$profesionalMorequalified->client_email}}</p>
												@for ($i = 0; $i < $profesionalMorequalified->Prom; $i++)
												<i class="fa fa-star" style="color:yellow;"></i>
												@endfor						
											</div>
											<div class="card-footer text-muted card-title">
											   Total encuestas {{$profesionalMorequalified->Survays}}
											</div>
									</div>
								</div>	
							</div>
							@endif			

							@if($SurveyByProfesional)
							<div class=" col-md-10 info" id="surveyByProfesional_" style="text-aligne:center; display:none;width:99%" >
								<h2>Encuestas Por Profesional</h2>
								<div style="display:flex; flex-direction:row; overflow: auto; white-space: nowrap;">
								@foreach($SurveyByProfesional as $surveyByProf)
									<div class="col-md-4" style="margin: 5px;">
											<div class="card text-center">
												<div class="card-header" style="background-color:#1c5fa8; color:white; font-size:18px">
												{{$surveyByProf->name}} {{$surveyByProf->last_name}}
												</div>
											<div class="card-body" >
												<h5 class="card-text">Cliente-> {{$surveyByProf->client_name}}</h5>
												<h5 class="card-text">Email-> {{$surveyByProf->client_email}}</h5>
											</div>
											<div class="card-footer text-muted card-title">
											    Encuestas -> {{$surveyByProf->Survays}}
											</div>
										</div>
									</div>	
									@endforeach
								</div>																	
							</div>
							@endif
				</div>
			</div>
		</div>
	</div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">

// function showHide($eleme){
// 	foreach($elemDocu in document.getElementById()){
// 		document.getElementById().style.display == 'none';
// 		document.getElementById($eleme).style.display = 'block';
// 	}
// } 
function showHide(eleme) {
    var allElements = document.getElementsByClassName('info'); // Replace 'yourClassName' with the actual class name of your elements

    for (var i = 0; i < allElements.length; i++) {
        allElements[i].style.display = 'none';
    }

    document.getElementById(eleme).style.display = 'block';
}
</script>


@endsection

