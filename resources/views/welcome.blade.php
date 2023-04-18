@extends('layouts.home')

@section('main')

			<div role="main" class="main">

				<div class="slider-container">
					<div class="slider" id="revolutionSlider" data-plugin-revolution-slider data-plugin-options='{"startheight": 677}'>
						<ul>
							<li data-transition="fade" data-slotamount="10" data-masterspeed="300">
								<img src="img/slides/slide-bg-3.jpg" data-bgfit="cover" data-bgposition="right center" data-bgrepeat="no-repeat">

									<div class="tp-caption sft stb visible-lg"
										 data-x="350"
										 data-y="250"
										 data-speed="300"
										 data-start="1000"
										 data-easing="easeOutExpo"><img src="img/slides/slide-title-border.png" alt=""></div>

									<div class="tp-caption top-label lfl stl"
										 data-x="center" data-hoffset="0"
										 data-y="250"
										 data-speed="300"
										 data-start="500"
										 data-easing="easeOutExpo">PROFESIONALES PARA EL HOGAR</div>

									<div class="tp-caption sft stb visible-lg"
										 data-x="780"
										 data-y="250"
										 data-speed="300"
										 data-start="1000"
										 data-easing="easeOutExpo"><img src="img/slides/slide-title-border.png" alt=""></div>

									<div class="tp-caption main-label sft stb"
										 data-x="center" data-hoffset="0"
										 data-y="280"
										 data-speed="300"
										 data-start="1500"
										 data-easing="easeOutExpo">CFP</div>

									<div class="tp-caption bottom-label sft stb"
										 data-x="center" data-hoffset="0"
										 data-y="350"
										 data-speed="500"
										 data-start="2000"
										 data-easing="easeOutExpo">responsabilidad, confianza y precios justos</div>



							</li>
							<li data-transition="fade" data-slotamount="10" data-masterspeed="300">
								<img src="img/slides/slide-bg-4.jpg" data-bgfit="cover" data-bgposition="right center" data-bgrepeat="no-repeat">

								<div class="tp-caption featured-label sft stb"
									 data-x="center"
									 data-y="280"
									 data-speed="300"
									 data-start="1500"
									 data-easing="easeOutExpo">CONTACTÁ PROFESIONALES </div>

								<div class="tp-caption bottom-label sft stb"
									 data-x="center"
									 data-y="338"
									 data-speed="500"
									 data-start="2000"
									 data-easing="easeOutExpo"><strong>CON CERTIFICACIÓN OFICIAL EN TU BARRIO</strong> </div>
							</li>
						</ul>
					</div>
				</div>

				<section class="page-top">
					<div class="container">
						<div class="row">

						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>¿QUÉ PROFESIONAL ESTÁS BUSCANDO?</h1>
							</div>
						</div>
					</div>
				</section>

				<div class="container">

						<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
						
                            @foreach($categoria_servicios_all as $categoria)
                            <li class="col-md-4 col-sm-6 col-xs-12 isotope-item websites">
							
								<div class="portfolio-item img-thumbnail">
									<a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}" class="thumb-info">
										<img alt="" class="img-responsive" src="{{ asset($categoria->icon) }}">
										<span class="thumb-info-title">
											<span class="thumb-info-inner">{{ $categoria->name }}</span>

										</span>
										<span class="thumb-info-action">
											<span title='{{ asset($categoria->name) }}' class="thumb-info-action-icon"><i class="fa fa-link"></i></span>
										</span>
									</a>
								</div>
							</li>
                            @endforeach

						</ul>

					</div>

				</div>
			
			</div>

            @endsection
