
@extends('layouts.home')

@section('main')


			<div role="main" class="main">
				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="{{ url('/') }}">Inicio</a></li>
									<li class="active">Panel de Control</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>Mensajes del Profesional</h1>
							</div>
						</div>
					</div>
				</section>

				<section  class="parallax" data-stellar-background-ratio="0.5" style="background-image: url( {{ asset('parallax-transparent.jpg') }} );">
					<div class="container">
						<div class="row">
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

						<div class="row">
							<div class="col-md-12">
								<h1>Mensajes con el profesional {{ $publicacion->user->name }} {{ $publicacion->user->last_name }} por la publicación de {{ $publicacion->categoria->name }}</h1>
							</div>
						</div>
                        @foreach($mensajes_all as $mensaje)
                            @if($mensaje->is_reply==false)
							<div class="col-md-12">
							<div class="col-md-8 left">
                                <div class="alert alert-success">
                                    <strong>Cliente {{ $interactionhead->name }} {{ $interactionhead->last_name }}:</strong> {{ $mensaje->message }}.<br>
                                    @foreach($mensaje->imagenes as $imagen)
									
									<img src="{{ asset($imagen->url) }}" style="width:30%;cursor:zoom-in"
									onclick="document.getElementById('{{$imagen->id}}').style.display='block'">
									
									<div id="{{$imagen->id}}" class="w3-modal" onclick="this.style.display='none'">
										<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
										<div class="w3-modal-content w3-animate-zoom">
										<img src="{{ asset($imagen->url) }}" style="width:100%">
										</div>
									</div>
									<!--
									<a href="{{ asset($imagen->url) }}" target="_blank" >
									<i class="fa fa-paperclip"></i></a>
									-->
									@endforeach
									<small class="text-muted">{{ $mensaje->date }}</small>
                                </div>
                                </div>
                                <div class="col-md-4"></div>
							</div>
                            @else
    						<div class="col-md-12">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 right">
                                    <div class="alert alert-warning">
                                        <strong>Profesional:</strong> {{ $mensaje->message }}.<br>
										@foreach($mensaje->imagenes as $imagen)
										
										<img src="{{ asset($imagen->url) }}" style="width:30%;cursor:zoom-in"
										onclick="document.getElementById('{{$imagen->id}}').style.display='block'">
										
										<div id="{{$imagen->id}}" class="w3-modal" onclick="this.style.display='none'">
											<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
											<div class="w3-modal-content w3-animate-zoom">
											<img src="{{ asset($imagen->url) }}" style="width:100%">
											</div>
										</div>
										<!--
                                        <a href="{{ asset($imagen->url) }}" target="_blank" >
										<i class="fa fa-paperclip"></i></a>
										-->
										@endforeach
										<small class="text-muted">{{ $mensaje->date }}</small>
                                    </div>
                                </div>
							</div>
                            @endif

                        @endforeach

							
							
							<a href="{{ URL::previous() }}" class="btn btn-primary" > VOLVER</a>
                            
							</div>


						</div>
					</div>
				</section>

















				<div class="container">


					<div class="row">
						<div class="col-md-12">

						</div>


					</div>

				</div>

			</div>
@endsection