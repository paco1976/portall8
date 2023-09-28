@extends('layouts.home')

@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('main')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

			<div role="main" class="main">

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
							<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
									<li><a href="{{ route('perfil') }}">Panel de Control</a></li>
									<li><a href="{{ route('toolsList') }}">Pañol</a></li>
									<li class="active">Nuevo préstamo</li>

								</ul>
							</div>
						</div>						
						
						<div class="row">
							<div class="col-md-12">
								<h1>Nuevo préstamo</h1>
							</div>
						</div>
					</div>
				</section>
				@if (Session::has('message'))
                   <div class="alert alert-success" style="display:flex; flex-direction:row; justify-content:space-between">
                        <p >{{ Session::get('message') }}</p>
						<button type="button" style="float:right; border-radius: 2px;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button>
                    </div>									
                @endif	
				<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-7">
					@if ($tool_selectd)
                        <div style="height: 300px; width: 100%; position: relative; overflow: hidden;">
                            <div style="background-image: url('{{ empty($tool_selectd->nameImage) ? Storage::disk('tools')->url('tool_default.jpg') : Storage::disk('tools')->url($tool_selectd->nameImage) }}'); width: 100%; height: 100%; background-size: cover; background-position: center;"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <h2 style="margin: 0">{{ $tool_selectd->name }}</h2>
                            <p><small class="text-muted">ID: {{ $tool_selectd->id }}</small></p>
                            <p>{{ $tool_selectd->description }}</p>
                            <form method="post" action="{{ route('loan_save') }}" id="save">
								@csrf

								<input type="hidden"  id="tool_selectd" class="form-control" name="tool_selectd" required placeholder=" {{$tool_selectd->name}}" value=" {{$tool_selectd->id}}" />
								@error('user_type')
								<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
								</span>
								@enderror
								<!-- Inicio Elegir Usuarios, caso Admin -->							
								@if(Auth::user()->user_type()->first()->name=='Administrador')
								<div >
								<label for="name">Profesional</label>
								</div>
								<div >
								<select name="user"  id="user" required>
								<option value="">Seleccione</option>
								@foreach ($users as $user)
								<option value='{{ $user->id }}'>{{ $user->name }}</option>
								@endforeach
								</select>
								</div>													
								</div>
								@endif	
								<!-- Fin Elegir Usuarios, caso Admin -->
                               
								<div class="form-group">
                                    <label for="dates">Seleccionar fechas</label>
                                    <input type="datetime-local" id="dates" class="form-control input-lg @error('password') is-invalid @enderror" name="dates" placeholder="__/__/__ a __/__/__" autofocus required>
                                    @error('dates')
                                    <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>


								<button type="submit" class="btn btn-primary">Solicitar</button>
                                <a href="{{ Url('/loans') }}" class="btn btn-danger">Regresar</a>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




				@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
	$(document).ready(function() {
		var js_array = [<?php echo '"'.implode('","', $dates_).'"' ?>];
		var date= $("input[type='datetime'], input[type='datetime-local']").flatpickr({
		// 	onReady: function () {
		// 	this.jumpToDate("2025-01")
		// },
		disable: js_array,
		dateFormat: "Y-m-d",
		mode: "range",
		minDate: new Date(),
		locale: "es",
		max:3,
      });
	});
</script>
@endpush