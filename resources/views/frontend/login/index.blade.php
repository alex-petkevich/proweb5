@extends('frontend.layout_clean')

@section('content')

<div class="container">
{!! Form::open(array('route' => 'login.index','class' => 'form-signin', 'role' => 'form')) !!}
        <h2 class="form-signin-heading">{{{ trans('login.login') }}}</h2>
            {!! Form::text('email','', array('class' => 'form-control','placeholder' => 'Email address')) !!}
            {!! Form::password('password', array('class' => 'form-control','placeholder' => 'Password')) !!}
            <label class="checkbox">
              <input type="checkbox" value="remember-me"> Remember me
            </label>
         {!! Form::submit(trans('login.submit'), array('class' => 'btn btn-lg btn-primary btn-block')) !!}
    <br/>
    <p>{!! link_to_route('password.remind',  trans('login.forgot_password')) !!}</p>

{!! Form::close() !!}

@if (is_array($errors))
   @include('frontend.partials.errors', $errors)
@endif

</div>

@stop