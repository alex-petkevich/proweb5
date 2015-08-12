@extends('frontend.layout')

@section('main')

@if (Session::has('error'))
<div class="alert alert-error">
   {!! trans(Session::get('reason')) !!}
</div>
@endif

<h1>{!! trans('reset_password') !!}</h1>

{!! Form::open() !!}
{!! Form::hidden('token', $token) !!}
<ul>
   <li>
      {!! Form::label('email', trans('auth.email') )!!}
      {!! Form::email('email', Input::old('email')) !!}
   </li>

   <li>
      {!!Form::label('password', trans('auth.new_password'))!!}
      {!! Form::password('password')!!}
   </li>

   <li>
      {!!Form::label('password', trans('auth.new_password_confirm'))!!}
      {!! Form::password('password_confirmation')!!}
   </li>

</ul>
{!! Form::submit(trans('auth.reset'), array('class' => 'btn'))!!}
{!! Form::close() !!}
@stop