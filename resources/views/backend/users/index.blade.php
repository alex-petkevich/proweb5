@extends('backend.layout')

@section('main')

<h1 class="page-header">{!! trans('users.all_users') !!}</h1>

<div>

   <a href="{!! route('users.create') !!}" class="btn btn-success" id="btn-add"> <span class="glyphicon glyphicon-plus"></span> {!! trans('users.add_new_user') !!} </a>
   <button type="button" class="btn btn-default" id="btn-search"> <span class="glyphicon glyphicon-search"></span> {!! trans('users.search') !!} </button>

{!! Form::model($users, array('method' => 'GET', 'route' => array('users.index'), 'role' => 'form', 'class' => 'navbar-form navbar-right') ) !!}
   <div class="form-group">
      {!! Form::label('sort_by', trans('general.sort_by'), array('class' => 'control-label')) !!}
      {!! Form::select('sort_value', $sort_options, $sort['value'], array('class' => 'form-control input-sm')) !!}
   </div>

   <div class="form-group">
      {!! Form::label('sort_dir', trans('general.sort_dir'), array('class' => 'sr-only')) !!}
      {!! Form::select('sort_dir', [''=>'-','0'=>trans('general.sort_asc'),'1'=>trans('general.sort_desc')], $sort['dir'], array('class' => 'form-control input-sm')) !!}
   </div>

   <div class="form-group">
      {!! Form::submit(trans('general.sort'), array('class' => 'btn btn-default btn-sm')) !!}
   </div>

{!! Form::close() !!}

 </div>

 <p>
{!! Form::model($users, array('method' => 'GET', 'route' => array('users.index'), 'role' => 'form', 'class' => (isset($filter['filter']) ?  'form-inline form-search' : 'form-inline hide form-search') )) !!}
<div class="well">

  <div class="form-group">
    {!! Form::label('email', trans('users.email'), array('class' => 'sr-only')) !!}
    {!! Form::text('email', $filter['email'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('users.email_'))) !!}
  </div>

  <div class="form-group">
    {!! Form::label('username', trans('users.username'), array('class' => 'sr-only')) !!}
    {!! Form::text('username', $filter['username'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('users.username_'))) !!}
  </div>

  <div class="form-group">
    {!! Form::label('active', trans('users.active'), array('class' => 'control-label')) !!}
    {!! Form::select('active', [''=>'-','1'=>trans('general.yes'),'0'=>trans('general.no')], $filter['active'], array('class' => 'form-control input-sm')) !!}
  </div>

  {!! Form::submit(trans('users.search'), array('class' => 'btn btn-info btn-sm')) !!}
  {!! link_to_route('users.index', trans('users.clear'), array('filter'=>'reset'), array('class' => 'btn btn-default btn-sm')) !!}
  {!! Form::hidden('filter','apply') !!}
  </div>
{!! Form::close() !!}
</p>

@if ($users->count())

<table class="table table-striped table-hover table-condensed">
   <thead>
   <tr>
      <th>{!! trans('users.username_') !!}</th>
      <th>{!! trans('users.email_') !!}</th>
      <th>{!! trans('users.roles_') !!}</th>
      <th colspan="2">

      </th>
   </tr>
   </thead>

   <tbody>
   @foreach ($users as $user)
   <tr @if (!$user->active) class="tr-disabled" @endif>
      <td>{{{ $user->username }}}</td>
      <td>{{{ $user->email }}}</td>
      <td>
         @foreach($user->roles as $role)
         <span class="badge">{{{$role->role}}}</span>
         @endforeach
      </td>
      <td>{!! link_to_route('users.edit', trans('users.edit'), array($user->id), array('class' => 'btn btn-info btn-sm')) !!}</td>
      <td>
         {!! Form::open(array('method' => 'DELETE', 'route' => array('users.destroy', $user->id))) !!}
         {!! Form::submit(trans('users.delete'), array('class' => 'btn btn-danger btn-sm')) !!}
         {!! Form::close() !!}
      </td>
   </tr>
   @endforeach
   </tbody>
</table>
	<?php echo $users->render(); ?>
@else
   {!! trans('users.no_users') !!}
@endif

@stop