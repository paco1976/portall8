<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
             {{ Form::text('id', $contact->id, ['class' => 'form-control' . ($errors->has('id') ? ' is-invalid' : ''), 'hidden']) }}
         </div>
        <div class="form-group">
            <!-- {{ Form::label('Nombre') }} -->
            {{ Form::text('name', $contact->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Detalle') }}
            {{ Form::text('detail', $contact->detail, ['class' => 'form-control' . ($errors->has('detail') ? ' is-invalid' : ''), 'placeholder' => 'Detail']) }}
            {!! $errors->first('detail', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <!--
        <div class="form-group">
            {{ Form::label('active') }}
            {{ Form::text('active', $contact->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Active']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        <div class="form-group">
            {{ Form::label('Estado') }}
            {{ Form::select('active', $active, $contact->active, ['class' => 'form-control' . ($errors->has('active') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
            {!! $errors->first('active', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        <a class="btn btn-dark" href="{{ route('contacts.index') }}"> {{__('Back')}}</a>
    </div>
</div>