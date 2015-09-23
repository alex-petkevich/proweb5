@extends('backend.layout')

@section('main')

<h1 class="page-header">{!! trans('posts.all_posts') !!}</h1>

<p>
   <a href="{!! route('posts.create') !!}" class="btn btn-success"
      title="{!! trans('blog.posts.add_new_post') !!}" id="create_button"><span
         class="glyphicon glyphicon-plus"></span> {!! trans('blog.posts.add_new_post') !!}</a>
   @if (count($posts))
   <a href="{!! route('posts.index') !!}" class="btn disabled btn-default" title="{!! trans('blog.posts.edit') !!}"
      id="edit_button"><i class="glyphicon glyphicon-edit"></i> {!! trans('blog.posts.edit') !!}</a>
   <a href="{!! route('posts.index') !!}" class="btn disabled btn-danger" title="{!! trans('blog.posts.delete') !!}"
      id="delete_button"><i class="glyphicon glyphicon-trash"></i> {!! trans('blog.posts.delete') !!}</a>
</p>
<input type="hidden" name="_token" id="csrf_token" value="{!! csrf_token() !!}"/>
<br/>
<table class="table table-striped table-hover table-condensed">
   <thead>
      <tr>
         <th></th>
         <th>{!! trans('blog.posts.post_') !!}</th>
      </tr>
   </thead>

   <tbody>
      @foreach ($posts as $post)
      @include('backend.blog.posts.partials.page', $page)
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