<div>
    <h2>Vistas por publicación</h2>
    <div style="display:flex; flex-direction:row; overflow: auto; white-space: nowrap;">
        @foreach($filteredPublicaciones as $publicacion)
            <div class="col-md-4" style="margin: 5px;">
                <div class="card text-center">
                    <div class="card-header" style="background-color:#17a2b8; color:white; font-size:18px">
                        {{ $publicacion->name }} {{ $publicacion->last_name }}
                    </div>
                    <div class="card-body" style="max-width: 100%; white-space: normal;">
                        <a target="_blank" href="{{ route('homeprofesional', ['id' => $publicacion->pub_id]) }}">{{ $publicacion->cat }}</a>
                    </div>
                    <div class="card-footer text-muted card-title">
                        <h5 class="card-title" style="font-size:18px">con {{ $publicacion->view_count }} visitas</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
