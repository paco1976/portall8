<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Basic -->
		<meta charset="utf-8">
		<!--<meta http-equiv="refresh" content="900">-->
        <!-- <title>{{ config('app.name', 'Portal') }}</title> -->
		<title>CEFEPERES - Servicios Profesionales de egresados de CFP</title>
		<meta name="keywords" content="CEFEPERES, Servicios Profesionales, Carpintero, Electricista, Aire Acondicionado, Maquillaje, Estética, Herrero, Peluquería, Video, Sonido, Diseño, Marroquinería, Plomero, Tècnico" />
		<meta name="description" content="CEFEPERES - CONTACTÁ PROFESIONALES CON CERTIFICACIÓN OFICIAL EN TU BARRIO. Responsabilidad, confianza y precios justos">
		<meta name="author" content="TecnoARTE">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Whatsapp -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/whatsapp.css') }}">

		<!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/owlcarousel/owl.carousel.min.css') }}" media="screen">
        <link rel="stylesheet" href="{{ asset('vendor/owlcarousel/owl.theme.default.min.css') }}" media="screen">
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

	</head>
	<body>

		<div class="body">
			<header id="header">
				<div class="container">
					<div class="logo">
						<a href="{{ url('/') }}">
							<img alt="CFP" width="278" height="67" data-sticky-width="227" data-sticky-height="55" src="{{ url('img/logo.png') }}">
						</a>
					</div>

					<div class="search">
					<form id="searchForm" action="{{route('publicacion_buscar')}}" method="get">
							<div class="input-group">
								<input type="text" name="description" class="form-control search" name="q" id="q" placeholder="Buscar..." required>
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
									<a href="{{ url('/') }}"> Inicio</a> <!--<i class="fa fa-home"> </i>-->
								</li>



								<li class="dropdown active">
									<a class="dropdown-toggle" href="">
										Servicios
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu">
                                    @foreach($categoria_servicios_all as $categoria)
                                        <li><a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }} ">{{ $categoria->name }}</a></li>
                                    @endforeach

									</ul>
                                </li>
								<!--
                                <li class="dropdown active">
                                    <a class="dropdown-toggle" href="">
                                        Productos
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                    @foreach($categoria_productos_all as $categoria)
                                        <li><a href="{{ route('homepublicaciones', ['id'=> $categoria->id]) }}">{{ $categoria->name }}</a></li>
                                    @endforeach

                                    </ul>
                                </li>
								-->
								<li>
									<a href="{{ url('/comunidad') }}">comunidad CFP</a>
								</li>
								<li>
									<a href="{{ url('/contacto') }}">Contacto</a>
								</li>



                @guest
                <li>

                    <a href="{{ url('/login') }}">Ingresar</a>
                </li>


                    @else

                <li class="dropdown">
                    <a class="dropdown-toggle" href="">
                        <i class="fa fa-sign-out"></i> {{ Auth::user()->name }}
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/perfil') }}">Mi Panel</a></li>
                        <li><a href="{{ url('/clave') }}">Contraseña</a></li>
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
                </li>



                <!-- Fin de la vista del autenticado -->
                @endguest

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
						<div class="footer-ribbon">
							<span>Estemos en contacto</span>
						</div>
						<div class="col-md-6">
							<div class="newsletter">
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
							</div>
						</div>

						<div class="col-md-4">
							<div class="contact-details">
								<h4>Contacto</h4>
								<ul class="contact">
									<li><p><i class="fa fa-map-marker"></i> <strong>Dirección:</strong> Morón 2453. Flores, CABA</p></li>
									<li><p><i class="fa fa-phone"></i> <strong>Telefono:</strong> 1125274751 </p></li>
									<li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@serviciosprofesionales.com.ar">info@cefeperes.com.ar</a></p></li>
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
								<p><a href="http://www.tecnoarte.com.ar" target="_blank"><img src="{{ url('tecnoarte.png') }}" alt="logo" width="118" height="16"></a></p>
							</div>
							<div class="col-md-4">
								<nav id="sub-menu">
									<ul>
										<li><a href="http://cfp24.com.ar/">Desarrollado x CFP 24</a></li>
										<li><a href="{{ url('/condiciones') }}">Condiciones de uso</a></li>
										<li><a href="{{ url('/contacto') }}">Contacto</a></li>
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

		 

	</body>
</html>
