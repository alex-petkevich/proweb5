@extends('backend.layout')

@section('main')

    <h1 class="page-header">{!! trans('roles.all_roles') !!}</h1>

    @if ($roles->count())
        <p>
            <a href="{!! route('roles.create') !!}" class="btn btn-success" title="{!! trans('roles.add_new_role') !!}"><span
                        class="glyphicon glyphicon-plus"></span> {!! trans('roles.add_new_role') !!}</a>
            <a href="{!! route('roles.index') !!}" class="btn disabled btn-danger" title="{!! trans('roles.delete') !!}"
               id="delete_button"><i class="glyphicon glyphicon-trash"></i> {!! trans('roles.delete') !!}</a>
            <a href="{!! route('roles.index') !!}" class="btn disabled btn-default" title="{!! trans('roles.edit') !!}"
               id="edit_button"><i class="glyphicon glyphicon-edit"></i> {!! trans('roles.edit') !!}</a>
        </p>
        <input type="hidden" name="_token" id="csrf_token" value="{!! csrf_token() !!}"/>
        <br/>
        <table class="table table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th></th>
                <th>{!! trans('roles.role_') !!}</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td class="col-md-0">{!! FORM::radio('id',$role->id,false, array('id'=>'id_'.$role->id)) !!}</td>
                    <td>{!! Form::label('id_'.$role->id, $role->role) !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <?php echo $roles->render(); ?>
    @else
        {!! trans('roles.no_roles') !!}
    @endif

@stop
