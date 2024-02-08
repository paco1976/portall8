@extends('layouts.home')

@section('main')
    <div role="main" class="main">

        <section
            class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8"
            style="background-image: url({{ asset('img/slides/slide-bg-4.jpg') }}); background-size: cover; background-position: center; min-height: 645px;">
            <div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;">
            </div>
            <div class="container pt-lg-5 mt-5">
                <div class="row pt-3 pb-lg-0 pb-xl-0">
                    <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                        <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                            <li><a href="{{ route('welcome') }}">Inicio</a></li>
                            <li class="text-color-primary"><a href="#">Panel de control</a></li>
                            <li class="text-color-primary"><a href="{{ route('admin_profesionales') }}">Lista de
                                    profesionales</a></li>
                        </ul>
                        <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">{{ $user->name }}
                            {{ $user->last_name }}</h1>
                        <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100"
                            class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar
                            <i class="fas fa-arrow-down ms-1"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <div role="main" class="main" id="ver">

            <div class="container pt-3 pb-2">
                <h2 class="font-weight-normal line-height-1">Datos del profesional</h2>



                <div class="ficha-tecnica">
                    <div class="row pt-2">
                        <div class="col-lg-4">
                            <div class="d-flex justify-content-center mb-4">
                                <div class="profile-image-outer-container">
                                    <div class="profile-image-inner-container bg-color-primary">
                                        @if ($user->avatar == '/img/team/perfil_default.jpg')
                                            <img id="output" src="{{ asset('img/projects/bicicleta.jpg') }}">
                                        @else
                                            <img id="output" src="{{ asset($user->avatar) }}">
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h2>{{ $user->name }} {{ $user->last_name }}
							@if($user->active)
							<i class="fas fa-check-circle" style="color:green; font-size: smaller"></i>
						@else
							<i class="fas fa-times-circle" style="color:red; font-size: smaller"></i>
						@endif
					</h2>
                            <ul>
                                <li>{{ $user->cfp_name($user->cfp_id) }}</li>
                                <li><strong>DNI:</strong> {{ $user->dni }}</li>
                                <li><strong>E-mail:</strong> {{ $user->email }}</li>
                                @if ($user->profile)
                                    <li><strong>Celular:</strong> {{ $user->profile->mobile }}</li>
                                @endif
                                @if ($user->profile)
                                    <li><strong>Twitter:</strong> {{ $user->profile->twitter }}</li>
                                @endif
                                @if ($user->profile)
                                    <li><strong>Facebook:</strong> {{ $user->profile->facebook }}</li>
                                @endif
                                @if ($user->profile)
                                    <li><strong>Instagram:</strong> {{ $user->profile->instagram }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-lg-2">
                            <div class="acciones">
                                <a>Editar</a>
                                <a>Cambiar clave</a>
								<a href="{{ route('admin_user_delete', ['user_hash' => $user->hash, 'origen' => 'profesionales']) }}" onclick="return confirm('¿Está seguro que quiere borrar el usuario y toda su información?')">
									<i class="fas fa-trash-alt button-icon"></i> Eliminar
								</a>
																{{-- Activar / desactivar --}}
                                @if ($user->active == 0)
                                    <a
                                        href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $user->hash, 'origen' => 'profesionales']) }}">Activar</a>
                                @else
                                    <a
                                        href="{{ route('admin_user_aprobar_desaprobar', ['user_hash' => $user->hash, 'origen' => 'profesionales']) }}">Desactivar</a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection
