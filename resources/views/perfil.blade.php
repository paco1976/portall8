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
                                    @if ($user_profile)
									<li>
										<a href="{{ route('publicacion') }}" ><i class="fa fa-file-powerpoint-o"></i> Publicaciones</a>
                                    </li>
                                    @endif

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
                                        <div>
                                            <img alt="" height="300" class="img-responsive" src="{{ asset($user->avatar) }}"/>
                                        </div>
                                        <br>
                                        @if ($user->avatar == '/img/team/perfil_default.jpg')
                                        <form action="{{ route('avatarupload') }}" method="POST" enctype="multipart/form-data" >
                                            {{ method_field('PUT') }}
                                            @csrf
                                            <input type="file" name="avatar" class="form-control" required>
                                            <br>

                                            <button type="submit" class="btn btn-default fileupload-new">Subir imagen</button>
                                            <!-- <a href="#" class="btn btn-default fileupload-new" data-dismiss="fileupload">Subir imagen</a> -->
                                        </form>

                                        @else
                                        <a href="{{ route('avatardelete') }}" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar imagen</a>
                                        @endif
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
                                        <section class="form-group-vertical">
                                            <label>{{ __('Celular') }}</label>
                                            <input class="form-control" type="text" placeholder="{{ $user_profile->mobile }}"><br>

                                            @if ($user->cfp_id )
                                            <label>{{ __('CFP') }}</label>
                                            <input class="form-control" type="text" placeholder="{{ $user_cfp->name }}"><br>
                                            @endif

                                            @if ($user_profile->phone )
                                                <label>{{ __('Telefono fijo') }}</label>
                                                <input class="form-control" type="text" placeholder="{{ $user_profile->phone }}"><br>
                                            @endif


                                            <!--REDES-->
                                            @if ($user_profile->twitter )
                                                <label>{{ __('Twitter') }}</label>
                                                <input class="form-control" type="text" placeholder="{{ $user_profile->twitter }}"><br>
                                            @endif

                                            @if ($user_profile->facebook )
                                                <label>{{ __('Facebook') }}</label>
                                                <input class="form-control" type="text" placeholder="{{ $user_profile->facebook }}"><br>
                                            @endif

                                            @if ($user_profile->instagram )
                                                <label>{{ __('Instagram') }}</label>
                                                <input class="form-control" type="text" placeholder="{{ $user_profile->instagram }}"><br>
                                            @endif

                                            @if ($user_profile->linkedin )
                                                <label>{{ __('Linkedin') }}</label>
                                                <input class="form-control" type="text" placeholder="{{ $user_profile->linkedin }}"><br>
                                            @endif
                                            
                                            @if(($miszonas))
                                            <strong>Zonas de trabajo </strong>
                                            <br>
                                                @foreach($miszonas as $zona)
                                                    {{$zona->name}}
                                                @endforeach
                                            @else
                                                UPS!, todavía no elegiste zonas de trabajo
                                            @endif
                                        </section>
                                    </div>
                                    </div>
                                    <a href="{{ route('perfil_edit') }}" class="btn btn-primary" data-dismiss="fileupload">Editar</a>
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
