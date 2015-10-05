@extends('backend.layout')

@section('main')

<h1 class="page-header">{!! trans('blog_posts.all_posts') !!}</h1>

<div class="row">
   <div class="col-xs-12 col-md-8">


      <a href="{!! route('posts.create') !!}" class="btn btn-success"
         title="{!! trans('blog_posts.add_new_post') !!}" id="create_button"><span
            class="glyphicon glyphicon-plus"></span> {!! trans('blog_posts.add_new_post') !!}</a>

      <button type="button" class="btn btn-default" id="btn-search"> <span class="glyphicon glyphicon-search"></span> {!! trans('blog_posts.search') !!} </button>

      {!! Form::model($posts, array('method' => 'GET', 'route' => array('posts.index'), 'role' => 'form', 'class' => 'navbar-form navbar-right') ) !!}
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
   <div class="col-xs-6 col-md-4">

      <button class="btn btn-info"
              title="{!! trans('blog_posts.categories') !!}" id="categories_editor" data-toggle="modal"
              data-target="#catEditor"><span
            class="glyphicon glyphicon-list-alt"></span> {!! trans('blog_posts.categories') !!}</button>
   </div>
</div>

<p>
   {!! Form::model($posts, array('method' => 'GET', 'route' => array('posts.index'), 'role' => 'form', 'class' => (isset($filter['filter']) ?  'form-inline form-search' : 'form-inline form-search'), 'style' => (isset($filter['filter']) ?  '' : 'display:none') )) !!}
<div class="well">

   <div class="form-group">
      {!! Form::label('title', trans('blog_posts.title'), array('class' => 'sr-only')) !!}
      {!! Form::text('title', $filter['title'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('users.title'))) !!}
   </div>

   <div class="form-group">
      {!! Form::label('description', trans('blog_posts.description'), array('class' => 'sr-only')) !!}
      {!! Form::text('description', $filter['description'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('blog_posts.description'))) !!}
   </div>

   <div class="form-group">
      {!! Form::label('active', trans('blog_posts.active'), array('class' => 'control-label')) !!}
      {!! Form::select('active', [''=>'-','1'=>trans('general.yes'),'0'=>trans('general.no')], $filter['active'], array('class' => 'form-control input-sm')) !!}
   </div>

   {!! Form::submit(trans('blog_posts.search'), array('class' => 'btn btn-info btn-sm')) !!}
   {!! link_to_route('posts.index', trans('blog_posts.clear'), array('filter'=>'reset'), array('class' => 'btn btn-default btn-sm')) !!}
   {!! Form::hidden('filter','apply') !!}
</div>
{!! Form::close() !!}
</p>

@if (count($posts))
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
<p class="text-center">
   {!! trans('blog_posts.no_posts') !!}</p>
@endif

@include('backend.blog.categories.index')
@include('backend.blog.categories.edit')
@stop
