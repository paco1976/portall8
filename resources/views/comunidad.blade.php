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
					
					<h2 class="font-weight-normal line-height-1">¿Qué es el <strong>portal</strong> Cefeperes?</h2>
						<p class="tall text-justify">
							Cefeperes es una plataforma digital diseñada para facilitar el contacto entre profesionales de los oficios y potenciales clientes. La lista de servicios ofrecidos es variada (se puede consultar acá) y el denominador común es que son egresadas y egresados de escuelas púbicas de formación profesional de nuestra ciudad.
							Impulsado por la red de Centros Públicos de Formación Profesional, el portal no tiene fines de lucro. Su objetivo es propiciar relaciones justas y equilibradas entre trabajadores que ofrecen servicios y clientes. Profesionales que se capacitaron, no solo técnica, sino también humanamente, con criterios de la economía social y valores propios de quienes viven del propio esfuerzo: la cooperación, el apoyo mutuo, la confianza, la sustentabilidad, el precio justo y el trabajo en condiciones de seguridad e higiene y, sobre todo, en armonía con la vida.							
						</p>
					<hr class="tall">
					<h2 class="font-weight-normal line-height-1">¿Qué es la Comunidad <strong>Comunidad</strong> CFP?</h2>
					<p class="tall text-justify">
						Pero el Portal es mucho más que eso. Es una Comunidad: un espacio de cruces y encuentros entre profesionales egresados, docentes, vecinxs y amigxs. Un lugar común donde practicar formas de intercambio justos, bajo criterios colaborativos. Un espacio para construir redes y alianzas. <br>
Formar parte de la Comunidad CFP implica una serie de responsabilidades éticas para los profesionales egresados:<br>
&#8226;&nbsp;La seriedad y responsabilidad en las tareas.<br>
&#8226;&nbsp;La sensatez y honestidad en los presupuestos.<br>
&#8226;&nbsp;La amabilidad y respeto en el trato a compañeras/os de trabajo y a clientes/as.<br>
&#8226;&nbsp;La capacitación y actualización en técnicas, herramientas y materiales.<br>
&#8226;&nbsp;La predisposición a compartir los saberes.<br>
Estas responsabilidades éticas de los profesionales egresados posibilitan que los vecinos clientes pueden resolver sus demandas con:<br>
&#8226;&nbsp;Profesionales certificados por los Centros de Formación Profesional públicos de la ciudad de Buenos Aires.<br>
&#8226;&nbsp;La confianza de contratar a un profesional que forma parte de una red más amplia.<br>
&#8226;&nbsp;La garantía de contar con un presupuesto claro y un precio justo.<br>
&#8226;&nbsp;La posibilidad de que se le realice un trabajo en condiciones de seguridad e higiene.<br>
&#8226;&nbsp;La certeza de poder entablar un buen trato con el profesional que lo visite.<br>
A su vez, contratando profesionales egresadas/os de los CFP el vecino contribuye con el crecimiento de estos espacios de formación pública y de vínculo comunitario.<br>
Para los profesionales egresados, formar parte de la Comunidad del portal supone una serie de beneficios:<br>
&#8226;&nbsp;Asesoramiento técnico-profesional coordinados por el cuerpo docente.<br>
&#8226;&nbsp;Video-tutoriales y participación en foros de resolución de problemas propios del oficio.<br>
&#8226;&nbsp;Capacitaciones (en distintos aspectos que favorezcan la inserción laboral: presupuestos; en cuestiones tributarias, legales y de seguridad e higiene; uso de productos y herramientas nuevos, en las funciones del Portal, trato con clientes).<br>
&#8226;&nbsp;Uso del panel de herramientas comunes.<br>
&#8226;&nbsp;Acceso a promociones y beneficios en la compra de insumos y herramientas.<br>
					</p>
					<hr class="tall">
					<h2 class="font-weight-normal line-height-1">¿Qué son los CFP <strong>públicos</strong>?</h2>
					<p class="lead">
						<p class="tall text-justify">
							Los Centro de Formación Profesional (CFP) son escuelas públicas de la ciudad de Buenos Aires que capacitan gratuitamente a jóvenes y adultos en oficios. Basados en trayectos formativos de alrededor de dos año, los CFP capacitan en construcción, electricidad, plomería y gas, gastronomía, peluquería y estética, informática y programación, mecánica automotriz, energía renovables, entre muchas otras áreas.
							La transmisión de los saberes y reglas de cada oficios –actualizada en nuestras escuelas mediante el uso de tecnologías y herramientas digitales– hunde sus raíces en la relación entre el maestro artesano y el aprendiz. En nuestro país, esta función pedagógica se institucionalizó a mediados del siglo anterior, de la mano de proyectos de tinte industrialista, primero, y desarrollistas, después. De ese recorrido se nutren nuestras instituciones educativas, caracterizadas en el presente por la calidad y diversidad de sus cursos y por sus activas comunidades educativas.
						</p>
					<hr class="tall">
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
