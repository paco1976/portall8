
@extends( 'layouts.home')

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
								<div class="col-md-12" style="margin-bottom:5%">
									<h3>Visitas</h3>
									<!-- Botones Visitas -->
									<div class=" container" style="display: flex; justify-content: space-between;">
										<button onclick="showHide('totalVistas')" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										  <caption>Total Vistas</caption>
										  <h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
										</button>
										<button onclick="showHide('visits')" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
												<caption> Vistas del mes</caption>
												<h2 style="margin-bottom: 0px">{{ $visitsMonth }}</h2>
										</button>
										<button onclick="showHide('category_visits')"  style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
												<caption>Categoria mas visitadas</caption>
												<h2 style="margin-bottom: 0px">{{ $categoryVisits['name']}} con {{$categoryVisits['view_count']}} visitas</h2>		
										</button>
										<button onclick="showHide('perfilVisitado')" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
											<caption>Perfil mas visitado</caption>
											<h2 style="margin-bottom: 0px">{{$perfilVisitado['view_count']}} visitas</h2>
										</button>
									</div>										
								</div>


								<!-- Detalle info-->
									<div class="row col-md-12 info" id="category_visits" style="text-aligne:center; display:none" >
										@if($allCategoryVisits)
										<h2>Vistas por categorias</h2>
										<table class="table table-bordered table-striped mb-none" id="myTable">
											<thead>
											<tr align="center">
												<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Categoria</a></th>
												<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Profesional</a></th>
												<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Visitas</a></th>
											</tr>
											</thead>
											<tbody>
												@foreach($allCategoryVisits as $category)
													<tr class="gradeX" align="center">
														<td>{{$category->name}}</td>
														<td>{{$category->user}} {{$category->last_name}}</td>		
														<td>{{$category->view_count}}</td>														
													</tr>
												@endforeach
											</tbody>
										</table>
										@endif
									</div>
									<div id="totalVistas" class="row info" style="text-aligne:center; display:none" class="col-md-12">
									  @if($recentView) 
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
																<tr class="gradeX" align="center">
																	<td>{{$rv->name}} {{$rv->last_name}}</td>
																	<td style="text-align:center">
																		<a href="{{ route('admin_publicacion_user', ['publicacion_hash' => $rv->hash, 'origen'=>'publicaciones' ]) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></a>
																	</td>		
																	<td>{{$rv->cat}}</td>								
																	<td> {{ date('d/m/Y H:i:s', strtotime($rv->created_at)) }} </td>								
																</tr>
															@endforeach
															</tbody>
														</table>
									  @endif
									</div>
									<div class="row col-md-12 info" id="perfilVisitado" style="text-aligne:center; display:none" >
									@if($perfilVisitado) 
										<h2>Perfil Mas Visitado</h2>
										<table class="table table-bordered table-striped mb-none" id="myTable">
											<thead>
												<tr align="center">
													<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Profesional</a></th>
													<th style="text-align:center" onclick="sortTable(0, 'str')" ><a class="link" href="#">Visitas</a></th>
												</tr>
											</thead>
											<tbody>
												<tr class="gradeX" align="center">
													<td>{{$perfilVisitado->name}} {{$perfilVisitado->last_name}}</td>
													<td>{{$perfilVisitado->view_count}}</td>														
												</tr>
											</tbody>
										</table>
										@endif
									</div>
									<!--PROFESIONALES-->
									<!-- Botones Visitas -->
									<div class="col-md-12" style="margin-bottom:5%; margin-top:5%">
										<h3>PROFESIONALES</h3>
										<div class=" container" style="display: flex; justify-content: space-between;">
												<div style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
													<caption>Total Vistas</caption>
													<h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
												</div>
												<div style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
													<caption>Total Vistas</caption>
													<h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
												</div>
												<div style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
													<caption>Total Vistas</caption>
													<h2 style="margin-bottom: 0px">{{ $visitsCount }}</h2>
												</div>
										</div>
										
									</div>
								</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

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

