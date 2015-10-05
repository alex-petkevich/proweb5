@extends('backend.layout')

@section('main')

    <h1 class="page-header">{!! trans('roles.show_role') !!}</h1>

    <p>{!! link_to_route('roles.index', trans('roles.return_all')) !!}</p>

    <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
        <tr>
            <th>{!! trans('roles.role_') !!}</th>
            <th></th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>{{{ $role->role }}}</td>
            <td>{!! link_to_route('roles.edit', trans('roles.edit'), array($role->id), array('class' => 'btn btn-info')) !!}</td>
            <td>
                {!! Form::open(array('method' => 'DELETE', 'route' => array('roles.destroy', $role->id))) !!}
                {!! Form::submit(trans('roles.delete'), array('class' => 'btn btn-danger')) !!}
                {!! Form::close() !!}
            </td>
        </tr>
        </tbody>
    </table>

@stop
