@extends('layouts.home')

@section('main')

			<div role="main" class="main">

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
									<li><a href="{{ route('admin_publicaciones_user', ['user_hash' => $publicacion->user->hash]) }}">Publicaciones</a></li>
									<li class="active">Encuestas</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>Encuestas de {{$publicacion->user->name }} {{ $publicacion->user->last_name }}</h1>
							</div>

						</div>
					</div>
				</section>

				<div class="container" style="margin-bottom: 10px">
				<div class="row" style="background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px;">
				<div class="col-md-4" >
				<h5>Calificación promedio</h5>
				<h1>{{$publicacion->rating}}</h1>
				</div>	
				<div class="col-md-4" >
						<h5>Palabras positivas más usadas</h5>
						<ol>
						@foreach ($publicacion->positive_words as $word)
								<li>{{ $word }}</li>
						@endforeach	
						</ol>	
					</div>
					<div class="col-md-4" >
					<h5>Palabras negativas más usadas</h5>
						<ol>
						@foreach ($publicacion->negative_words as $word)
								<li>{{ $word }}</li>
						@endforeach	
						</ol>			
					</div>
					</div>
				</div>

					<div class="container">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
								<thead>
									<tr>										
                                        <th>ID</th>
										<th>Fecha</th>
										<th>Nombre del cliente</th>
										<th>Celular</th>
										<th>Concretó servicio</th>
										<th>Calificación</th>
										<th>Palabras positivas</th>
										<th>Palabras negativas</th>	
                                        <th>Reseña</th>										
									</tr>
								</thead>
								<tbody>
                                @foreach($surveys as $survey)
									<tr class="gradeX">                                    
                                        <td>{{$survey->id}} </td>
										<td>{{$survey->updated_at}} </td>
										<td>{{$survey->client_name}} </td>
										<td>{{$survey->client_cellphone}} </td>
										<td>
											@if($survey->service_provided)
											Sí
											@else
											No
											@endif
										</td>
										<td>{{$survey->satisfaction}} </td>
										<td>
											@if($survey->descriptive_words !== null)
											@foreach($survey->positiveWords() as $word)
    										{{$word}}@if (!$loop->last) - @endif
											@endforeach
											@else
											-
											@endif
										</td>
										<td>
											@if($survey->no_agreement !== null)
											@foreach($survey->negativeWords() as $word)
    										{{$word}}@if (!$loop->last) - @endif
											@endforeach
											@else
											-
											@endif
										</td>
										<td>
											@if($survey->review !== null)
											{{$survey->review}}
											@else 
											-
											@endif
										</td>
									</tr>
                                @endforeach							
								</tbody>
							</table>
						</div>						
					</div>
                    <div class="row">
                        <div class="col-12 text center">
                        {{ $surveys->Links() }}
                        </div>
                    </div>
				<a href="{{ route('admin_publicaciones_user', ['user_hash' => $publicacion->user->hash]) }}" class="btn btn-primary" > Volver</a>

				</div>

			</div>

@endsection
