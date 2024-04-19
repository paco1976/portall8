@extends('layouts.home')

@section('main')

<div role="main" class="main">

	<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{ asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
		<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
		<div class="container pt-lg-5 mt-5">
			<div class="row pt-3 pb-lg-0 pb-xl-0">
				<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
					<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
						<li><a href="{{route('welcome')}}">Inicio</a></li>
						<li class="text-color-primary"><a href="#">Quienes somos</a></li>
						
					</ul>
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Sobre Nosotros</h1>
					
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
					<a href="{{ route('contacto')}}" class="btn btn-light btn-outline btn-outline-thin btn-outline-light-opacity-2 btn-effect-5 font-weight-semi-bold px-4 btn-py-2 text-3 text-color-light text-color-hover-dark ms-2">Contactanos <i class="fas fa-external-link-alt ms-1"></i></a>
				</div>

			</div>
		</div>
	</section>

	
	<div role="main" class="main" id="ver">

		<div class="container">
	
			<div class="row pt-4 appear-animation" data-appear-animation="fadeInUpShorter">
				<div class="col-lg-7 pe-lg-5">
					@if ($aboutus_all->count() > 0 )
					@foreach ($aboutus_all as $aboutus )
					<h2 class="font-weight-normal line-height-1">{{ $aboutus->title }}</h2>
					<p class="lead">{!! $aboutus->description !!}</p>
					<hr class="tall">
					@endforeach
					@else
					<h2 class="font-weight-normal line-height-1">Up! Por el momento no hay información</h2>
					<p class="lead">
						Disculpe las molestias, estamos actulizando la web. <br>
						En breve ya va a estar disponible la información de esta sección <br>
					</p>
					@endif
					{{ $aboutus_all->Links() }}
				</div>
				
	
				<div class="col-lg-5">
					<h4 class="font-weight-normal line-height-1 ">¿Qué es la Red de <strong class="font-weight-extra-bold"> CFP públicos</strong>?</h4>
					
					
					<p class="lead"> Siete CFP’s públicos conformamos una red que imaginó, diseñó y puso en funcionamiento el Portal. CFP’s participantes:</p>
					<h4 class="font-weight-normal"><strong class="font-weight-extra-bold"> </strong> ... </h4>
					
					<ul class="list list-icons list-icons-style-3">
						<h4 class="font-weight-normal line-height-1 ">  </h4>
						<p class="text-justify">
							<strong>CFP N° 01</strong>
						</p>
						<li><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Río Cuarto 1993, C1295 CABA</li>
						<li><i class="fas fa-phone"></i> <strong>Teléfono:</strong> 4301-8678</li>
						
						<p class="text-justify">
							<strong>CFP N° 04</strong>
						</p>
						<li><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Carhué 2970, C1440ERF CABA</li>
						<li><i class="fas fa-phone"></i> <strong>Teléfono:</strong> 4686-2196</li>
					

						<p class="text-justify">
							<strong>CFP N° 06</strong>
						</p>
						<li><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Av. Asamblea 153, C1424COB CABA</li>
						<li><i class="fas fa-phone"></i> <strong>Teléfono:</strong> 4922-3683</li>

						<p class="text-justify">
							<strong>CFP N° 07</strong>
						</p>
						<li><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Ramsay 2250, C1428BAJ CABA</li>
						<li><i class="fas fa-phone"></i> <strong>Teléfono:</strong> 4783-8725</li>

						<p class="text-justify">
							<strong>CFP N° 09</strong>
						</p>
						<li><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Av. Gral. Iriarte 3400, C1437 CABA</li>
						<li><i class="fas fa-phone"></i> <strong>Teléfono:</strong> </li>
						
						<p class="text-justify">
							<strong>CFP N° 24</strong>
						</p>
						<li><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Morón 2538, C1406FVF CABA</li>
						<li><i class="fas fa-phone"></i> <strong>Teléfono: 4611-5374</strong> </li>

						<p class="text-justify">
							<strong>CFP N° 36</strong>
						</p>
						<li><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Zavaleta 204, Parque Patricios, CABA</li>
						<li><i class="fas fa-phone"></i> <strong>Teléfono: 4912-3792 / 0331</strong> </li>

					</ul>						
					
					
				</div>
			</div>
	
		</div>
	
	
	</div>		
		
	
		
	</div>			
	
@endsection
