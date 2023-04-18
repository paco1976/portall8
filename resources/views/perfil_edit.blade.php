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
										<a href="{{ Url('/perfil') }}" ><i class="fa fa-user"></i> Perfil</a>
									</li>
									<li>
										<a href="{{ route('publicacion') }}" ><i class="fa fa-file-powerpoint-o"></i> Publicaciones</a>
									</li>



								</ul>
                                <div class="tab-content">
                                <div id="perfil" class="tab-pane active">

                                <div class="row">
                                    @if (Session::has('message'))
                                    <div class="alert alert-success">
                                        <p>{{ Session::get('message') }}</p>
                                    </div>
                                    @endif

                                <div class="col-md-4">
                                        <p class="text-primary">{{ $user->name }} {{ $user->last_name }}</p>
                                        <div class="thumbnail">
                                            <img alt="" height="300" class="img-responsive" src="{{ asset($user->avatar) }}">
                                        </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="col-md-9">
                                        @if (!$user_profile)
                                            <section class="form-group-vertical">
                                                <div class="alert alert-danger" role="alert">
                                                    Debe completar su perfil antes de continuar
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <a href="{{ route('perfil_new') }}" class="btn btn-primary" data-dismiss="fileupload">Completar Perfil</a>
                                    @else
                                    <form action="{{ route('perfil_update') }}" method="post" enctype="multipart/form-data" >
                                        {{ method_field('PUT') }}
                                        @csrf
                                        <section class="form-group-vertical">

                                            <label>{{ __('Celular') }} Ej: 1155668899, sin guiones y sin cero delante.</label>
                                            <input class="form-control" type="number" name="mobile" placeholder="" value="{{ old('mobile', $user_profile->mobile)  }}" required>
                                            @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <br>


                                            <label>{{ __('CFP') }}</label>
                                            <select class="form-control" name="user_cfp"  id="subject" required>
                                                    @if ($user_cfp->id)
                                                    <option value='{{ old('user_cfp',$user_cfp->id) }}'>{{ old('name',$user_cfp->name) }}</option>
                                                    @endif

                                                @foreach ($user_cfp_all as $user_cfpx)
                                                    <option value='{{ $user_cfpx->id }}'>{{ $user_cfpx->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_cfp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <br>



                                            <label>{{ __('Telefono fijo') }} Sin guiones</label>
                                            <input class="form-control" type="number" name="phono" placeholder="" value="{{ old('phono', $user_profile->phone)  }}">

                                            @error('phono')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <br>

                                            <!--REDES-->

                                                <label>{{ __('Twitter') }}</label>
                                                <input class="form-control" type="text" name="twitter" placeholder="" value="{{ old('twitter', $user_profile->twitter) }}">

                                            @error('twitter')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <br>


                                                <label>{{ __('Facebook') }}</label>
                                                <input class="form-control" type="text" name="facebook" placeholder="" value="{{ old('facebook',$user_profile->facebook) }}">

                                            @error('facebook')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <br>



                                                <label>{{ __('Instagram') }}</label>
                                                <input class="form-control" type="text" name="instagram" placeholder="" value="{{ old('instagram', $user_profile->instagram)  }}">

                                            @error('instagram')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <br>


                                                <label>{{ __('Linkedin') }}</label>
                                                <input class="form-control" type="text" name="linkedin" placeholder="" value="{{ old('linkedin', $user_profile->linkedin) }}"><br>

                                            @error('linkedin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <br>

                                        </section>
                                    </div>
                                    </div>
                                    <a href="#" class="btn btn-default fileupload-new" data-dismiss="fileupload">Zonas de trabajo </a>
                                    
                                    
                                    <ul class="portfolio-list sort-destination" data-sort-id="portfolio">
                                        <li class="col-md-4 col-sm-6 col-xs-12 isotope-item websites">
                                            <label for="">
                                            <input type="checkbox" name="select-all" onclick="toggle(this);" multiple ria-label="Radio button for following text input" /> Todos los barrios
                                            </label><br>
                                        </li>
                                    
                                    
                                    @if($zonas_all)
                                        @foreach($zonas_all as $zona)
                                            <li class="col-md-4 col-sm-6 col-xs-12 isotope-item websites">
                                            @if($user->hasZona($zona))
                                                <label for="">
                                                <input type="checkbox" name="zonas[]" value="{{ $zona->name }}" multiple ria-label="Radio button for following text input" checked> {{ $zona->name }}
                                                </label><br>
                                            @else
                                            <label for="">
                                            <input type="checkbox" name="zonas[]" value="{{ $zona->name }}" multiple ria-label="Radio button for following text input"> {{ $zona->name }}
                                            </label><br>
                                            @endif
                                                
                                            </li>
                                        @endforeach
                                    @else  
                                        <p>Ups! Algo ocurrio con las zonas</p>
                                    @endif
                                    </ul>

                                    <button type="submit" class="btn btn-primary">Guardar Datos</button>

                                    </form>
                                    @endif
                                </div>
                            </div>
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
