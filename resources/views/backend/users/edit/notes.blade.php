@extends('backend.users.edit.parent_tabs')

@section('tab_content')


    <div class="form-group @if ($errors->has('username')) has-error has-feedback @endif">
        {!! Form::label('notes', trans('users.tabs-notes'), array('class' => 'control-label')) !!}
        {!! Form::textarea('description', $user->description, array('class' => 'form-control')) !!}
    </div>

    {!! Form::hidden('description', $user->description, array('class' => 'form-control')) !!}
@stop
