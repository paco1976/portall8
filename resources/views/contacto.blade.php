@extends('layouts.home')

@section('main')

			<!--  dese acá -->
			<div role="main" class="main">

				<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
					<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
					<div class="container pt-lg-5 mt-5">
						<div class="row pt-3 pb-lg-0 pb-xl-0">
							<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
								<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
									<li><a href="{{route('welcome')}}">Inicio</a></li>
									<li class="text-color-primary"><a href="{{route('contacto')}}">Contacto</a></li>
									
								</ul>
								<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Dejanos tu consulta</h1>
								
								<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
								
							</div>

						</div>
					</div>
				</section>
				

				<div role="main" class="main" id="ver">

					<div class="container">
	
						<div class="row py-4">
							<div class="col-lg-6">
	
								<h2 class="font-weight-bold text-8 mt-2 mb-0">Hacé una consulta</h2>
								<p class="mb-4">Sentite libre de pedir detalles, ¡no te guardes ninguna pregunta!</p>
	
								<form class="contact-form" action="{{ route('contact_send') }}" method="POST" enctype="multipart/form-data">
									{{ method_field('PUT') }}  
										@csrf
									
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
	
									<div class="row">
										<div class="form-group col">
											<label class="form-label mb-1 text-2">Nombre (*)</label>
											<input type="text" value="" data-msg-required="Por favor, escribí tu nombre." maxlength="100" class="form-control text-3 h-auto py-2" name="name" required>
										</div>
									</div>							
									
									<div class="row">
										<div class="form-group col">
											<label class="form-label mb-1 text-2">Email (*)</label>
											<input type="email" value="" data-msg-required="Por favor, escribí tu correo electrónico." data-msg-email="Por favor, escribí tu correo electrónico." maxlength="100" class="form-control text-3 h-auto py-2" name="email" required>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group col">
											<label class="form-label mb-1 text-2">Asunto</label>
											<input type="text" value="" data-msg-required="Por favor, ingrese su asunto." maxlength="100" class="form-control text-3 h-auto py-2" name="asunto" required>
										</div>
									</div>
									<div class="row">
										<div class="form-group col">
											<label class="form-label mb-1 text-2">Mensaje</label>
											<textarea maxlength="5000" data-msg-required="Por favor, ingrese su mensaje o consulta." rows="8" class="form-control text-3 h-auto py-2" name="mensaje" required></textarea>
										</div>
									</div>
									<div class="row">
										<div class="form-group col">
											<!--<input type="submit" value="Enviar Mensaje" class="btn btn-primary btn-modern" data-loading-text="Loading...">-->
											<button type="submit" class="btn btn-primary btn-modern">Enviar Mensaje</button>
										</div>
									</div>
								</form>
	
							</div>
							<div class="col-lg-6">
								<div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="800">
									<h4 class="pt-5">¿Qué es <strong>Cefeperes</strong>?</h4>
									<p class="lead mb-0 text-4">Cefeperes es una plataforma digital diseñada para facilitar el contacto entre profesionales de los oficios y potenciales clientes. La lista de servicios ofrecidos es variada (se puede consultar acá) y el denominador común es que son egresadas y egresados de escuelas púbicas de Formación Profesional de nuestra ciudad.</p>
									</div>
									<br></br>
									
									<div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="850">
										<h4 class="mt-2 mb-1">Nuestros <strong>Datos</strong></h4>
										@if ($contact_all->count() > 0)
										<ul class="list list-icons list-icons-style-2 mt-2">
											@foreach ($contact_all as $contact)
												@if ($contact->name == 'Dirección')
													<li><i class="fas fa-map-marker-alt top-6"></i><strong>{{$contact->name }}</strong> {{$contact->detail }}</li>	
												@endif	
												@if ($contact->name == 'Teléfono')
													<li><i class="fas fa-phone top-6"></i> <strong>{{$contact->name }}</strong> {{$contact->detail }}</li>	
												@endif
												@if ($contact->name == 'Email')
													<li><i class="fas fa-envelope top-6"></i><strong>{{$contact->name }}</strong><a href="{{ 'mailto:'.$contact->detail}}"> {{$contact->detail }}</a></li>
												@endif		
											@endforeach
										</ul>
										@endif
									</div>
	
							</div>
	
						</div>
	
					</div>
	
				</div>
	
	
				</div>		
					
			
					
				</div>
	
	
				<!-- hasta acá -->
@endsection
