<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>CEFEPERES</title>

    <!--<link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sticky-footer-navbar/">-->
    <link relcss="stylesheet" href="{{ asset('css/sticky-footer-navbar.css') }}">

    <!-- Bootstrap core CSS -->
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
  
    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="css/style_paco.css">

   </head>
  <body class="d-flex flex-column h-100">
    <header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/"><img src="{{ asset('img/logo-cfp.png') }}" alt="" style="height:58px"></a>
    <!--<a class="navbar-brand" href="#">CEFEPERES</a>-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">INICIO <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"> MENSAJES</a>
        </li>
        <!--
        <li class="nav-item">
          <a class="nav-link" href="#">COMUNIDAD CFP</a>
        </li>
        -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
            aria-haspopup="true" aria-expanded="false">COMUNIDAD CFP</a>
            <div class="dropdown-menu">
            <a class="dropdown-item" href="/comunidad">CEFEPERES</a>
            <a class="dropdown-item" href="#">Tarifarios</a>
            <a class="dropdown-item" href="#">Beneficios</a>
            <a class="dropdown-item" href="#">Foro</a>
            <a class="dropdown-item" href="#">Pañol</a>
            <!--
            <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          -->
            </div>
        </li>
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">USUARIO</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/usuarios">LISTADO DE USUARIOS</a>
                    <a class="dropdown-item" href="/usuario/nuevo">NUEVO</a>
                </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">INICIAR SESIÓN</a>
        </li>
        <!--
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      -->
      </ul>
      <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Carpintero, Estilista, etc" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
</header>

<!-- Begin page content -->
<main role="main" >

  @yield('content')

</main>

<footer class="footer mt-auto py-3">
  <div class="row">
      <div class="col-lg-6">
        <div class="container">
            <div class="footer-headline"><h4>Usos y condiciones</h4></div>
            <p>
                Para informarte sobre las Condiciones de uso del sitio ingresá
                <a href='/terminos'>aquí</a>.
            </p>
        </div>
      </div>
      <div class="col-lg-6">
          <div class="container">
              <div class="footer-headline"><h4>Contactanos</h4></div>
              <p class="md-margin-bottom-40">
                  Si tenés una consulta escribí a este correo:
                  <a href="mailto:contacto@portaldeservicios.cfp24.com.ar" target="_blank">info@serviciosprofesionales.com.ar</a>
              </p>
          </div>
      </div>
  </div>
</footer>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!--
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
-->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0FM2CN3R42"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0FM2CN3R42');
</script>
    </body>
</html>
