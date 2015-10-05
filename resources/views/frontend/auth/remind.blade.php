@extends('frontend.layout_clean')

@section('content')
    <div class="container">

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {!! Session::get('error') !!}
            </div>
        @elseif (Session::has('status'))
            <div class="alert alert-success">
                {!! Session::get('status') !!}
            </div>
        @endif

        {!! Form::open(array('route' => 'password.remind','role' => 'form','class' => 'form-signin',)) !!}
        {!! csrf_field() !!}
        <h2 class="form-signin-heading">{{{ trans('auth.forgot_password') }}}</h2>

        <div class="form-group">
            {!! Form::label('email', trans('auth.your_email'), array('class' => 'control-label'))!!}
            {!! Form::email('email',null, array('class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(trans('auth.send_reminder'), array('class' => 'btn btn-info')) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop