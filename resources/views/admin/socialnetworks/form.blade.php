<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
           <!-- <input class="form-control" type="number" name="id" placeholder="" value="{{$socialNetwork->id}}" hidden> -->
            {{ Form::text('id', $socialNetwork->id, ['class' => 'form-control' . ($errors->has('id') ? ' is-invalid' : ''), 'hidden']) }}
        </div>
        <div class="form-group">
            <!--{{ Form::label('Nombre') }} -->
            {{ Form::text('name', $socialNetwork->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('link') }}
            {{ Form::text('link', $socialNetwork->link, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => 'Link']) }}
            {!! $errors->first('link', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <!--
        <div class="form-group">
            {{ Form::label('Activo') }}
            {{ Form::text('active', $socialNetwork->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'SI']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        <div class="form-group">
            {{ Form::label('Estado') }}
            {{ Form::select('active', $active, $socialNetwork->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        <a class="btn btn-dark" href="{{ route('SocialNetworks.index') }}"> {{__('Back')}}</a>
    </div>
</div>