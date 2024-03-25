@extends('layouts.home')

@section('main')

    <section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
        <div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
        <div class="container pt-lg-5 mt-5">
            <div class="row pt-3 pb-lg-0 pb-xl-0">
                <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                    <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                        <li><a href="index.html">Inicio</a></li>
                        <li class="text-color-primary"><a href="#">Panel de control</a></li>
                        
                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">USUARIO NUEVO</h1>
                    
                    <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
                    
                </div>

            </div>
        </div>
    </section>
    
    
    
    
    
    
<div role="main" class="main" id="ver">

    <div class="container pt-3 pb-2">
<h2 class="font-weight-bold text-5 mb-0">Registro de profesional</h2>
        <div class="row pt-2">
            <div class="col-lg-3 mt-4 mt-lg-0">

                <div class="d-flex justify-content-center mb-4">
                    <div class="profile-image-outer-container">
                        <div class="profile-image-inner-container bg-color-primary">
                            <img id="output" src="{{ asset('img/projects/bicicleta.jpg')}}">
                            <span class="profile-image-button bg-color-dark">
                                <i class="fas fa-camera text-light"></i>
                            </span>
                        </div>
                        
                        <!-- <input type="file" id="file" class="form-control profile-image-input"> -->
                        
                    </div>
                    
                </div>

                

            </div>
            <div class="col-lg-9">
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
                
                <form role="form" class="needs-validation"method="POST" action="{{ route('create_profesional') }}" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Nombre</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Apellido</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Celular</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('mobile') is-invalid @enderror" type="number" name="mobile" value="{{ old('mobile') }}" placeholder="Ej: 1155668899, sin guiones y sin cero delante." required>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">D.N.I.</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('dni') is-invalid @enderror" type="number" name="dni" value="{{ old('dni') }}" placeholder="Sin puntos, Ej: 22111333" required>
                            @error('dni')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">'Imagen de pefil </label>

                        <div class="col-md-6">
                            <input id="avatar" type="file" class="form-control text-3 h-auto py-2 @error('avatar') is-invalid @enderror" name="avatar" value="{{ old('avatar') }}" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"  required>

                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Perfil del Usuario</label>
                        <div class="col-lg-9">
                            <div class="custom-select-1">
                                <select class="form-control text-3 h-auto py-2" name="user_type"  id="subject" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    @foreach ($user_type_all as $user_type)
                                        @if ($user_type->name =='Profesional')
                                        <option value='{{ $user_type->id }}' selected>{{ $user_type->name }}</option>   
                                        @else
                                        <option value='{{ $user_type->id }}'>{{ $user_type->name }}</option> 
                                        @endif
                                    @endforeach
                                </select>

                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">{{ __('CFP') }}</label>
                        <div class="col-lg-9">
                            <div class="custom-select-1">
                                <select class="form-control text-3 h-auto py-2"  name="user_cfp"  id="subject" required>
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($user_cfp_all as $user_cfpx)
                                        <option value='{{ $user_cfpx->id }}'>{{ $user_cfpx->name }}</option>
                                    @endforeach
                                </select>

                                @error('user_cfp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Email</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Contraseña</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('password') is-invalid @enderror" type="password" name="password" value="" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Confirmar Contraseña</label>
                        <div class="col-lg-9">
                            
                            <input id="password-confirm" type="password" class="form-control text-3 h-auto py-2" name="password_confirmation" required autocomplete="new-password">
                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2">Teléfono Fijo</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('name') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2">Facebook</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('name') is-invalid @enderror" type="text" name="facebook" value="{{ old('facebook') }}" >
                            @error('facebook')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2">Instagram</label>
                        <div class="col-lg-9">
                            <input class="form-control text-3 h-auto py-2 @error('name') is-invalid @enderror" type="text" name="instagram" value="{{ old('instagram') }}">
                            @error('instagram')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="form-group col-lg-9">
                            <a href="{{ route('admin_profesionales') }}" class="btn btn-dark btn-modern float-end">VOLVER</a>
                        </div>
                        <div class="form-group col-lg-3">
                            <button type="submit" class="btn btn-primary btn-modern float-end">
                                {{ __('Regsitrar') }}
                            </button>
                        </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

</div>


    
</div>

@endsection
