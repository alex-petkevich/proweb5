@extends('backend.layout')

@section('main')

<h1 class="page-header">{!! trans('pages.all_pages') !!}</h1>

<p>
   <a href="{!! route('pages.create') !!}" class="btn btn-success"
      title="{!! trans('pages.add_new_page') !!}" id="create_button"><span
         class="glyphicon glyphicon-plus"></span> {!! trans('pages.add_new_page') !!}</a>
   @if (count($pages))
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
      @include('backend.pages.partials.page', $page)
      @endforeach
   </tbody>
</table>
@else
</p>
{!! trans('pages.no_pages') !!}
@endif

@stop


@section('scripts')
<script type="text/javascript">

   $(document).ready(function () {
      $('#create_button').click(function () {
         if ($('input[name=id]:checked').val() != undefined)
            $('#create_button').prop('href', $('#create_button').prop('href') + '?parent_id=' + $('input[name=id]:checked').val());
         return true;
      });
   });
</script>
@stop