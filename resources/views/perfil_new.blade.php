@extends('layouts.panel')

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
								<h1>MI PERFIL</h1>
							</div>

						</div>
					</div>
				</section>



				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<div class="tabs">
								<ul class="nav nav-tabs">

									<li class="active">
										<a href="{{ Url('perfil') }}" ><i class="fa fa-user"></i> Perfil</a>
									</li>
                			</ul>
						<div class="tab-content">
						<div id="perfil" class="tab-pane active">

                    <form action="{{ route('store') }}" method="post" enctype="multipart/form-data" >
                        {{ method_field('PUT') }}
                        @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-primary">{{ $user->name }} {{ $user->last_name }}</p>
                                    <div class="thumbnail">
                                    <img alt="" height="300" class="img-responsive" src="{{ Url($user->avatar) }}"/>
                                </div>
                                <p class="text-primary">Los campos marcados con * son obligatorios</p>
                                <!--
                                <a href="#" class="btn btn-default fileupload-new" data-dismiss="fileupload">Subir imagen</a>
                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                -->
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="col-md-9">
                                        <section class="form-group-vertical">
                                            <!--
                                            <label>{{ __('Imagen de Perfil (*)') }}</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('file') is-invalid @enderror" name="photo" value="{{ old('file') }}" required id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                </div>
                                            </div>
                                            @error('photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>
                                            -->

                                            <label>{{ __('Celular (*)') }} Ej: 1155668899, sin guiones y sin cero delante.</label>
                                            
                                            <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>

                                            <label>{{ __('CFP (*)') }}</label>
                                            <select class="form-control" name="user_cfp"  id="subject" required>
                                                    @if ($user_cfp->id)
                                                    <option value="{{ old('user_cfp',$user_cfp->id) }}">{{ old('name',$user_cfp->name) }}</option>
                                                    @endif
                                                @foreach ($user_cfp_all as $user_cfp)
                                                    <option value='{{ $user_cfp->id }}'>{{ $user_cfp->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_cfp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>

                                            <label>{{ __('Telefono Fijo') }} Sin guiones</label                                            >
                                            <input id="phono" type="number" class="form-control @error('phono') is-invalid @enderror" name="phono" value="{{ old('phono') }}" autocomplete="phono" autofocus>
                                            @error('phono')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>

                                            <label>{{ __('Twitter') }}</label                                            >
                                            <input id="twitter" type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter" value="{{ old('twitter') }}" autocomplete="twitter" autofocus>
                                            @error('twitter')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>

                                            <label>{{ __('Facebook') }}</label                                            >
                                            <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" value="{{ old('facebook') }}" autocomplete="twitter" autofocus>
                                            @error('facebook')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>

                                            <label>{{ __('Instagram') }}</label                                            >
                                            <input id="instagram" type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" value="{{ old('instagram') }}" autocomplete="instagram" autofocus>
                                            @error('instagram')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>

                                            <label>{{ __('Linkedin') }}</label                                            >
                                            <input id="linkedin" type="text" class="form-control @error('linkedin') is-invalid @enderror" name="linkedin" value="{{ old('linkedin') }}" autocomplete="linkedin" autofocus>
                                            @error('linkedin')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <br>

                                        </section>
                                    </div>
                                </div>
                                <!--
                                <select name="cosa[]" multiple="MULTIPLE">
                                    <option value="cosa" selected>cosa</option>
                                    <option value="cosa2">cosa2</option>
                                    <option value="cosa3">cosa3</option>
                                </select>
                                -->

                                <a href="#" class="btn btn-default fileupload-new" data-dismiss="fileupload">Zonas de trabajo </a>
                                

                                <ul class="portfolio-list sort-destination" data-sort-id="portfolio">
                                    <li class="col-md-4 col-sm-6 col-xs-12 isotope-item websites">
                                        <label for="">
                                        <input type="checkbox" name="select-all" onclick="toggle(this);" multiple ria-label="Radio button for following text input"> Todos los barrios
                                        </label><br>
                                    </li>
                                @if($zonas_all)
                                    @foreach($zonas_all as $zona)
                                    <li class="col-md-4 col-sm-6 col-xs-12 isotope-item websites">
                                        <label for="">
                                        <input type="checkbox" name="zonas[]" value="{{ $zona->name }}" multiple ria-label="Radio button for following text input"> {{ $zona->name }}
                                        </label><br>
                                    </li>
                                    @endforeach
                                @else  
                                    <p>Ups! Algo ocurrio con las zonas</p>
                                @endif
                                
                                <!--
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for=""><input type="checkbox" name="{{ $zona->name }}" value="Agronomia" multiple ria-label="Radio button for following text input"> {{ $zona->name }}</label><br>
                                    </div>
                                </div>
                                -->
                                
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <!-- <a href="#" class="btn btn-primary" data-dismiss="fileupload">Guardar</a> -->

                            </div>
                     </div>
                    </form>
				</div>

                    </div>
                </div>
            </div>

						<!--
						<div class="col-md-3">
						<button class="btn btn-info btn-small " data-toggle="modal" data-target="#myModal">
								<i class="fa fa-question-circle"></i> ¿Como funciona?
							</button>

							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">Qué hago?</h4>
										</div>
										<div class="modal-body">

											<h4 class="panel-title">
												<strong>Cómo cambio mis datos?</strong>
										</h4>
											<div class="panel-body">
										  Entra en <a href="#">Modificar los detalles</a> y actualizá tu perfil. </div>


											<h4 class="panel-title">
												<strong>Cómo creo mis publicaciones?</strong>
										</h4>

											<div class="panel-body">
										  1. Agregá los cursos que hiciste en el CFP clickeando en el menú Títulos.<br>
2. Una vez que hayas cargado tus tíulos, ya podés crear tus publicaciones clickeando en el menú Publicaciones. </div>

                                    <div class="alert alert-info">
								<strong>Las publicaciones no serán publicadas hasta que los títulos que cargaste sean validados por la administración del CFP.</strong>
							</div>

										</div>
									<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>

										</div>
									</div>
								</div>
							</div>


						</div> -->





					</div>






				</div>

			</div>

@endsection
