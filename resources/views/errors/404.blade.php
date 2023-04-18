@extends('errors::layout')
@extends('layouts.error')

@section('title','404')



@section('main')

<div role="main" class="main">

<section class="page-top">
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12">
                <h1>Página no encontrada</h1>
            </div>
        </div>
    </div>
</section>

<!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
<!-- <div id="googlemaps" class="google-map"></div> -->

<div class="container">

    <div class="row">
        <div class="col-md-6">
            
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
            <h1>Ups! Hubo un problema!</h1>
            <p>No se conetró la página que estabas buscando. Pero no importa, escribinos y decinos que es lo que sucedió así te podemos ayudar.</p>
            <h2 class="short"><strong>Hacé una</strong> consulta</h2>
            <form id="contactForm" action="{{ route('contact_send') }}" method="POST" enctype="multipart/form-data">
            {{ method_field('PUT') }}  
              @csrf
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Tu Nombre *</label>
                            <input type="text" value="" data-msg-required="Por favor ingresa tu nombre." maxlength="100" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="col-md-6">
                            <label>Tu E-mail *</label>
                            <input type="email" value="" data-msg-required="Por favor ingresa tu e-mail." data-msg-email="Please enter a valid Dirección de correo." maxlength="100" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Asunto</label>
                            <input type="text" value="" data-msg-required="Por favor ingresa tu asunto." maxlength="100" class="form-control" name="asunto" id="subject" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Mensaje *</label>
                            <textarea maxlength="5000" data-msg-required="Por favor ingresa tu mensaje." rows="10" class="form-control" name="mensaje" id="message" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!--<input type="submit" value="Enviar Mensaje" class="btn btn-primary btn-lg" data-loading-text="Cargando...">-->
                        <button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
                    </div>
                </div>
            </form>
        </div>


        <div class="col-md-6">

            <h4 class="push-top">Somos <strong>CFP</strong></h4>
            <p>Cefeperes es una plataforma digital diseñada para facilitar el contacto entre profesionales de los oficios y potenciales clientes. La lista de servicios ofrecidos es variada (se puede consultar acá) y el denominador común es que son egresadas y egresados de escuelas púbicas de formación profesional de nuestra ciudad. </p>

            <hr />

            <h4>Nuestros <strong>Datos</strong></h4>
            <ul class="list-unstyled">
                <li><p><i class="fa fa-map-marker"></i> <strong>Dirección:</strong> Morón 2453. Flores, CABA</p></li>
                    <li><p><i class="fa fa-phone"></i> <strong>Telefono:</strong> 4611-5374 / 4637-8465</p></li>
                    <li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@serviciosprofesionales.com.ar">info@cefeperes.com.ar</a></p></li>
            </ul>

            <hr />

            <h4>Nuestros <strong>Horarios</strong></h4>
            <ul class="list-unstyled">
                <li><i class="fa fa-time"></i> Lunes - Viernes 9am a 5pm</li>
                <li><i class="fa fa-time"></i> Sabado - 9am a 2pm</li>
                <li><i class="fa fa-time"></i> Domingo - Cerrado</li>
            </ul>

        </div>

    </div>

</div>

</div>

            @endsection
