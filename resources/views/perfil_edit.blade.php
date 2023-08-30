@extends('layouts.home')

@section('main')

<div role="main" class="main">

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
                        <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">PERFIL EDICION</h1>
                        
                        <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">VER <i class="fas fa-arrow-down ms-1"></i></a>
                        
                    </div>

                </div>
            </div>
        </section>
        
        
        
        <div role="main" class="main" id="ver">

            <div class="container pt-3 pb-2">

                <h2 class="font-weight-normal line-height-1">Hola, <strong class="font-weight-extra-bold">{{ $user->name }} {{ $user->last_name }}</strong></h2>
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
                                    @if ($user->avatar == '/img/team/perfil_default.jpg')
                                    <img id="output" src="{{ asset('img/projects/bicicleta.jpg')}}">
                                    @else
                                    <img id="output" src="{{ asset($user->avatar) }}">
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
                                <li class="nav-item"><a class="nav-link text-3 text-dark active" href="{{route('perfil')}}">Mi Perfil</a></li>
                                @if ($user_profile)
                                <li class="nav-item"><a class="nav-link text-3" href="{{ route('publicacion') }}">Publicaciones</a></li>
                                @endif
                                <!--<li class="nav-item"><a class="nav-link text-3" href="#">Mensajes</a></li> -->
                                <!-- <li class="nav-item"><a class="nav-link text-3" href="{{ url('/clave') }}">Contraseña</a></li>-->
                                <!--<li class="nav-item"><a class="nav-link text-3" href="#">Salir</a></li>-->
                            </ul>
                        </aside>

                    </div>
                    <div class="col-lg-9">

                        <form role="form" class="needs-validation" action="{{ route('perfil_update') }}" method="post" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            @csrf

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Nombre (*)</label>
                                <div class="col-lg-9">
                                    <input class="form-control text-3 h-auto py-2 @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $user->name ) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Apellido (*)</label>
                                <div class="col-lg-9">
                                    <input class="form-control text-3 h-auto py-2 @error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{ old('last_name', $user->last_name ) }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Email (*)</label>
                                <div class="col-lg-9">
                                    <input class="form-control text-3 h-auto py-2 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $user->email ) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Celular (*)</label>
                                <div class="col-lg-9">
                                    <input class="form-control text-3 h-auto py-2" type="number" name="mobile" placeholder="Ej: 1155668899, sin guiones y sin cero delante." value="{{ old('mobile',$user->profile()->first()->mobile) }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">D.N.I. (*)</label>
                                <div class="col-lg-9">
                                    <input class="form-control text-3 h-auto py-2 @error('dni') is-invalid @enderror" type="number" name="dni" value="{{ old('dni', $user->dni) }}" placeholder="Sin puntos, Ej: 22111333" required>
                                    @error('dni')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">{{ __('Imagen de pefil') }} </label>
        
                                <div class="col-md-6">
                                    <input id="avatar" type="file" class="form-control text-3 h-auto py-2 @error('avatar') is-invalid @enderror" name="avatar" value="{{ old('avatar') }}" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 ">Teléfono fijo</label>
                                <div class="col-lg-9">
                                    <input class="form-control text-3 h-auto py-2" type="number" name="phone" value="{{ old('phone',$user->profile()->first()->phone ) }}">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2">Facebook</label>
                                <div class="col-lg-9">
                                    <input class="form-control text-3 h-auto py-2 @error('name') is-invalid @enderror" type="text" name="facebook" value="{{ old('facebook',$user->profile()->first()->facebook ) }}" >
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
                                    <input class="form-control text-3 h-auto py-2 @error('name') is-invalid @enderror" type="text" name="instagram" value="{{ old('instagram',$user->profile()->first()->instagram) }}">
                                    @error('instagram')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                                                        

                            
                            <div class="form-group row">
                                <div class="form-group col-lg-9">
                                    <a href="{{route('perfil')}}"" class="btn btn-dark btn-modern float-end" data-loading-text="Cargando...">Volver</a>
                                </div>
                                <div class="form-group col-lg-3">
                                    <button type="submit" value="Guardar Cambios" class="btn btn-primary btn-modern float-end" data-loading-text="Cargando...">Guardar </button>
                                </div>
                            </div>
                        </form>

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
