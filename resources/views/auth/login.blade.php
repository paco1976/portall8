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
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">INGRESO</h1>
                    
                    <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ingresar <i class="fas fa-arrow-down ms-1"></i></a>
                    
                </div>

            </div>
        </div>
    </section>
    
    
    
    
    
    
<div role="main" class="main" id="ver">

    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 mb-5 mb-lg-0">
                <h2 class="font-weight-bold text-5 mb-0">INGRESÁ TUS DATOS</h2>
                <form method="POST" action="{{ route('login') }}" class="needs-validation">
                    @csrf
                    <div class="row">
                        <div class="form-group col">
                            <label class="form-label text-color-dark text-3">Correo electrónico <span class="text-color-danger">*</span></label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control form-control-lg text-4 @error('email') is-invalid @enderror" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label class="form-label text-color-dark text-3">Contraseña <span class="text-color-danger">*</span></label>
                            <input type="password" value="" name="password" class="form-control form-control-lg text-4 @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="form-group col-md-auto">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-label custom-control-label cur-pointer text-2" for="rememberme">Recordarme</label>
                            </div>
                        </div>
                        <div class="form-group col-md-auto">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2" href="{{ route('password.request') }}">
                                    {{ __('Olvidó su Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <button type="submit" class="btn btn-dark btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3">
                                {{ __('Entrar') }}
                            </button>
                            
                        </div>
                    </div>
                </form>
            </div>

</div>


</div>		
    

    
</div>
@endsection
