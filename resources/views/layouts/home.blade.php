<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Basic -->
		<meta charset="utf-8">
		<title>CEFEPERES - Servicios Profesionales de egresados de CFP</title>
		<meta name="keywords" content="CEFEPERES, Servicios Profesionales, Carpintero, Electricista, Aire Acondicionado, Maquillaje, Estética, Herrero, Peluquería, Video, Sonido, Diseño, Marroquinería, Plomero, Tècnico" />
		<meta name="description" content="CEFEPERES - CONTACTÁ PROFESIONALES CON CERTIFICACIÓN OFICIAL EN TU BARRIO. Responsabilidad, confianza y precios justos">
		<meta name="author" content="TecnoARTE">
		
		<!-- JQUERY -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Whatsapp -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- <link rel="stylesheet" href="{{ asset('css/whatsapp.css') }}"> -->
		
		<!-- Icons -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png')}}">


		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
		


		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{asset('ipp/vendor/bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('ipp/vendor/fontawesome-free/css/all.min.css')}}">
		<link rel="stylesheet" href="{{asset('ipp/vendor/animate/animate.compat.css')}}">
		<link rel="stylesheet" href="{{asset('ipp/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
		<link rel="stylesheet" href="{{asset('ipp/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{asset('ipp/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
		<link rel="stylesheet" href="{{asset('ipp/vendor/magnific-popup/magnific-popup.min.css')}}">
		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{asset('ipp/css/theme.css')}}">
		<link rel="stylesheet" href="{{asset('ipp/css/theme-elements.css')}}">

		<!-- Demo CSS -->
		<link rel="stylesheet" href="{{asset('ipp/css/demos/demo-tecnoarte-cian.css')}}">
		
        <!-- Current Page CSS -->
        <link rel="stylesheet" href="{{ asset('vendor/rs-plugin/css/settings.css') }}" media="screen">
        <link rel="stylesheet" href="{{ asset('vendor/circle-flip-slideshow/css/component.css') }}" media="screen">

        <!-- Skin CSS -->
        <link rel="stylesheet" href="{{ $skinSelect->urlskin }}">

		<!-- Head Libs -->
		<script src="{{asset('ipp/vendor/modernizr/modernizr.min.js')}}"></script>

		<!-- Editor de texto en textarea de quienes somos -->
		<script src="//cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>


		
		@stack('style')
		
	</head>
	<body class="loading-overlay-showing" data-loading-overlay data-plugin-options="{'hideDelay': 500}">
		<div class="loading-overlay">
			<div class="bounce-loader">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>
	<div class="body">
			<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
				<div class="header-body border-top-0">
					<div class="header-top">
						<div class="container">
							<div class="header-row py-2">
								<div class="header-column justify-content-start">
									<div class="header-row">
										
										<nav class="header-nav-top">

											
											@if ($contact_all->count() > 0)
											<ul class="list list-unstyled list-inline mb-0">
											@foreach ($contact_all as $contact)
												@if ($contact->name == 'Teléfono')
												<li class="list-inline-item me-4 mb-0">
													<i class="icons icon-phone text-color-secondary text-4 position-relative top-4 me-1"></i>
													<a href="tel:+1234567890" class="text-default text-hover-secondary font-weight-medium text-decoration-none text-2">
														{{$contact->detail }} 
													</a>
												</li>
												@endif
												@if ($contact->name == 'Dirección')
												<li class="list-inline-item me-4 mb-0 d-none d-lg-inline-block">
													<i class="icons icon-location-pin text-color-secondary text-4 position-relative top-4 me-1"></i>
													<a href="#" class="text-default text-hover-secondary font-weight-medium text-decoration-none text-2">
														{{$contact->detail }} 
													</a>
												</li>
												@endif
												@if ($contact->name == 'Email')
												<li class="list-inline-item me-4 mb-0 d-none d-md-inline-block">
													<i class="icons icon-envelope text-color-secondary text-4 position-relative top-4 me-1"></i>
													<a href="mailto:info@correo.com.ar" class="text-default text-hover-secondary font-weight-medium text-decoration-none text-2">
														{{$contact->detail }} 
													</a>
												</li>
												@endif
											@endforeach
											<li class="list-inline-item me-4 mb-0">
												<i class="icons icon-location-pin text-color-secondary text-4 position-relative top-4 me-1"></i>
												<a href="https://cfp24.com.ar" target="_blank" class="text-default text-hover-secondary font-weight-medium text-decoration-none text-2">
													¿Queres aprender un oficio?
												</a>
											</li>
											</ul>
											@endif
											
										</nav>

										
										
										
									</div>
								</div>
								@auth
								<div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
									<div class="header-nav-feature header-nav-features-user header-nav-features-user-logged d-inline-flex mx-2 pe-2" id="headerAccount">
										<a href="#" class="header-nav-features-toggle">
											<i class="far fa-user"></i> {{ Auth::user()->name }} {{ Auth::user()->last_name }}
										</a>
										<div class="header-nav-features-dropdown header-nav-features-dropdown-mobile-fixed header-nav-features-dropdown-force-right" id="headerTopUserDropdown">
											<div class="row">
												<div class="col-8">
													<p class="mb-0 pb-0 text-2 line-height-1 pt-1">Hola,</p>
													<p><strong class="text-color-dark text-4">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</strong></p>
												</div>
												<div class="col-4">
													<div class="d-flex justify-content-end">
														<img class="rounded-circle" width="40" height="40" alt="" src="{{ asset('storage/avatares/'. Auth::user()->avatar) }}">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col">
													<ul class="nav nav-list-simple flex-column text-3">
														<li class="nav-item"><a class="nav-link" href="{{ url('/perfil') }}"> <i class="fa-solid fa-user"></i> Mi Perfil</a></li>
														<li class="nav-item"><a class="nav-link" href="{{ url('/clave') }}"><i class="fas fa-key"></i>  Contraseña</a></li>
														@if ( Auth::user()->user_type()->first()->name == 'Profesional')
														<!--<li class="nav-item"><a class="nav-link" href="{{ route('publicacion') }}"><i class="fas fa-book"></i> Mis Publicaciones</a></li>-->
														<!--<li class="nav-item"><a class="nav-link border-bottom-0" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>Salir</a></li>-->
														@endif
														<li class="nav-item"><a class="nav-link border-bottom-0" href="{{ route('logout') }}"
															onclick="event.preventDefault();
															document.getElementById('logout-form').submit();">
																<i class="fas fa-sign-out-alt"></i> {{ __('Salir') }}
															</a></li>
															<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
																@csrf
															</form>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
									
								@endauth

								@guest
								
								<div class="header-column justify-content-end">
									<div class="header-row">
										<div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
										<div class="header-nav-feature header-nav-features-user d-inline-flex mx-2 pe-2 signin" id="headerAccount">
											<a href="#" class="header-nav-features-toggle">
												<i class="far fa-user"></i> INGRESAR
											</a>
											<div class="header-nav-features-dropdown header-nav-features-dropdown-mobile-fixed header-nav-features-dropdown-force-right" id="headerTopUserDropdown">
												<div class="signin-form">
													<h5 class="text-uppercase mb-4 font-weight-bold text-3">INGRESAR</h5>
													<form method="POST" action="{{ route('login') }}">
													@csrf
														<div class="form-group">
															<label class="form-label mb-1 text-2 opacity-8">Email * </label>
															<input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" required>
															@error('email')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<div class="form-group">
															<label class="form-label mb-1 text-2 opacity-8">Contraseña *</label>
															<input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"  name="password" required>
															@error('password')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<div class="row pb-2">
															<div class="form-group form-check col-lg-6 ps-1">
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
																	<label class="form-label custom-control-label text-2" for="rememberMeCheck">Recordarme</label>
																</div>
															</div>
															<div class="form-group col-lg-6 text-end">
																<a class="text-uppercase text-1 font-weight-bold text-color-dark" id="headerRecover" href="{{ route('password.request') }}">OLVIDASTE TU CONTRASEÑA?</a>
															</div>
														</div>
														<div class="actions">
															<div class="row">
																<div class="col d-flex justify-content-end">
																	<!--<a class="btn btn-primary" href="#">Ingresar</a>-->
																	<button type="submit" class="btn btn-primary">{{ __('Ingresar') }}</button>
																</div>
															</div>
														</div>
														@if (Route::has('register'))
														<div class="extra-actions">
															<p>Todavía no tenés una cuenta? <a href="{{ route('register') }}"  class="text-uppercase text-1 font-weight-bold text-color-dark">Registrarme</a></p>
														</div>
														@endif
													</form>
												</div>
											

												<div class="recover-form">
													<h5 class="text-uppercase mb-2 pb-1 font-weight-bold text-3">Restablecer mi contraseña</h5>
													<p class="text-2 mb-4">Complete el siguiente formulario para recibir un correo electrónico con el código de autorización necesario para restablecer su contraseña.</p>

													<form method="POST" action="{{ route('password.email') }}">
														@csrf
														<div class="form-group">
															<label class="form-label mb-1 text-2 opacity-8">Email * </label>
															<input type="email" class="form-control form-control-lg">
														</div>
														<div class="actions">
															<div class="row">
																<div class="col d-flex justify-content-end">
																	
																	<button type="submit" class="btn btn-primary">
																		{{ __('Reestablecer') }}
																	</button>
																</div>
															</div>
														</div>
														<div class="extra-actions">
															<p>Ya tenés una cuenta? <a href="#" id="headerRecoverCancel" class="text-uppercase text-1 font-weight-bold text-color-dark">Ingresar</a></p>
														</div>
													</form>
												</div>

											</div>
										</div>
									</div>
									</div>
								</div>
								@endguest
							</div>
						</div>
					</div>
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="{{route('welcome')}}">
											<img alt="Tecnoarte"  style="object-fit: contain;" width="220" height="62" data-sticky-width="123" data-sticky-height="48" src="{{ asset('img/logo.png') }}">
										</a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									<div class="header-nav header-nav-links order-2 order-lg-1">
										<div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-dropdown-modern header-nav-main-effect-2 header-nav-main-sub-effect-1">
											<nav class="collapse">
												<ul class="nav nav-pills" id="mainNav">
													<li>
														<a class="nav-link active" href="{{route('welcome')}}">
															Inicio
														</a>
													</li>
													@if ($supercateogrias_all->count() > 0)
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="#">
															Servicios
														</a>
														<ul class="dropdown-menu">
														@foreach ($supercateogrias_all as $supercategoria )
														
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">{{ $supercategoria->name }}</a>
																@if ($supercategoria->categorias->count() >0)
																<ul class="dropdown-menu">
																	@foreach ($supercategoria->categorias as $categoria )
																	<li><a class="dropdown-item" href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}">{{$categoria->name}}</a></li>	
																	@endforeach
																</ul>	
																@endif
															</li>
														
														@endforeach
														</ul>
													</li>	
													@endif
													
												
													<li>
														<a class="nav-link" href="{{ url('/nosotros') }}">
															Comunidad CFP
														</a>
													</li>
												
													<li>
														<a class="nav-link" href="{{ url('/contacto') }}">
															Contacto
														</a>
													</li>
													<li class="dropdown dropdown-mega" id="headerSearchProperties">
														<a class="nav-link dropdown-toggle" href="#">
															<i class="fas fa-search me-2"></i> Buscar
														</a>
														<ul class="dropdown-menu custom-fullwidth-dropdown-menu ms-0">
															<li>
																<div class="dropdown-mega-content mt-3 mt-lg-0">
																	<form class="form-style-3" id="propertiesFormHeader" action="{{route('publicacion_buscar')}}" method="get">
																		<div class="container p-0">
																			<div class="row">
																				<div class="col-lg-10 mb-2 mb-lg-0">
																					<input type="text" name="data" class="form-control search" id="q" placeholder="Buscar..." required>
																				</div>

																				<div class="col-lg-2 mb-2 mb-lg-0">
																					<div class="d-grid gap-2">
																						<button class="btn btn-secondary font-weight-semibold border-0 p-relative bottom-3 text-1 text-uppercase mt-1 btn-px-4 btn-py-2" type="submit">Buscar</button>
																					</div>
																				</div>
																			</div>
																		</div>
																	</form>
																	
																</div>
															</li>
														</ul>
													</li>
													<!-- principio menu logueado -->
													@guest
													<!--
													<li>
														<a class="nav-link" href="{{ url('/login') }}">Ingresar</a>
													</li>
													
														@if (Route::has('register'))
														<li>
															<a class="nav-link" href="{{ route('register') }}"> {{ __('Registrar') }}</a>
														</li>
														@endif
													-->
														@else

													@if ( Auth::user()->user_type()->first()->name == 'Administrador')
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="#">
															Panel
														</a>
														
														<ul class="dropdown-menu">
															<li class="dropdown">
																<a class="dropdown-item" href="{{ route('admin_profesionales') }}"><i class="fa fa-users"> </i>  Profesionales</a>
																<a class="dropdown-item" href="{{ route('statistics') }}"><i class="fa fa-list-ul"></i> Estadísticas</a>
																<a class="dropdown-item" href="{{ route('loans') }}"><i class="fa fa-list-ul"></i> Préstamos</a>
																<a class="dropdown-item" href="{{ route('toolsList') }}"><i class="fa fa-list-ul"></i> Herramientas</a>
																<a href="{{ route('categoria-tipos.index') }}"><i class="fa fa-list"></i> Super Categorías</a>
																<a class="dropdown-item" href="{{ route('admin_categorias') }}"><i class="fa fa-list"></i> Categorías</a>
																<a class="dropdown-item" href="{{ route('titulos.index') }}"><i class="fa fa-list"></i> Títulos</a>
																<!-- <a class="dropdown-item" href="#"><i class="fa fa-list"></i> Títulos</a></li> -->
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#"><i class="fa fa-cog"></i> Sitio</a>
																<ul class="dropdown-menu">
																	<li><a href="{{ route('skins.index') }}"><i class="fa fa-picture-o" aria-hidden="true"></i> Diseño Web</a></li>
																	<li><a href="{{ route('logo.index') }}"><i class="fa fa-picture-o" aria-hidden="true"></i> Logo header</a></li>
																	<li><a href="{{ route('carrusel.index') }}"><i class="fa fa-sliders" aria-hidden="true"></i> Carrusel</a></li>
																	<li><a href="{{ route('SocialNetworks.index') }}"><i class="fa fa-facebook-square" aria-hidden="true"></i> Redes Sociales</a></li>
																	<li><a href="{{ route('contacts.index') }}"><i class="fa fa-address-book" aria-hidden="true"></i> Datos Contacto</a></li>
																	<li><a href="{{ route('links.index') }}"><i class="fa fa-link" aria-hidden="true"></i> Links de interes</a></li>
																	<li><a href="{{ route('aboutus.index') }}"><i class="fa fa-list"></i> Quienes Somos</a></li>
																	<!-- 
																	<li><a href="{{ route('categoria-tipos.index') }}"><i class="fa fa-list"></i> Super Categorias</a></li>
																	<li><a href="{{ route('admin_categorias') }}"><i class="fa fa-list"></i> Categorias</a></li>
																	-->
																</ul>
															</li>
															
														</ul>
													</li>

													@elseif ( Auth::user()->user_type()->first()->name == 'Profesional')
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="#">
															Panel
														</a>
														<ul class="dropdown-menu">
															<li class="dropdown">
																<a href="{{ url('/perfil') }}"><i class="fa-solid fa-user"></i> Mi Perifl </a>
															</li>
															<li class="dropdown">
																<a href="{{ url('/publicacion') }}"><i class="fas fa-book"></i> Mis publicaciones</a>
															</li>
															<li class="dropdown">
																<a href="{{ url('/beneficios') }}"><i class="fa fa-gift"></i> Beneficios</a>
															</li>
															<li class="dropdown">
																<a href="{{ url('/foro') }}"><i class="fa fa-comments"></i> Foro</a>
															</li>
															<li class="dropdown">
																<a href="{{ route('toolsList') }}"><i class="bi bi-tools"></i> Pañol</a>
															</li>
															<li class="dropdown">
																<a href="{{ route('loans') }}"><i class="fa fa-list-ul"></i> Mis préstamos</a>
															</li>
															<!--
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#"><i class="fas fa-tools"></i>  Herramientas</a>
																<ul class="dropdown-menu">
																	<li><a href="{{ url('/perfil') }}"><i class="fa fa-calculator"></i> Mi Perifl </a></li>
																	<li><a href="{{ url('/publicacion') }}"><i class="fa fa-calculator"></i> Mis publicaciones</a></li>
																</ul>
															</li>
														
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#"><i class="fa fa-user"></i>  {{ Auth::user()->name }} </a>
																<ul class="dropdown-menu">
																	<li><a href="{{ url('/clave') }}"><i class="fas fa-key"></i> Contraseña</a></li>
																	<li><a href="{{ route('logout') }}"
																	onclick="event.preventDefault();
																	document.getElementById('logout-form').submit();">
																	<i class="fas fa-sign-out-alt"></i> {{ __('Salir') }}
																	</a></li>
																	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
																		@csrf
																	</form>
																</ul>
															</li>
														-->
														</ul>
													</li>

													</li>
													
													@endif

													<!-- Fin de la vista del autenticado -->
													@endguest

												
													<!-- -- fin de menu logueado-->
												
												
													
												</ul>
											</nav>
										</div>
										<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
											<i class="fas fa-bars"></i>
										</button>
									</div>
									<div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
										<div class="header-nav-feature header-nav-features-search d-inline-flex">
											
											@if ($socialnetwork_all->count() > 0 )
											<ul class="header-social-icons social-icons social-icons-lg d-none d-sm-block social-icons-clean ms-0">
												@foreach ( $socialnetwork_all as $socialnetwork)
												@if ($socialnetwork->name == 'Facebook')
												<li class="social-icons-facebook"><a href="{{$socialnetwork->link}}" target="_blank" title="Facebook"><i class="text-4 fab fa-facebook-f"></i></a></li>
												@endif
												@if ($socialnetwork->name == 'Youtube')
												<li class="social-icons-youtube"><a href="{{$socialnetwork->link}}" target="_blank" title="Twitter"><i class="text-4 fab fa-youtube"></i></a></li>
												@endif
												@if ($socialnetwork->name == 'Instagram')
												<li class="social-icons-instagram"><a href="{{$socialnetwork->link}}/" target="_blank" title="Instagram"><i class="text-4 fab fa-instagram"></i></a></li>
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
			</header>


            @yield('main')


            <footer id="footer">
				<div class="container">
					<div class="row py-5">
						<div class="col text-center">
							
							@if ($socialnetwork_all->count() > 0 )
							<ul class="footer-social-icons social-icons social-icons-clean social-icons-big social-icons-opacity-light social-icons-icon-light mt-1">
								@foreach ( $socialnetwork_all as $socialnetwork)
								@if ($socialnetwork->name == 'Facebook')
								<li class="social-icons-facebook"><a href="{{$socialnetwork->link}}" target="_blank" title="Facebook"><i class="fab fa-facebook-f text-2"></i></a></li>
								@endif
								@if ($socialnetwork->name == 'Youtube')
								<li class="social-icons-youtube"><a href="{{$socialnetwork->link}}" target="_blank" title="Twitter"><i class="fab fa-youtube text-2"></i></a></li>
								@endif
								@if ($socialnetwork->name == 'Instagram')
								<li class="social-icons-instagram"><a href="{{$socialnetwork->link}}" target="_blank" title="Instagram"><i class="text-4 fab fa-instagram"></i></a></li>
								@endif
								@endforeach
							</ul>
							@endif
						
							
						</div>
					</div>
				</div>

				<div class="footer-copyright footer-copyright-style-2">
					<div class="container py-2">
						<div class="row py-4">
							<div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
								<p>
								
									@if ($contact_all->count() > 0)	
									@foreach ($contact_all as $contact)
									@if ($contact->name == 'Dirección')
									<span class="pe-0 pe-md-3 d-block d-md-inline-block"><i class="far fa-dot-circle text-color-primary top-1 p-relative"></i><span class="text-color-light opacity-7 ps-1"> {{$contact->detail }} </span></span>
									@endif
									@if ($contact->name == 'Teléfono')
									<span class="pe-0 pe-md-3 d-block d-md-inline-block"><i class="fab fa-whatsapp text-color-primary top-1 p-relative"></i><a href="tel:1234567890" class="text-color-light opacity-7 ps-1"> {{$contact->detail }} </a></span>
									@endif
									@if ($contact->name == 'Email')
									<span class="pe-0 pe-md-3 d-block d-md-inline-block"><i class="far fa-envelope text-color-primary top-1 p-relative"></i><a href="mailto:info@correo.com.ar" class="text-color-light opacity-7 ps-1"> {{$contact->detail }} </a></span>
									@endif
									@endforeach
									@endif
								
								</p>
							</div>
							<div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end mb-4 mb-lg-0 pt-4 pt-lg-0">
								<p>© Copyright 2023. Diseño por <a href="http://www.tecnoarte.com.ar">TecnoARTE</a>.</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
			</div>
		</div>

