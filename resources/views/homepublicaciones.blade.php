@extends('layouts.home')

@section('main')

<div role="main" class="main">
				

				<section class="page-top">
					<div class="container">
						<div class="row">
							
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>{{ $categoria->name }}</h1>
							</div>
						</div>
					</div>
				</section>

				<div class="container">
					<div class="row" id="team">
						<div class="col-md-12">

							<div class="row">

								<ul class="team-list">
								<!-- acá va el forech -->
								@if($publicacion_count > 0)
									@foreach($publicaciones_all as $publicacion)
									<li class="col-md-3 col-sm-6 col-xs-12">
										<div class="team-item thumbnail">
											<a href="{{ route('homeprofesional', ['id'=> $publicacion->id]) }}" class="thumb-info team">
												<img alt="350" height="270" src="{{ asset($publicacion->users->avatar) }} ">
												<span class="thumb-info-title">
													<span class="thumb-info-inner"> {{ $publicacion->users->name }} {{ $publicacion->users->last_name }}</span>
													<!-- <span class="thumb-info-type">PROFESION</span> -->
												</span>
											</a>
											<span class="thumb-info-caption">
												<p>{{ $publicacion->description }}</p>
												<!--
												<span class="thumb-info-social-icons">
													<a data-tooltip data-placement="bottom" target="_blank" href="http://www.facebook.com" data-original-title="Facebook"><i class="fa fa-facebook"></i><span>Facebook</span></a>
													<a data-tooltip data-placement="bottom" href="http://www.linkedin.com" data-original-title="Linkedin"><i class="fa fa-linkedin"></i><span>Linkedin</span></a>
												</span>
												-->
											</span>
										</div>
									</li>
									@endforeach
								@else
									
									<h1>No hay publicaciones disponibles</h1>
								@endif

								</ul>
								
							</div>
							<p>
								<a href="{{ url('/') }}" class="btn btn-primary">Volver</a>
							</p>
						</div>
					</div>
				</div>

			</div>

            @endsection
