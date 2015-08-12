@extends('backend.layout')

@section('main')
@if ($errors->any())
	<ul class="alert alert-warning error-list">
		{!! implode('', $errors->all('<li class="error">:message</li>')) !!}
	</ul>
@endif

<div class="col-xs-4">


<h1 class="page-header">{!! trans('roles.create_role') !!}</h1>
{!! Form::open(array('route' => 'roles.store', 'role' => 'form')) !!}
        <div class="form-group @if ($errors->has('role')) has-error has-feedback @endif">
            {!! Form::label('role', trans('roles.role'), array('class' => 'control-label')) !!}
            {!! Form::text('role',null, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group @if ($errors->has('description')) has-error has-feedback @endif">
            {!! Form::label('description', trans('roles.description'), array('class' => 'control-label')) !!}
            {!! Form::textarea('description',null, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group">
			{!! Form::submit(trans('roles.submit'), array('class' => 'btn btn-info')) !!}
			{!! link_to_route('roles.index', trans('roles.cancel'), null, array('class' => 'btn btn-default')) !!}
        </div>
{!! Form::close() !!}
</div>

@stop


