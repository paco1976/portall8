@extends('layouts.home')

@section('template_title')
    {{ $link->name ?? __('Show Link') }}
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
				<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Mostrar Links de interes</h1>
				
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
                            <span class="card-title">{{__('Show Link')}}</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('links.index') }}"> {{__('Back')}}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>{{__('Name')}}:</strong>
                            {{ $link->name }}
                        </div>
                        <div class="form-group">
                            <strong>{{__('Description')}}:</strong>
                            {{ $link->description }}
                        </div>
                        <div class="form-group">
                            <strong>{{__('Link')}}:</strong>
                            {{ $link->link }}
                        </div>
                        <!--
                        <div class="form-group">
                            <strong>{{__('Active')}}:</strong>
                            {{ $link->active }}
                        </div>
                    -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
