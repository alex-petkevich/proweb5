@extends('frontend.layout_clean')

@section('content')
<div class="container">

{!! Form::open(array('route' => 'login.register', 'role' => 'form','class' => 'form-signup')) !!}
<h2 class="form-signin-heading">{{{ trans('login.register') }}}</h2>

    <div class="form-group @if ($errors->has('email')) has-error has-feedback @endif">
      {!! Form::label('email', trans('login.email'), array('class' => 'control-label')) !!}
      {!! Form::text('email',null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('username')) has-error has-feedback @endif">
      {!! Form::label('username', trans('login.username'), array('class' => 'control-label')) !!}
      {!! Form::text('username',null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('password')) has-error has-feedback @endif">
      {!! Form::label('password', trans('login.password'), array('class' => 'control-label')) !!}
      {!! Form::password('password',array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
      {!! Form::submit(trans('login.submit'), array('class' => 'btn btn-info')) !!}
    </div>
{!! Form::close() !!}
  </div>
       
@if (is_array($errors))
   @include('frontend.partials.errors', $errors)
@endif

@stop