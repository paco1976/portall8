@extends('layouts.home')

@section('template_title')
    Skin
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
				<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Diseño</h1>
				
				<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">VER <i class="fas fa-arrow-down ms-1"></i></a>
				
			</div>

		</div>
	</div>
</section>

<div role="main" class="main" id='ver'>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Diseño') }}
                            </span>
                            <!--
                             <div class="float-right">
                                <a href="{{ route('skins.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                            -->
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Color</th>
										<!--<th>Archivo de Diseño</th>-->
										<th>Imagen de ejemplo</th>
										<th>Seleccionado</th>

                                        <!--<th></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skins as $skin)
                                        <tr>
                                            <td>{{ ++$i }}</td>
											<td>{{ $skin->color }}</td>
                                            <!--
											<td>
                                                @if ($skin->urlskin )
                                                    <a class="btn btn-sm btn-success" href="#"> SI</a>
                                                @else
                                                    <a class="btn btn-danger btn-sm" href="#"> NO</a>
                                                @endif
                                            </td>
                                            -->
											<!--<td>{{ $skin->urlimage }}</td>-->
                                            <td><img id="output" src="{{ $skin->urlimage }}" width="200" height=""></td>
                                            <td>
                                                    @if($skin->active)
                                                        <a class="btn btn-info btn-sm" href="#"> SI</a>
                                                    @else
                                                        <a class="btn btn-danger btn-sm" href="{{ route('skin_select',$skin->id) }}"> NO</a>
                                                    @endif

                                            </td>
                                            <!--
                                            <td>
                                                <form action="{{ route('skins.destroy',$skin->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('skins.show',$skin->id) }}"><i class="fa fa-fw fa-eye"></i> {{__('Show')}}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('skins.edit',$skin->id) }}"><i class="fa fa-fw fa-edit"></i> {{__('Edit')}}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{__('Delete')}}</button>
                                                </form>
                                            </td>
                                        -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $skins->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
