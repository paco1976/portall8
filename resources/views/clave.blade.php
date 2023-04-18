@extends('layouts.panel')

@section('main')

			<div role="main" class="main">


				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
									<li class="active">Panel de Control</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>MI CLAVE</h1>
							</div>
                            
						</div>
					</div>
				</section>


				<div class="container">

					<div class="row">
						<div class="col-md-12">
							<div class="tabs">
								<ul class="nav nav-tabs">

									<li class="active">
										<a href=""><i class="fa fa-unlock-alt"></i> Contraseña</a>
									</li>

								</ul>


							<div class="tab-content">
								<div id="clave" class="tab-pane active">
									<div class="row">
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

                                            <form action="{{ route('updatepassword') }}" method="POST" enctype="multipart/form-data" >
                                            {{ method_field('PUT') }}
                                                @csrf
                                            <div class="col-md-12">


                                                <div class="col-md-12">
                                                    <!-- <label for="email" >{{ __('Correo Electrónico') }}</label> -->
                                                    <input id="email" type="hidden" class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? old('email') }}" required autocomplete="email" autofocus readonly>

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

                                                    <label for="password" >{{ __('Contraseña') }}</label>
                                                    <input id="password" type="password" class="form-control input-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>

                                                    <div class="col-md-12">
                                                            &nbsp;
                                                    </div>
                                                    <div class="col-md-12">

                                                        <label for="password-confirm">{{ __('Confirmar Contraseña') }}</label>
                                                        <input id="password-confirm" type="password" class="form-control input-lg" name="password_confirmation" required autocomplete="new-password">


                                                    </div>
                                                    <div class="col-md-12">
                                                        &nbsp;
                                                    </div>
                                                    <div class="col-md-12">

                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Confirmar Password') }}
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
