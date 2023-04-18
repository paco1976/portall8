@extends('layouts.app')

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

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                    
                    <div class="tab-content">
                        <div id="clave" class="tab-pane active">
                            <div class="row">

                                <div class="col-md-12">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Enviar link reset password') }}
                                    </button>


                                </div>
                                <br>
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
