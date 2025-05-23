@extends('layouts.home')

@section('main')

    <section
        class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8"
        style="background-image: url({{ asset('img/slides/slide-bg-4.jpg') }}); background-size: cover; background-position: center; min-height: 645px;">
        <div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
        <div class="container pt-lg-5 mt-5">
            <div class="row pt-3 pb-lg-0 pb-xl-0">
                <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                    <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                        <li><a href="{{ route('welcome') }}">Inicio</a></li>
                        <li class="text-color-primary"><a href="#">Panel de control</a></li>

                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Encuestas a {{ $publicacion->user->name }} {{ $publicacion->user->last_name }}</h1>

                    <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100"
                        class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver
                        <i class="fas fa-arrow-down ms-1"></i></a>


                </div>

            </div>
        </div>
    </section>



    <div role="main" class="main" id="ver">
    </div>    
    <div class="container pt-3 pb-2">
        <div class="form-group row">
            <div class="form-group col-lg-9">
                <h2 class="font-weight-normal line-height-1">Publicación <strong
                        class="font-weight-extra-bold">{{ $publicacion->titulo->name }}</strong> </h2>
            </div>

            <div class="form-group col-lg-2">
                <a href="{{ route('prof_publicacion', ['hash_user' => $publicacion->user->hash]) }}"
                    class="btn btn-dark btn-modern float-end">Volver</a>

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
            <div class="row pt-2">
            <div class="container" style="margin-bottom: 10px">
					<div class="row" style="background-color: #f2f2f2; margin: 1px; padding: 20px; border-radius: 5px;">
						<div class="col-md-3" >
						<h5>Calificación promedio</h5>
						<h1>{{$publicacion->rating}}</h1>
						</div>	
				<div class="col-md-3" >
						<h5>Palabras positivas</h5>
						<ol>
						@foreach ($publicacion->positive_words as $word)
								<li>{{ $word }}</li>
						@endforeach	
						</ol>	
					</div>
                    <div class="col-md-3" >
					<h5>Sugerencias para mejorar</h5>
						<ol>
						@foreach ($publicacion->negative_words as $word)
								<li>{{ $word }}</li>
						@endforeach	
						</ol>			
					</div>
					<div class="col-md-3" >
					<h5>Razones no concretar</h5>
						<ol>
						@foreach ($publicacion->reason_no_agree as $word)
								<li>{{ $word }}</li>
						@endforeach	
						</ol>			
					</div>
					</div>
				</div>
                <div class="container">
                    <section class="card card-admin">

                        <div class="card-body">
                                <table class="table table-bordered table-striped mb-0" id="datatable-editable">
                                    <thead>
                                        <tr class="actions text-center">
                                            <th>Fecha de registro</th>
                                            <th>Cliente</th>
                                            <th>Celular</th>
                                            <th>Calificación</td>
                                            <th>Encuesta cliente</th>
                                            <th>Encuesta profesional</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                            @if ($publicacion->contacts)
                                                @foreach ($publicacion->contacts as $contact)
                                                    <tr data-item-id="1">
                                                        @if ($contact)
                                                        <!-- Fecha -->
                                                            <td class="actions text-center">
                                                                {{ $contact->created_at->format('d/m/Y H:i:s') }}
                                                            </td>
                                                        <!-- {{-- Nombre del cliente --}} -->
                                                            <td class="actions text-center">
                                                                {{ $contact->client_name }}
                                                            </td>
                                                        <!-- Cel del cliente -->
                                                            <td class="actions text-center">
                                                                {{ $contact->client_cellphone }}
                                                                <a target="_blank"
                                                                    href=" https://wa.me/{{ $contact->client_cellphone }}?text=Hola!%20Te%20contacto%20desde%20el%20portal%20de%20oficios%20para%20hacerte%20una%20consulta!"
                                                                    class="">
                                                                    <i class="fab fa-whatsapp text-success"></i></a>
                                                            </td>
                                                        <!-- Calificación -->
                                                            <td class="actions text-center">
                                                                {{ $contact->satisfaction }}
                                                            </td>                                                        
                                                        <!-- Encuesta cliente -->
                                                            <td class="actions text-center" >
                                                                <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                                                                @if ($contact->contacted == 0)
                                                                    <span class="btn btn-light">No enviada</span>
                                                                @elseif ($contact->accepts_survey == 0) 
                                                                <span class="btn btn-warning">No contestada</span>
                                                                @else
                                                                    <a class="btn btn-success" href="{{ route('admin_surveys', ['survey_id' => $contact->id]) }}">
                                                                        <span>Ver</span>
                                                                    </a>
                                                                @endif
                                                            <!-- Envío de encuesta -->

                                                                <form action="{{ route('survey.init') }}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $contact->user_id }}">
                                                                    <input type="hidden" name="survey_id"
                                                                        value="{{ $contact->id }}">
                                                                    @if ($contact->contacted == 0)
                                                                        <button class="btn btn-success"
                                                                            type="submit" data-bs-toggle="tooltip" title="Enviar encuesta"><i class="fa fa-paper-plane"></i></button>
                                                                    @else
                                                                        <button class="btn btn-warning"
                                                                            type="submit" data-bs-toggle="tooltip" title="Volver a enviar encuesta"><i class="fa fa-repeat"></i></button>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                            </td>

                                                            <!-- Encuesta profesional -->
                                                            <td class="actions text-center">
                                                            <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                                            
                                                            @if ($contact->professionalSurvey)
                                                                    @if ($contact->professionalSurvey->date_completed) 
                                                                    <a class="btn btn-success" href="{{ route('admin_surveys_prof', ['survey_id' => $contact->professionalSurvey->id]) }}">
                                                                        <span>Ver</span>
                                                                    </a>
                                                                    @else
                                                                    <span class="btn btn-warning">No contestada</span>
                                                                    @endif                                                        
                                                            @else
                                                                <span class="btn btn-light">-</span>
                                                            @endif
                                                            <form action="{{ route('survey.initProf') }}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $contact->user_id }}">
                                                                    <input type="hidden" name="survey_id"
                                                                        value="{{ $contact->id }}">
                                                                    @if ($contact->professionalSurvey)
                                                                    <button class="btn btn-warning"
                                                                    type="submit" data-bs-toggle="tooltip" title="Volver a enviar encuesta"><i class="fa fa-repeat"></i></button>
                                                                    @else
                                                                    <button class="btn btn-success"
                                                                        type="submit" data-bs-toggle="tooltip" title="Enviar encuesta"><i class="fa fa-paper-plane"></i></button>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                    </tbody>
                                </table>
                        </div>
                    </section>
                </div>
                <div class="row">
                    <div class="col-12 text center">
                    {{ $publicacion->contacts->Links() }}
                    </div>
                </div>
            </div>



        </div>

    </div>


@endsection
