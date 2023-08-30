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
                        <li class="text-color-primary"><a href="#"> </a></li>
                        
                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Recuperar Contraseña</h1>
                    
                    <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
                    
                </div>

            </div>
        </div>
    </section>
    
    
    
    
    
    
    <div role="main" class="main" id="ver">
				<div class="container">

					<div class="row">
						<div class="col-md-12">
							<div class="tabs">
								<ul class="nav nav-tabs">

									<li class="active">
                                        <h2 class="font-weight-bold text-5 mb-0">INGRESÁ TU Email</h2>
									</li>

								</ul>


							<div class="tab-content">
								<div id="clave" class="tab-pane active">
									<div class="row">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
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

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                            <div class="col-md-12">


                                                <div class="col-md-12">
                                                    <!-- <label for="email" >{{ __('Correo Electrónico') }}</label> -->
                                                    <!-- <input id="email" type="hidden" class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? old('email') }}" required autocomplete="email" autofocus readonly> -->


                                                    <input id="email" type="email" class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>
                                                <div class="col-md-12">
                                                        &nbsp;
                                                </div>
                                                

                                                    <div class="col-md-12">
                                                            &nbsp;
                                                    </div>
                                                   
                                                    <div class="col-md-12">
                                                        &nbsp;
                                                    </div>
                                                    <div class="col-md-12">

                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Enviar link reset password') }}
                                                    </button>
                                                    </div>


                                            <br>
                                            </div>

									</div>
								</div>
                            </div>
                        </div>
                	</div>
				</div>
			</div>

@endsection
