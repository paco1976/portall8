<div class="box box-info padding-1">
    <div class="box-body">
       <!-- 
        <div class="form-group">
            {{ Form::label('image') }}
            {{ Form::text('image', $logo->image, ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'placeholder' => 'Image']) }}
            {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    -->
        <div class="form-group">
            {{ Form::label('Logo (Medidas correctas 240 x 140 px)') }}
            <!--{{ Form::text('image', $logo->image, ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'placeholder' => 'Image']) }}-->
            {{ Form::file('image', ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'accept'=>'image/*', "onchange"=>"document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"  ]) }}
            {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
            @if($logo->image)
                <img id="output" src="{{ $logo->image}}" width="200" height="">
            @else
                <img id="output" src="{{ asset('ipp/img/logo/logo_generico.jpg') }}" width="200" height="">
            @endif
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        <a class="btn btn-dark" href="{{ route('logo.index') }}"> {{ __('Back') }}</a>
    </div>
</div>