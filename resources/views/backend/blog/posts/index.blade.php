@extends('backend.layout')

@section('main')

   <h1 class="page-header">{!! trans('blog_posts.all_posts') !!}</h1>

<p>
   <a href="{!! route('posts.create') !!}" class="btn btn-success"
      title="{!! trans('blog_posts.add_new_post') !!}" id="create_button"><span
              class="glyphicon glyphicon-plus"></span> {!! trans('blog_posts.add_new_post') !!}</a>
   @if (count($posts))
      <a href="{!! route('posts.index') !!}" class="btn disabled btn-default" title="{!! trans('blog_posts.edit') !!}"
         id="edit_button"><i class="glyphicon glyphicon-edit"></i> {!! trans('blog_posts.edit') !!}</a>
      <a href="{!! route('posts.index') !!}" class="btn disabled btn-danger" title="{!! trans('blog_posts.delete') !!}"
         id="delete_button"><i class="glyphicon glyphicon-trash"></i> {!! trans('blog_posts.delete') !!}</a>
</p>
<input type="hidden" name="_token" id="csrf_token" value="{!! csrf_token() !!}"/>
<br/>
<table class="table table-striped table-hover table-condensed">
   <thead>
      <tr>
         <th></th>
         <th>{!! trans('blog_posts.post_') !!}</th>
      </tr>
   </thead>

   <tbody>
      @foreach ($posts as $post)
         <tr @if (!$post['active']) class="tr-disabled" @endif id="tr-{!! $post['id'] !!}">
            <td class="col-md-0">{!! FORM::radio('id',$post['id'],false, array('id'=>'id_'.$post['id'])) !!}</td>
            <td>{!! Form::label('id_'.$post['id'], $post['title']) !!}</td>
         </tr>
      @endforeach
   </tbody>
</table>
   <?php echo $posts->render(); ?>
@else
</p>
   {!! trans('blog_posts.no_posts') !!}
@endif

@stop


@section('scripts')
<script type="text/javascript">

   $(document).ready(function () {

   });
</script>
@stop