@extends('layouts.home')

@section('main')



    <div role="main" class="main">

        <section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
            <div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
            <div class="container pt-lg-5 mt-5">
                <div class="row pt-3 pb-lg-0 pb-xl-0">
                    <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                        <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                            <li><a href="{{route('welcome')}}">Inicio</a></li>
                            <li class="text-color-primary"><a href="#">Panel de control</a></li>
                            
                        </ul>
                        <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">ADMINISTRACIÓN</h1>
                        
                        <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">VER <i class="fas fa-arrow-down ms-1"></i></a>
                        
                    </div>

                </div>
            </div>
        </section>
        
        
        
        <div role="main" class="main" id="ver">

            <div class="container pt-3 pb-2">

                <h2 class="font-weight-normal line-height-1">Hola, <strong class="font-weight-extra-bold"> {{ Auth::user()->name}} {{ Auth::user()->last_name }}</strong></h2>
                @if (Session::has('message'))
                <div class="alert alert-success">
                    <p>{{ Session::get('message') }}</p>
                </div>
                @endif
                <div class="row pt-2">
                    <div class="col-lg-3 mt-4 mt-lg-0">

                        <div class="d-flex justify-content-center mb-4">
                            <div class="profile-image-outer-container">
                                <div class="profile-image-inner-container bg-color-primary">
                                    @if ( Auth::user()->avatar  == '/img/team/perfil_default.jpg')
                                    <img id="output" src="{{ asset('img/projects/bicicleta.jpg')}}">
                                    @else
                                    <img id="output" src="{{ asset('storage/avatares/'. Auth::user()->avatar) }}">
                                    @endif

                                    <span class="profile-image-button bg-color-dark">
                                        <i class="fas fa-camera text-light"></i>
                                    </span>
                                </div>
                                <form action="{{ route('avatarupload') }}" method="POST" enctype="multipart/form-data" >
                                    {{ method_field('PUT') }}
                                    @csrf
                                    <br>
                                    <input type="file" id="file" name="avatar" class="form-control profile-image-input" accept='image/*' onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required>
                                    <!-- <button type="submit" class="btn btn-default fileupload-new">Subir imagen</button>
                                    <a href="#" class="btn btn-default fileupload-new" data-dismiss="fileupload">Subir imagen</a> -->
                                
                                
                            </div>
                            
                        </div>

                        
                        
                        
                        <aside class="sidebar mt-2" id="sidebar">
                            
                            
                            <ul class="nav nav-list flex-column mb-5">
                                <button type="submit" class="btn btn-primary btn-modern float-end mb-4" data-dismiss="fileupload">Subir imagen</button>
                                <!-- <a href="{{ route('avatardelete') }}" class="btn btn-primary btn-modern float-end mb-4" data-dismiss="fileupload">Borrar imagen</a> -->
                                </form>
                                <!--
                                <input type="submit" value="borrar imagen" class="btn btn-primary btn-modern float-end mb-4" data-loading-text="Cargando...">
                                -->
                                <li class="nav-item"><a class="nav-link text-3 text-dark active" href="#"><i class="fa-solid fa-user"></i> Mi Perfil</a></li>
                                <li class="nav-item"><a class="nav-link text-3" href="{{ route('admin_profesionales') }}"><i class="fa fa-users"></i> Profesionales</a></li>
                                <li class="nav-item"><a class="nav-link text-3" href="{{ route('admin_publicaciones') }}"><i class="fa fa-list-ul"></i> Publicaciones</a></li>
								<!--<li class="nav-item"><a class="nav-link text-3" href="{{ route('admin_publicaciones') }}"><i class="fa fa-list-ul"></i> Publiaciones</a></li>-->
                                <li class="nav-item"><a class="nav-link text-3" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Salir') }}
                                    </a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                <!--<li class="nav-item"><a class="nav-link text-3" href="#">Mensajes</a></li> -->
                                <!-- <li class="nav-item"><a class="nav-link text-3" href="{{ url('/clave') }}">Contraseña</a></li>-->
                                <!--<li class="nav-item"><a class="nav-link text-3" href="#">Salir</a></li>-->
                            </ul>
                        </aside>

                    </div>
                    <div class="col-lg-9">
                        <p class="h1">Bienvenido/a  al {{ config('app.name') }} </p>
                        <p class="lead">
                        <hr>
                        </p>
                        <p> Se encuentra en el panel de administración del sitio web. Desde aquí puede configurar parámetros de la aplicación web entrando a la opción “Sitio” que se encuentra en el menú. Por otro lado, 
                        ingresando a la opción "Herramientas", puede encontrar todo lo referido a los profesionales y a las publicaciones. Si necesita cambiar su contraseña debe ingresar al menú que 
                        lleva su nombre para luego entrar en contraseña.
                        </p>
                        <p class="lead">
                        <hr>
                        </p>
                        

							
						<div class="row counters with-borders">
							<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
								<div class="counter counter-primary appear-animation animated bounceIn appear-animation-visible" data-appear-animation="bounceIn" data-appear-animation-delay="300" style="animation-delay: 300ms;">
									<i class="fas fa-pen"></i>
									<strong data-to="{{ $publicaciones}}">{{ $publicaciones}}</strong>
									<label><a href="#">Publicaciones Registradas</a></label>
								</div>
							</div>
							<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
								<div class="counter counter-primary appear-animation animated bounceIn appear-animation-visible" data-appear-animation="bounceIn" data-appear-animation-delay="600" style="animation-delay: 600ms;">
									<i class="fas fa-message"></i>
									<strong data-to="{{$mensajes}}">{{$mensajes}}</strong>
									<label><a href="#">Mensajes WEB</a></label>
								</div>
							</div>
							<div class="col-sm-6 col-lg-3 mb-4 mb-sm-0">
								<div class="counter counter-primary appear-animation animated bounceIn appear-animation-visible" data-appear-animation="bounceIn" data-appear-animation-delay="900" style="animation-delay: 900ms;">
									<i class="fas fa-chart-bar"></i>
									<strong data-to="{{$whatsapp}}">{{$whatsapp}}</strong>
									<label><a href="#">Mensajes WhatsApp</a></label>
								</div>
							</div>
							<div class="col-sm-6 col-lg-3">
								<div class="counter counter-primary appear-animation animated bounceIn appear-animation-visible" data-appear-animation="bounceIn" data-appear-animation-delay="1200" style="animation-delay: 1200ms;">
									<i class="far fa-eye"></i>
									<strong data-to="{{$visitas}}">{{$visitas}}</strong>
									<label><a href="#">Visitas Recibidas</a></label>
								</div>
							</div>
						</div>
						
						<!--
						<div class="col-lg-12">
							<div class="progress-bars mt-4">
								<div class="progress-label">
									<label><a href="#">Publicaciones</a></label>
								</div>
								<div class="progress mb-2">
									<div class="progress-bar progress-bar-primary" data-appear-progress-animation="70%" style="width: 50%;">
										<span class="progress-bar-tooltip" style="opacity: 1;">120</span>
									</div>
								</div>
								<div class="progress-label">
									<label><a href="#">Mensajes</a></label>
								</div>
								<div class="progress mb-2">
									<div class="progress-bar progress-bar-secondary" data-appear-progress-animation="75%" data-appear-animation-delay="300" style="width: 70%;">
										<span class="progress-bar-tooltip" style="opacity: 1;">15</span>
									</div>
								</div>
								<div class="progress-label">
									<label><a href="#">Categorias</a></label>
								</div>
								<div class="progress mb-2">
									<div class="progress-bar progress-bar-tertiary" data-appear-progress-animation="40%" data-appear-animation-delay="600" style="width: 75%;">
										<span class="progress-bar-tooltip" style="opacity: 1;">32</span>
									</div>
								</div>
								<div class="progress-label">
									<label><a href="#">Visitas</a></label>
								</div>
								<div class="progress mb-2">
									<div class="progress-bar progress-bar-danger" data-appear-progress-animation="80%" data-appear-animation-delay="900" style="width: 80%;">
										<span class="progress-bar-tooltip" style="opacity: 1;">140</span>
									</div>
								</div>
							</div>
						</div>
                    -->

                    </div>
                </div>

            </div>

        </div>

        
            
    
            
        </div>
        

        


        </div>






    </div>

</div>
</div>

@endsection
