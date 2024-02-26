@extends('layouts.home')

@section('main')

    <section
        class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8"
        style="background-image: url({{ asset('img/slides/slide-bg-4.jpg') }}); background-size: cover; background-position: center; min-height: 645px;">
        <div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
        <div class="container pt-lg-5 mt-5">
            <div class="row pt-3 pb-lg-0 pb-xl-0">
                <div class="col-lg-6 pt-4 mb-5 mb-lg-0">
                    <ul class="breadcrumb font-weight-semibold text-4 negative-ls-1">
                        <li><a href="{{ route('welcome') }}">Inicio</a></li>
                        <li class="text-color-primary"><a href="#">Panel de control</a></li>

                    </ul>
                    <h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">CONSULTAS</h1>

                    <a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100"
                        class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver
                        <i class="fas fa-arrow-down ms-1"></i></a>


                </div>

            </div>
        </div>
    </section>



    <div role="main" class="main" id="ver">
    </div>
    <div class="container pt-3 pb-2">
        <div class="form-group row">
            <div class="form-group col-lg-9">
                <h2 class="font-weight-normal line-height-1">Consultas a <strong
                        class="font-weight-extra-bold">{{ $user->name }} {{ $user->last_name }}</strong></h2>
            </div>

            <div class="form-group col-lg-2">
                <a href="{{ route('prof_publicacion', ['hash_user' => $user->hash]) }}"
                    class="btn btn-dark btn-modern float-end">Ver publicaciones</a>

            </div>
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
            <div class="row pt-2">
                <div class="container">
                    <section class="card card-admin">

                        <div class="card-body">

                            @if (!$publicaciones)
                                <p>Por el momento no tienes publicaciones</p>
                            @else
                                <table class="table table-bordered table-striped mb-0" id="datatable-editable">
                                    <thead>
                                        <tr class="actions text-center">
                                            <th>Publicación</th>
                                            <th>Mensajes nuevos</th>
                                            <th>Total de mensajes</th>
                                            <th>Total de consultas</th>
                                            <th>Ver consultas</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($publicaciones as $publicacion)
                                            <tr data-item-id="1">
                                                <td>{{ $publicacion->categoria->name }}</td>
                                                <td class="actions text-center">
                                                    @if ($publicacion->messages_total > 0)
                                                        @if ($publicacion->messages_not_read > 0)
                                                            <span
                                                                class="btn disabled btn-success"><strong>{{ $publicacion->messages_not_read }}</strong></span>
                                                        @else
                                                            <span
                                                                class="btn disabled btn-light"><strong>{{ $publicacion->messages_not_read }}</strong></span>
                                                        @endif
                                                    @else
                                                        <span class="btn disabled btn-light"><strong>0</strong></span>
                                                    @endif
                                                </td>
                                                <td class="actions text-center">
                                                    @if ($publicacion->messages_total > 0)
                                                        <span class="btn disabled btn-light"><strong>{{ $publicacion->messages_total }}</strong></span>
                                                    @else
                                                        <span class="btn disabled btn-light"><strong>0</strong></span>
                                                    @endif
                                                </td>
                                                <td class="actions text-center">
                                                    @if ($publicacion->cant_consultas > 0)
                                                        <a
                                                            class="btn disabled btn-light"><strong>{{ $publicacion->cant_consultas }}</strong></a>
                                                    @else
                                                        <span class="btn disabled btn-light"><strong>0</strong></span>
                                                    @endif
                                                </td>
                                                <td class="actions text-center">
                                                    <a href="{{ route('admin_consultas', ['publicacion_hash' => $publicacion->hash]) }}"
                                                        class="btn btn-info"><i class="fas fa-external-link"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </section>
                </div>
            </div>



        </div>

    </div>


@endsection
