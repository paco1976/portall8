@extends('layouts.app')

@section('main')

<div role="main" class="main">

    <section class="page-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="{{ url('/') }}">Inicio</a></li>
                        <li class="active">Panel de control</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h1>VERIFICAR EMAIL</h1>
                </div>

            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">{{ __('Verificar correo electrónico') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado el link para recuperar la clave a su mail.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('Si no recibió el mail ') }}, <a href="{{ route('verification.resend') }}">{{ __('haga clic y se enviará nuevamente') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
