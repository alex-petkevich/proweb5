@extends('backend.users.edit.parent_tabs')

@section('tab_content')

@if ($user->id)
    <div class="form-group">
      {!! Form::label('created', trans('users.created'), array('class' => 'control-label')) !!}
      {!! Form::text('created_at', $user->created_at, array('disabled'=>1,'class' => 'form-control')) !!}
    </div>
    <div class="form-group">
      {!! Form::label('updated', trans('users.updated'), array('class' => 'control-label')) !!}
      {!! Form::text('updated_at', $user->updated_at, array('disabled'=>1,'class' => 'form-control')) !!}
    </div>
@endif

    <div class="form-group @if ($errors->has('username')) has-error has-feedback @endif">
      {!! Form::label('username', trans('users.username'), array('class' => 'control-label')) !!}
      {!! Form::text('username', $user->username, array('disabled'=>$user->id,'class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('email')) has-error has-feedback @endif">
      {!! Form::label('email', trans('users.email'), array('class' => 'control-label')) !!}
      {!! Form::text('email', $user->email, array('disabled'=>$user->id,'class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('password')) has-error has-feedback @endif">
      {!! Form::label('password', trans('login.password'), array('class' => 'control-label')) !!}
      {!! Form::password('password',array('class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('roles')) has-error has-feedback @endif">
      {!! Form::label('roles', trans('users.roles'), array('class' => 'control-label')) !!}
      {!! Form::text('roles', Input::old('roles', implode(', ', array_fetch($user->roles()->get(array('role'))->toArray(), 'role'))),array('class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('active')) has-error has-feedback @endif">
      {!! Form::label('active', trans('users.active'), array('class' => 'control-label')) !!}
      {!! Form::checkbox('active','1',array('class' => 'form-control')) !!}
    </div>

        <div class="form-group">
      {!! Form::submit(trans('users.update'), array('class' => 'btn btn-info')) !!}
      {!! link_to_route('users.index', trans('users.cancel'), $user->id, array('class' => 'btn btn-default')) !!}
        </div>
{!! Form::close() !!}

@stop
