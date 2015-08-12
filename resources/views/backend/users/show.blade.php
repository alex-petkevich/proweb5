@extends('backend.layout')

@section('main')

<h1 class="page-header">{!! trans('users.show_user') !!}</h1>

<p>{!! link_to_route('users.index', trans('users.return_all')) !!}</p>

<table class="table table-striped table-bordered table-hover table-condensed">
   <thead>
   <tr>
      <th>{!! trans('users.username_') !!}</th>
      <th>{!! trans('users.email_') !!}</th>
      <th>{!! trans('users.roles_') !!}</th>
       <th></th>
       <th></th>
   </tr>
   </thead>

   <tbody>
   <tr>
      <td>{{{ $user->username }}}</td>
      <td>{{{ $user->email }}}</td>
      <td>
         @foreach($user->roles as $role)
         <span class="badge">{{{ $role->role }}}</span>
         @endforeach
      </td>
      <td>{!! link_to_route('users.edit', trans('users.edit'), array($user->id), array('class' => 'btn btn-info')) !!}</td>
      <td>
         {!! Form::open(array('method' => 'DELETE', 'route' => array('users.destroy', $user->id))) !!}
         {!! Form::submit(trans('users.delete'), array('class' => 'btn btn-danger')) !!}
         {!! Form::close() !!}
      </td>
   </tr>
   </tbody>
</table>

@stop