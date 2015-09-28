@extends('backend.layout')

@section('main')

    <h1 class="page-header">{!! trans('blog_posts.all_posts') !!}</h1>

    <div class="row">
        <div class="col-xs-12 col-md-8">
            <a href="{!! route('posts.create') !!}" class="btn btn-success"
               title="{!! trans('blog_posts.add_new_post') !!}" id="create_button"><span
                        class="glyphicon glyphicon-plus"></span> {!! trans('blog_posts.add_new_post') !!}</a>
            @if (count($posts))
                <a href="{!! route('posts.index') !!}" class="btn disabled btn-default"
                   title="{!! trans('blog_posts.edit') !!}"
                   id="edit_button"><i class="glyphicon glyphicon-edit"></i> {!! trans('blog_posts.edit') !!}</a>
                <a href="{!! route('posts.index') !!}" class="btn disabled btn-danger"
                   title="{!! trans('blog_posts.delete') !!}"
                   id="delete_button"><i class="glyphicon glyphicon-trash"></i> {!! trans('blog_posts.delete') !!}</a>
            @endif
        </div>
        <div class="col-xs-6 col-md-4">

            <button class="btn btn-info"
                    title="{!! trans('blog_posts.categories') !!}" id="categories_editor" data-toggle="modal"
                    data-target="#catEditor"><span
                        class="glyphicon glyphicon-list-alt"></span> {!! trans('blog_posts.categories') !!}</button>
        </div>
    </div>

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
@stop


@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {

        });
    </script>
@stop