<!-- Vendor -->
<script src="{{asset('ipp/vendor/plugins/js/plugins.min.js')}}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset('ipp/js/theme.js')}}"></script>

<!-- Current Page Vendor and Views envio de mensajes-->
<!-- <script src="{{asset('ipp/js/views/view.contact.js')}}"></script> -->

<!-- Demo -->
<script src="{{asset('ipp/js/demos/demo-tecnoarte-cian.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('ipp/js/custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('ipp/js/theme.init.js')}}"></script>

<!--Carrusel de fotos de trabajo de cada profesional -->
<script src="{{asset('ipp/js/examples/examples.gallery.js')}}"></script>	

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZEK93B6CSE"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-ZEK93B6CSE');
	</script>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NDX4K44');</script>
<!-- End Google Tag Manager -->

<!-- Este script bloque el ingeso de letras en imput de whatsapp-->
<script>
function validate(evt) {
	var theEvent = evt || window.event;
  
	// Handle paste
	if (theEvent.type === 'paste') {
		key = event.clipboardData.getData('text/plain');
	} else {
	// Handle key press
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
	}
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
	  theEvent.returnValue = false;
	  if(theEvent.preventDefault) theEvent.preventDefault();
	}
  }
</script>
<!-- Editor de texto en textarea de quienes somos -->
<!-- <script type="text/javascript">
	$(document).ready(function () {
		$('.ckeditor').ckeditor(); -->


@yield('scripts')

</body>
</html>