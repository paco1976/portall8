<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('Nombre del color') }}
            {{ Form::text('color', $skin->color, ['class' => 'form-control' . ($errors->has('color') ? ' is-invalid' : ''), 'placeholder' => 'Color']) }}
            {!! $errors->first('color', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Archivo de Diseño') }}
            {{ Form::file('urlskin', ['class' => 'form-control' . ($errors->has('urlskin') ? ' is-invalid' : '')]) }}
            {!! $errors->first('urlskin', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        @if ($skin->urlskin)
        <a class="btn btn-sm btn-success" href="#"> {{$skin->color}}</a>
        @endif
        <!--
        <div class="form-group">
            {{ Form::label('Imagen de Muestra') }}
            {{ Form::text('urlimage', $skin->urlimage, ['class' => 'form-control' . ($errors->has('urlimage') ? ' is-invalid' : ''), 'placeholder' => 'Urlimage']) }}
            {!! $errors->first('urlimage', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        <div class="form-group">
            {{ Form::label('imagen de muestra (Medidas correctas 400 x 200)') }}
            {{ Form::file('urlimage', ['class' => 'form-control' . ($errors->has('urlimage') ? ' is-invalid' : ''), 'accept'=>'image/*', "onchange"=>"document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"  ]) }}
            {!! $errors->first('urlimage', '<div class="invalid-feedback">:message</div>') !!}
            @if($skin->urlimage)
                <img id="output" src="{{ $skin->urlimage }}" width="200" height="">
            @else
                <img id="output" src="{{ asset('img/slides/slide-prueba2.jpg') }}" width="200" height="">
            @endif
        </div>
        <!--
        <div class="form-group">
            {{ Form::label('active') }}
            {{ Form::text('active', $skin->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Active']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        <div class="form-group">
            {{ Form::label('Estado') }}
            {{ Form::select('active', $active, $skin->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        <a class="btn btn-dark" href="{{ route('skins.index') }}"> {{ __('Back') }}</a>
    </div>
</div>