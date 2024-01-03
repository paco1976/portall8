<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('Título') }}
            {{ Form::text('title', $aboutu->title, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Titulo']) }}
            {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Texto') }}
            {{ Form::textarea('description', $aboutu->description, [ 'type' => 'text', 'class' => 'ckeditor form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'id' => 'txtDescripcion','placeholder' => 'Texto']) }}
            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <!--
        <div class="form-group">
            {{ Form::label('active') }}
            {{ Form::text('active', $aboutu->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Active']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        <a class="btn btn-dark" href="{{ route('aboutus.index') }}"> {{__('Back')}}</a>
    </div>
</div>