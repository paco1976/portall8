@extends('layouts.home')

@section('template_title')
    {{ $skin->name ?? 'Show Skin' }}
@endsection

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
				<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Diesño</h1>
				
				<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">VER <i class="fas fa-arrow-down ms-1"></i></a>
				
			</div>

		</div>
	</div>
</section>

<div role="main" class="main" id='ver'>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Mostrar Diseño</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('skins.index') }}"> {{__('Back')}}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Color:</strong>
                        </div>
                        <div class="form-group">
                           <h2> {{ $skin->color }} </h2>
                        </div>
                        <div class="form-group">
                            <strong>Archivo CSS:</strong>
                        </div>
                        <div class="form-group">
                            @if ($skin->urlskin )
                                <a class="btn btn-sm btn-success" href="#"> SI</a>
                            @else
                                <a class="btn btn-danger btn-sm" href="#"> NO</a>
                            @endif
                        </div>

                        <div class="form-group">
                            <strong>Vista de muestra:</strong>
                        </div>
                        <div class="form-group">
                            <img id="output" src="{{ $skin->urlimage }}" width="200" height="">
                        </div>

                        <div class="form-group">
                            <strong>Estado:</strong>
                             @if ($skin->active)
                                <a class="btn btn-danger btn-sm" href="#">Diseño Activo</a>
                            @else
                                <a class="btn btn-danger btn-sm" href="#">Dieseño Desactivado</a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
