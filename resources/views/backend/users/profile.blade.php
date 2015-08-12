@extends( ( Auth::user()->isAdmin() ? 'backend.layout' : 'frontend.layout' ))

@section('main')
<div class="col-xs-5">
    <h1>{!! trans('users.edit_user') !!}</h1>
    {!! Form::model($user, array('method' => 'PATCH', 'route' => array('users.update', $user->id), 'role' => 'form')) !!}
    <div class="form-group @if ($errors->has('username')) has-error has-feedback @endif">
        {!! Form::label('username', trans('users.username'), array('class' => 'control-label')) !!}
        {!! Form::text('username', $user->username, array('disabled'=>1,'class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('email')) has-error has-feedback @endif">
        {!! Form::label('email', trans('users.email'), array('class' => 'control-label')) !!}
        {!! Form::text('email', $user->email, array('disabled'=>1,'class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit(trans('users.update'), array('class' => 'btn btn-info')) !!}
        {!! link_to_route('users.index', trans('users.cancel'), $user->id, array('class' => 'btn btn-default')) !!}
    </div>
    {!! Form::close() !!}
</div>


@stop
