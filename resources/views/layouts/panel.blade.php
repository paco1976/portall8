<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>

		<!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Basic -->
		<meta charset="utf-8">
		<!-- <meta http-equiv="refresh" content="900"> -->
        <title>{{ config('app.name', 'Portal') }}</title>
		<meta name="keywords" content="CEFEPERES, Servicios Profesionales, Carpintero, Electricista, Aire Acondicionado, Maquillaje, Estética, Herrero, Peluquería, Video, Sonido, Diseño, Marroquinería, Plomero, Tècnico" />
		<meta name="description" content="CEFEPERES - CONTACTÁ PROFESIONALES CON CERTIFICACIÓN OFICIAL EN TU BARRIO. Responsabilidad, confianza y precios justos">
		<meta name="author" content="TecnoARTE">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/font-awesome.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor/owlcarousel/owl.carousel.min.css') }}" media="screen">
		<link rel="stylesheet" href="{{ asset('img/vendor/owlcarousel/owl.theme.default.min.css') }}" media="screen">
		<link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}" media="screen">
		<!-- para ver las imagenes de la mensajería -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
		<link rel="stylesheet" href="{{ asset('css/theme-elements.css') }}">
		<link rel="stylesheet" href="{{ asset('css/theme-blog.css') }}">
		<link rel="stylesheet" href="{{ asset('css/theme-shop.css') }}">
		<link rel="stylesheet" href="{{ asset('css/theme-animate.css') }}">
		<link rel="stylesheet" href="{{ asset('css/datos_profesional.css') }}">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="{{ asset('vendor/rs-plugin/css/settings.css') }}" media="screen">
		<link rel="stylesheet" href="{{ asset('vendor/circle-flip-slideshow/css/component.css') }}" media="screen">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="{{ asset('css/skins/default.css') }}">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

		<!-- Head Libs -->
        <script src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>


		<!--[if IE]>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="vendor/respond/respond.js"></script>
			<script src="vendor/excanvas/excanvas.js"></script>
		<![endif]-->
		<script>
		function toggle(source) {
			var checkboxes = document.querySelectorAll('input[type="checkbox"]');
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i] != source)
					checkboxes[i].checked = source.checked;
			}
		}
		</script>

	</head>
	<body>

		<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDX4K44"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

		<div class="body">
			<header id="header">
				<div class="container">
					<div class="logo">
						<a href="{{ url('/') }}">
							<img alt="CFP" width="278" height="67" data-sticky-width="227" data-sticky-height="55" src="https://www.serviciosprofesionales.com.ar/img/logo.png">
						</a>
					</div>

					<div class="search">
						<form id="searchForm" action="../page-search-results.html" method="get">
							<div class="input-group">
								<input type="text" class="form-control search" name="q" id="q" placeholder="Buscar..." required>
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>
					</div>

					<ul class="social-icons">
						<li class="facebook"><a href="https://www.facebook.com/Cefeperes/" target="_blank" title="Facebook">Facebook</a></li>
						<!--
						<li class="instagram"><a href="https://www.instagram.com/" target="_blank" title="Instagram">Instagram</a></li>
						<li class="linkedin"><a href="https://www.linkedin.com/" target="_blank" title="Linkedin">Linkedin</a></li>
						-->
					</ul>

					<button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
						<i class="fa fa-bars"></i>
					</button>
                </div>

				<div class="navbar-collapse nav-main-collapse collapse">
					<div class="container">
						<nav class="nav-main mega-menu">
							<ul class="nav nav-pills nav-main" id="mainMenu">
								<li>
									<a href="{{ url('/perfil') }}"><i class="fa fa-user"></i> Inicio</a>
								</li>
								<!--
								<li>
									<a href="{{ url('/interacciones') }}"><i class="fa fa-comments-o"></i> Interacciones</a>
								</li>
								-->

								<li class="dropdown active">
									<a class="dropdown-toggle" href="#">
										<i class="fa fa-comments"></i> Panel de control
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">

										 <li><a href="{{ url('/tarifario') }}"><i class="fa fa-calculator"></i> Tarifarios</a></li>
										 <li><a href="{{ url('/beneficios') }}"><i class="fa fa-gift"></i> Beneficios</a></li>
										 <li><a href="{{ url('/foro') }}"><i class="fa fa-comments"></i> Foro</a></li>
									<!-- <li><a href="../panel.html"><i class="fa fa-wrench"></i> Panel</a></li>			-->
									</ul>
								</li>




								<li class="dropdown mega-menu-item mega-menu-signin signin logged" id="headerAccount">
									<a class="dropdown-toggle" href="#">
										<i class="fa fa-sign-out"></i> {{ Auth::user()->name }}
										<i class="fa fa-angle-down"></i>
                                    </a>

									<ul class="dropdown-menu">
										<li>
											<div class="mega-menu-content">
												<div class="row">
													<div class="col-md-8">
														<div class="user-avatar">

															<div class="img-thumbnail">

                                                                @if (!Auth::user()->avatar)
                                                                    <img src="{{ url('/img/team/perfil_default.jpg') }}" alt="">
                                                                @else

                                                                    <!--<img src="{{ asset(Auth::user()->avatar) }}"/>-->
																	<img src="{{ asset($user->avatar) }}"/>
                                                                @endif


															</div>
															<p><strong>{{ Auth::user()->name }}</strong><span>{{ Auth::user()->last_name }}</span></p>
														</div>
													</div>
													<div class="col-md-4">
														<ul class="list-account-options">
															<li>
																<a href="{{ url('/perfil') }}">Mi Panel</a>
															</li>
															<li>
																<a href="{{ url('/clave') }}">Contraseña</a>
															</li>
															<li>

                                                                <a href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();
                                                                                document.getElementById('logout-form').submit();">
                                                                    {{ __('Salir') }}
                                                                </a>

                                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                    @csrf
                                                                </form>

															</li>
														</ul>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</li>




							</ul>
						</nav>
					</div>
				</div>
            </header>

            @yield('main')


            <footer id="footer">
				<div class="container">
					<div class="row">
						<!--
						<div class="footer-ribbon">
							<span>Estemos en contacto</span> 
						</div>
					-->
					<div class="col-md-6">
						<div class="newsletter">
							<h4>Red de CFP´s:</h4>
							<p>
								<a href="https://www.facebook.com/cfp.nro1/" target="_blank"><strong> CFP N° 01</strong> / Río Cuarto 1993, C1295 CABA Teléfono: 4301-8678 </a><br>
								<a href="https://www.facebook.com/cfpcuatro/" target="_blank"><strong> CFP N° 04 </strong>/ Carhué 2970, C1440ERF CABA Teléfono: 4686-2196</a>  <br>
								<a href="https://www.educaedu.com.ar/centros/centro-de-formacion-profesional-n-6-para-adoles-y-adultos--cifpa-uni2292" target="_blank"> <strong> CFP N° 06 </strong>/ Av. Asamblea 153, C1424COB CABA Teléfono: 4922-3683 </a><br>
								<a href="https://centrosiete.wixsite.com/centro-siete?fbclid=IwAR3be32wBMSf1fQe75r5JqrlF19J7oaMm9HpkDsQAGoJPpmX4d4Rhzfnwbk" target="_blank"><strong> CFP N° 07 </strong>/ Ramsay 2250, C1428BAJ CABA Teléfono: 011 4783-8725 </a><br>
								<a href="https://www.facebook.com/PoloEducativoBarracas" target="_blank"><strong> CFP N° 09 </strong>/ Av. Gral. Iriarte 3400, C1437 CABA Teléfono:  </a><br>
								<a href="https://cfp24.com.ar/" target="_blank"><strong> CFP N° 24 </strong>/ Morón 2538, C1406FVF CABA Teléfono: 011 4611-5374 </a><br>
								<a href="https://www.cfp36caba.edu.ar/" target="_blank"><strong> CFP N° 36 </strong>/ Zavaleta 204, Parque Patricios, CABA Teléfono: 4912-3792 </a>
							</p>


							<!--
							<h4>Newsletter</h4>
							<p>Manténgase al día con nuestras características y tecnología de productos en constante evolución. Ingrese su correo electrónico y suscríbase a nuestro boletín.</p>
							
							<div class="alert alert-success hidden" id="newsletterSuccess">
								<strong>¡Éxito!</strong> Te han agregado a nuestra lista de correo electrónico.
							</div>

							<div class="alert alert-danger hidden" id="newsletterError"></div>

							<form id="newsletterForm" action="php/newsletter-subscribe.php" method="POST">
								<div class="input-group">
									<input class="form-control" placeholder="Dirección de correo" name="newsletterEmail" id="newsletterEmail" type="text">
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit">Ir!</button>
									</span>
								</div>
							</form>
						-->
						</div>
					</div>

						<div class="col-md-4">
							<div class="contact-details">
								<h4>Contacto</h4>
								<ul class="contact">
									<li><p><i class="fa fa-map-marker"></i> <strong>Dirección:</strong> Morón 2453. Flores, CABA</p></li>
									<li><p><i class="fa fa-phone"></i> <strong>Telefono:</strong> 1125274751 </p></li>
									<li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@cefeperes.com.ar">info@cefeperes.com.ar</a></p></li>
								</ul>
							</div>
						</div>
						<div class="col-md-2">
							<h4>Seguinos</h4>
							<div class="social-icons">
								<ul class="social-icons">
									<li class="facebook"><a href="https://www.facebook.com/Cefeperes/" target="_blank" data-placement="bottom" data-tooltip title="Facebook">Facebook</a></li>
									<!--
									<li class="instagram"><a href="http://www.instagram.com/" target="_blank" data-placement="bottom" data-tooltip title="Instagram">Instagram</a></li>
									<li class="linkedin"><a href="http://www.linkedin.com/" target="_blank" data-placement="bottom" data-tooltip title="Linkedin">Linkedin</a></li>
									-->
								</ul>

							</div>

						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<p><a href="http://www.tecnoarte.com.ar" target="_blank"><img src="https://www.serviciosprofesionales.com.ar/tecnoarte.png" alt="logo" width="118" height="16"></a></p>
							</div>
							<div class="col-md-4">
								<nav id="sub-menu">
									<ul>
										<li><a href="http://cfp24.com.ar/">Desarrollado x CFP 24</a></li>
										<li><a href="{{ asset('/condiciones') }}">Condiciones de uso</a></li>
										<li><a href="{{ asset('/contacto') }}">Contacto</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

        <!-- Vendor -->
        <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('vendor/jquery.appear/jquery.appear.js') }}"></script>
        <script src="{{ asset('vendor/jquery.easing/jquery.easing.js') }}"></script>
        <script src="{{ asset('vendor/jquery-cookie/jquery-cookie.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/bootstrap.js') }}"></script>
        <script src="{{ asset('vendor/common/common.js') }}"></script>
        <script src="{{ asset('vendor/jquery.validation/jquery.validation.js') }}"></script>
        <script src="{{ asset('vendor/jquery.stellar/jquery.stellar.js') }}"></script>
        <script src="{{ asset('vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
        <script src="{{ asset('vendor/jquery.gmap/jquery.gmap.js') }}"></script>
        <script src="{{ asset('vendor/isotope/jquery.isotope.js') }}"></script>
        <script src="{{ asset('vendor/owlcarousel/owl.carousel.js') }}"></script>
        <script src="{{ asset('vendor/jflickrfeed/jflickrfeed.js') }}"></script>
        <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('vendor/vide/vide.js') }}"></script>
		<script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
		
		<!-- Paco -->
		<script src="{{ asset('js/datos_profesional.js') }}"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="{{ asset('js/theme.js') }}"></script>

        <!-- Specific Page Vendor and Views -->
        <script src="{{ asset('vendor/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
        <script src="{{ asset('vendor/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
        <script src="{{ asset('vendor/circle-flip-slideshow/js/jquery.flipshow.js') }}"></script>
        <script src="{{ asset('js/views/view.home.js') }}"></script>

        <!-- Theme Custom -->
        <script src="{{ asset('js/custom.js') }}"></script>

        <!-- Theme Initialization Files -->
        <script src="{{ asset('js/theme.init.js') }}"></script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-12345678-1']);
			_gaq.push(['_trackPageview']);

			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();

		</script>
		 -->
		 <!-- Global site tag (gtag.js) - Google Analytics old -->
		<!--
		 <script async src="https://www.googletagmanager.com/gtag/js?id=G-0FM2CN3R42"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-0FM2CN3R42');
		</script>
	 	-->
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
	</body>
</html>

