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
                        <li class="text-color-primary"><a href="{{route('perfil')}}">Perfil</a></li>
                        
                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">CAMBIO DE CONTRASEÑA</h1>
                    
                    <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
                    
                    
                </div>

            </div>
        </div>
    </section>
    
    
    
    
<div role="main" class="main" id="ver">
    
    <div class="container pt-3 pb-2">
        <h2 class="font-weight-bold text-5 mb-0">Contraseña</h2>
        <div class="row pt-2">
            <div class="col-lg-3 mt-4 mt-lg-0">

                <div class="d-flex justify-content-center mb-4">
                    <div class="profile-image-outer-container">
                        <div class="profile-image-inner-container bg-color-primary">
                            <img src="{{ $user_prof->avatar }}">
                           
                        </div>
                        
                    </div>
                </div>

                

            </div>
            <div class="col-lg-9">
                <h3> Profesional {{ $user_prof->name }} {{ $user_prof->last_name }}</h3>
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
                            
                <form class="needs-validation" action="{{ route('updatepass_prof') }}" method="POST" enctype="multipart/form-data" >
                    {{ method_field('PUT') }}
                        @csrf
                    
                    <input id="email" type="hidden" class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ $user_prof->email ?? old('email') }}" required autocomplete="email" autofocus readonly>
                    

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label line-height-9 pt-2 text-2 required">Contraseña</label>
                        <div class="col-lg-9">
                            
                            <input id="password" type="password" class="form-control text-3 h-auto py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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
                        <div class="form-group col-lg-9">
                            <a href="{{ url()->previous() }}" class="btn btn-dark btn-modern float-end">CANCELAR</a>
                        </div>
                        <div class="form-group col-lg-3">
                            
                            <button type="submit" class="btn btn-primary btn-modern float-end">
                                {{ __('Confirmar Password') }}
                            </button>
                            
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

</div>




    
</div>
@endsection
