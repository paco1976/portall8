@extends('layouts.home')

@section('main')

			<div role="main" class="main">

				<div class="owl-carousel-wrapper position-relative" style="height: 670px">
					<div class="owl-carousel-loader">
						<div class="bounce-loader">
							<div class="bounce1"></div>
							<div class="bounce2"></div>
							<div class="bounce3"></div>
						</div>
					</div>

					<div class="owl-carousel dots-inside dots-horizontal-center show-dots-hover nav-inside nav-inside-plus nav-dark nav-md nav-font-size-md show-nav-hover mb-0" data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 1}, '979': {'items': 1}, '1199': {'items': 1}}, 'loop': false, 'autoHeight': false, 'margin': 0, 'dots': true, 'dotsVerticalOffset': '-75px', 'nav': true, 'animateIn': 'fadeIn', 'animateOut': 'fadeOut', 'mouseDrag': false, 'touchDrag': false, 'pullDrag': false, 'autoplay': true, 'autoplayTimeout': 9000, 'autoplayHoverPause': true, 'rewind': true}">

						<div class="position-relative overlay overlay-show overlay-op-2" data-dynamic-height="['670px','670px','670px','550px','500px']" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; height: 670px;">
							<div class="container position-relative z-index-1 h-100">
								<div class="d-flex flex-column align-items-center justify-content-center h-100">
									<h3 class="position-relative text-color-light text-5 line-height-5 font-weight-medium px-4 mb-2 appear-animation" data-appear-animation="fadeInDownShorter" data-plugin-options="{'minWindowWidth': 0}">
										<span class="position-absolute right-100pct top-50pct transform3dy-n50 opacity-3">
											<img src="{{ asset('ipp/img/slides/slide-title-border.png')}}" class="w-auto appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="250" data-plugin-options="{'minWindowWidth': 0}" alt="" />
										</span>
										PORTAL DE <span class="position-relative">SERVICIOS </span>
										<span class="position-absolute left-100pct top-50pct transform3dy-n50 opacity-3">
											<img src="{{ asset('ipp/img/slides/slide-title-border.png')}}" class="w-auto appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="250" data-plugin-options="{'minWindowWidth': 0}" alt="" />
										</span>
									</h3>
									<h1 class="text-color-light font-weight-extra-bold text-12 mb-3 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">EL PUEBLO TRABAJANDO CON EL PUEBLO</h1>
									<p class="text-4 text-color-light font-weight-bold opacity-7 mb-0">Encontrá aca lo que necesitas</p>
								</div>
							</div>
						</div>

					</div>
				</div>

								<!--Tendría que dejar desde acá -->
								<div class="home-intro bg-primary" id="home-intro">
									<div class="container">
				
										<div class="row align-items-center">
											<div class="col-lg-8">
												<p>
													¿Estas buscando un profesional?
													<span>Encontrá todo lo que buscas en nuestro sitio.</span>
												</p>
											</div>
											<div class="col-lg-4">
												
												<div class="get-started text-start text-lg-end">
													<a href="{{ url('/comunidad') }}" class="btn btn-dark btn-lg text-3 font-weight-semibold px-4 py-3">Quienes somos</a>
													<div class="learn-more">
														&nbsp; <a href="{{ route('contacto') }}">Contacto</a>
													</div>
												</div>
											</div>
										</div>
				
									</div>
								</div>

								<div class="container">
									<div class="row">
										<div class="col">
											<div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="500">
												<ul class="nav nav-pills sort-source sort-source-style-3" data-sort-id="portfolio" data-option-key="filter" data-plugin-options="{'layoutMode': 'masonry', 'filter': '*'}">
													<li class="nav-item active" data-option-value="*"><a class="nav-link text-2-5 text-uppercase active" href="#">MOSTRAR TODOS</a></li>
													@if ($supercateogrias_all->count() > 0)
													@foreach ($supercateogrias_all as $supercateogria)
													<li class="nav-item" data-option-value=".{{$supercateogria->keyword}}"><a class="nav-link text-2-5 text-uppercase" href="#">{{$supercateogria->name}}</a></li>	
													@endforeach
													@endif
												</ul>
				
												<div class="sort-destination-loader sort-destination-loader-showing mt-4 pt-2">
													<div class="row portfolio-list sort-destination" data-sort-id="portfolio">
														
														@if ($categoria_all->count() > 0)
														@foreach ($categoria_all as $categoria )
														<!--
														<div class="col-sm-6 col-lg-3 isotope-item {{$categoria->categoriatipo->keyword}}">
															<div class="portfolio-item">
																<a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}">
																	<span class="thumb-info thumb-info-centered-info thumb-info-no-borders border-radius-0">
																		<span class="thumb-info-wrapper border-radius-0">
																			<img src="{{ $categoria->icon }}" class="img-fluid border-radius-0" alt="">
																			<span class="thumb-info-title">
																				<span class="thumb-info-inner">{{ $categoria->name }}</span>
																				
																			</span>
																		</span>
																	</span>
																</a>
															</div>
														</div>
													-->
														<div class="col-sm-6 col-lg-3 isotope-item {{$categoria->categoriatipo->keyword}}">
															<div class="portfolio-item">
																<span class="thumb-info thumb-info-swap-content thumb-info-centered-icons">
																	<span class="thumb-info-wrapper overlay overlay-show overlay-gradient-bottom-content">
																		<img src="{{ $categoria->icon }}" class="img-fluid" alt="">
																		<span class="thumb-info-action">
																			<a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}">
																				<span class="thumb-info-action-icon thumb-info-action-icon-light"><i class="fas fa-search text-dark text-dark"></i></span>
																			</a>
																		</span>
																		<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0 text-center">
																			<span class="thumb-info-swap-content-wrapper">
																				<span class="thumb-info-inner">{{ $categoria->name }}</span>
																				<span class="thumb-info-type text-light m-0 float-none">{{ $categoria->name }}</span>
																			</span>
																		</span>
																	</span>
																</span>
															</div>
														</div>
				
														@endforeach				
														@else
														<p>UPS! todavía no hay categorías para mostrar</p>
														@endif
														
														
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>


            @endsection
