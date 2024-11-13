<div>
    <h2>Vistas por categorías</h2>
    <div style="display:flex; flex-direction:row; overflow: auto; white-space: nowrap;">
        @foreach($filteredCategories as $category)
            <div class="col-md-4" style="margin: 5px;">
                <div class="card text-center">
                    <div class="card-header" style="background-color:#17a2b8; color:white; font-size:18px">
                        {{ $category['nameCat'] }}
                    </div>
                    <div class="card-body" style="max-width: 100%; white-space: normal;">
                        <h5 class="card-title">Profesionales</h5>
                        <ul class="list-unstyled">
                            @foreach($category['views_by_professional'] as $professional)
                                <li><a target="_blank" href="{{ route('homeprofesional', ['id' => $professional['pub_id']]) }}">{{ $professional['name'] }} {{ $professional['last_name'] }}</a>: {{ $professional['views'] }} visitas</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-muted card-title">
                        <h5 class="card-title" style="font-size:18px">con {{ $category['view_count'] }} visitas</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
