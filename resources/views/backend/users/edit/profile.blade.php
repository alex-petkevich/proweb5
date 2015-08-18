@extends('backend.users.edit.parent_tabs')

@section('tab_content')


    <div class="form-group @if ($errors->has('username')) has-error has-feedback @endif">
        {!! Form::label('username', trans('users.username'), array('class' => 'control-label')) !!}
        {!! Form::text('username', $user->username, array('disabled'=>$user->id,'class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('active')) has-error has-feedback @endif">
        {!! Form::label('active', trans('users.active'), array('class' => 'control-label')) !!}
        {!! Form::checkbox('active','1',array('class' => 'form-control')) !!}
    </div>


@stop
