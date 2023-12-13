<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('name', $categoriaTipo->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Palabra Clave') }}
            {{ Form::text('keyword', $categoriaTipo->keyword, ['class' => 'form-control' . ($errors->has('keyword') ? ' is-invalid' : ''), 'placeholder' => 'Ej: Hogar']) }}
            {!! $errors->first('keyword', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <!--
        <div class="form-group">
            {{ Form::label('Imagen (medida 1200 x 800)') }}
            {{ Form::file('icon', ['class' => 'form-control' . ($errors->has('icon') ? ' is-invalid' : ''), 'accept'=>'image/*', "onchange"=>"document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"  ]) }}
            {!! $errors->first('icon', '<div class="invalid-feedback">:message</div>') !!}
            @if($categoriaTipo->icon)
                <img id="output" src="{{ $categoriaTipo->icon }}" width="200" height="">
            @else
                <img id="output" src="{{ asset('img/slides/slide-prueba2.jpg') }}" width="200" height="">
            @endif
        </div>
        -->        
       <!--
        <div class="form-group">
            {{ Form::label('Activo') }}
            {{ Form::text('active', $categoriaTipo->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Active']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        <div class="form-group">
            {{ Form::label( __('Estado') ) }}
            {{ Form::select('active', $active, $categoriaTipo->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        <a href="{{ route('categoria-tipos.index') }}" class="btn btn-dark" >Cancelar</a>
    </div>
</div>