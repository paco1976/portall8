@extends('layouts.home')

@section('main')
<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
	<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
	<div class="container pt-lg-5 mt-5">
		<div class="row pt-3 pb-lg-0 pb-xl-0">
			<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
				<ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
					<li><a href="{{route('welcome')}}">Inicio</a></li>
					<li class="text-color-primary"><a href="#">Panel del Sitio</a></li>
					
				</ul>
				<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Crear Categorias</h1>
				
				<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">VER <i class="fas fa-arrow-down ms-1"></i></a>
				
			</div>

		</div>
	</div>
</section>

<div role="main" class="main" id='ver'>
 
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
        <div class="row">

            <div class="col-md-10">

                <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href=""><i class="fa fa-unlock-alt"></i>Datos solicitados</a>
                            </li>
                        </ul>


                    <div class="tab-content">
                        <div id="clave" class="tab-pane active">

                            <h2 class="short"><strong>Nueva </strong> CATEGORÍA </h2>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin_categoria_save') }}" enctype="multipart/form-data" >
                                    {{ method_field('PUT') }}
									@csrf

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de la categoría') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Icono de categoría') }} </label>

                                        <div class="col-md-6">
                                            <input id="icono" type="file" class="form-control @error('icono') is-invalid @enderror" name="icono" value="{{ old('icono') }}" required>

                                            @error('icono')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Super Categoría') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="categoria_tipo_id"  id="subject" required>
                                                <option value="">Seleccione una opción</option>
                                                @foreach ($categoria_tipo_all as $categoria_tipo)
                                                    <option value='{{ $categoria_tipo->id }}'>{{ $categoria_tipo->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('categoria_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Regsitrar') }}
                                            </button>
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
@endsection
