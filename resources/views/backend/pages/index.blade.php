@extends('backend.layout')

@section('main')

    <h1 class="page-header">{!! trans('pages.all_pages') !!}</h1>

    <p>
        <a href="{!! route('pages.create') !!}" class="btn btn-success"
           title="{!! trans('pages.add_new_page') !!}"><span
                    class="glyphicon glyphicon-plus"></span> {!! trans('pages.add_new_page') !!}</a>
        @if ($pages->count())
            <a href="{!! route('pages.index') !!}" class="btn disabled btn-danger" title="{!! trans('pages.delete') !!}"
               id="delete_button"><i class="glyphicon glyphicon-trash"></i> {!! trans('pages.delete') !!}</a>
            <a href="{!! route('pages.index') !!}" class="btn disabled btn-default" title="{!! trans('pages.edit') !!}"
               id="edit_button"><i class="glyphicon glyphicon-edit"></i> {!! trans('pages.edit') !!}</a>
    </p>
    <input type="hidden" name="_token" id="csrf_token" value="{!! csrf_token() !!}"/>
    <br/>
    <table class="table table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>{!! trans('pages.page_') !!}</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($pages as $page)
            <tr>
                <td class="col-md-0">{!! FORM::radio('id',$page->id,false, array('id'=>'id_'.$page->id)) !!}</td>
                <td>{!! Form::label('id_'.$page->id, $page->title) !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <?php echo $pages->render(); ?>
    @else
    </p>
    {!! trans('pages.no_pages') !!}
    @endif

@stop
