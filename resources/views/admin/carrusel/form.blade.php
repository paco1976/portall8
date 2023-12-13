<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('Texto grande (max 40 caracteres)') }}
            {{ Form::text('text1', $carrusel->text1, ['class' => 'form-control' . ($errors->has('text1') ? ' is-invalid' : ''), 'placeholder' => 'Texto principal en la imagen']) }}
            {!! $errors->first('text1', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Texto chico (max 40 caracteres)') }}
            {{ Form::text('text2', $carrusel->text2, ['class' => 'form-control' . ($errors->has('text2') ? ' is-invalid' : ''), 'placeholder' => 'Texto secundario en la imagen']) }}
            {!! $errors->first('text2', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('URL externa') }}
            {{ Form::text('link', $carrusel->link, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => 'URL exterana si es que tiene']) }}
            {!! $errors->first('link', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('imagen (Medidas correctas 1920 x 667)') }}
            <!--{{ Form::text('image', $carrusel->image, ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'placeholder' => 'Image']) }}-->
            {{ Form::file('image', ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'accept'=>'image/*', "onchange"=>"document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"  ]) }}
            {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
            @if($carrusel->image)
                <img id="output" src="{{ $carrusel->image}}" width="200" height="">
            @else
                <img id="output" src="{{ asset('img/slides/slide-prueba2.jpg') }}" width="200" height="">
            @endif
        </div>
        <div class="form-group">
            {{ Form::label('Estado') }}
            <!--{{ Form::text('active', $carrusel->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Active']) }} -->
            {{ Form::select('active', $active, $carrusel->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        <a class="btn btn-dark" href="{{ route('carrusel.index') }}"> {{ __('Back') }}</a>
    </div>
</div>