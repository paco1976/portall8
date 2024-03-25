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
				<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">ENCUESTAS DEL PROFESIONAL </h1>
				
				<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
		</div>

		</div>
	</div>
</section>
    <div role="main" class="main" id="ver">
		<div class="container pt-3 pb-2">
      <h2 class="font-weight-normal line-height-1">Encuestas de <strong class="font-weight-extra-bold">{{ $user->name }} {{ $user->last_name }}</strong></h2>

        <div class="container" style="margin-bottom: 10px">
            <div class="row" style="background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px;">
                <div class="col-md-4">
                    <h5>Calificación promedio</h5>
                    <h1>{{ $user->rating }}</h1>
                </div>
                <div class="col-md-4">
                    <h5>Palabras positivas más usadas</h5>
                    <ol>
                        @foreach ($user->positive_words as $word)
                            <li>{{ $word }}</li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-md-4">
                    <h5>Palabras negativas más usadas</h5>
                    <ol>
                        @foreach ($user->negative_words as $word)
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
                            <tr class="text-center">
                                <th>Fecha</th>
                                <th>Publicación</th>
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
                            @foreach ($surveys as $survey)
                                <tr class="gradeX">
                                    <td>{{ $survey->updated_at }} </td>
                                    <td>{{ $survey->publicacionName }} </td>
                                    <td>{{ $survey->client_name }} </td>
                                    <td>{{ $survey->client_cellphone }} </td>
                                    <td>
                                        @if ($survey->service_provided)
                                            Sí
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>{{ $survey->satisfaction }} </td>
                                    <td>
                                        @if ($survey->descriptive_words !== null)
                                            @foreach ($survey->positiveWords() as $word)
                                                {{ $word }}@if (!$loop->last)
                                                    -
                                                @endif
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($survey->no_agreement !== null)
                                            @foreach ($survey->negativeWords() as $word)
                                                {{ $word }}@if (!$loop->last)
                                                    -
                                                @endif
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($survey->review !== null)
                                            
											<button type="button" class="btn btn-modern btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#myModal">
												<i class="fa fa-eye"></i>
											</button>
											<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														  <div class="modal-header border-bottom-0">
															<button type="button" class="btn-close" data-bs-dismiss="modal"
																aria-hidden="true">&times;</button>
														</div>
														<div class="modal-body">
															<div id="client-form" class="contact-info">
																{{ $survey->review }}
															</div>
														</div>
													</div>
												</div>
											</div>
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
			
        </div>
	</div>
    </div>
@endsection
