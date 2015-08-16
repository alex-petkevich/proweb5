@extends('frontend.layout_clean')

@section('content')
   <div class="container">
@if (Session::has('error'))
         <div class="alert alert-danger">
   {!! trans(Session::get('reason')) !!}
</div>
@endif


      {!! Form::open(array('role' => 'form','class' => 'form-signin',)) !!}
{!! Form::hidden('token', $token) !!}
      <h2 class="form-signin-heading">{!! trans('auth.reset_password') !!}</h2>

      <div class="form-group">
         {!! Form::label('email', trans('auth.email'), array('class' => 'control-label') )!!}
         {!! Form::email('email', Input::old('email'), array('class' => 'form-control')) !!}
      </div>

      <div class="form-group">
         {!!Form::label('password', trans('auth.new_password'), array('class' => 'control-label'))!!}
         {!! Form::password('password', array('class' => 'form-control'))!!}
      </div>

      <div class="form-group">
         {!!Form::label('password', trans('auth.new_password_confirm'), array('class' => 'control-label'))!!}
         {!! Form::password('password_confirmation', array('class' => 'form-control'))!!}
      </div>

      <div class="form-group">
{!! Form::submit(trans('auth.reset'), array('class' => 'btn'))!!}
      </div>
{!! Form::close() !!}
   </div>
@stop