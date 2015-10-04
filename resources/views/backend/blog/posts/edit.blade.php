@extends('backend.layout')

@section('main')
    @if ($errors->any())
        <ul class="alert alert-warning error-list">
            {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
        </ul>
    @endif

    <div class="col-xs-10">

        @if ($post->id)
            <h1 class="post-header">{!! trans('blog_posts.edit_post') !!}</h1>
            {!! Form::model($post, array('method' => 'PATCH', 'route' => array('posts.update', $post->id), 'post' => 'form')) !!}
        @else
            <h1 class="post-header">{!! trans('blog_posts.create_post') !!}</h1>
            {!! Form::open(array('route' => 'posts.store', 'post' => 'form', 'id'=>'mainForm')) !!}
        @endif
        <div class="form-group @if ($errors->has('category')) has-error has-feedback @endif">
            {!! Form::label('category', trans('blog_posts.category'), array('class' => 'control-label')) !!} (<a
                    href="javascript:" id="categories" data-toggle="modal"
                    data-target="#catSelector">{!! trans('blog_posts.select') !!}</a>)
            {!! Form::text('categories', Input::old('categories', implode(', ', array_pluck($post->categories()->get(array('title'))->toArray(), 'title'))),array('class' => 'form-control', 'id' => 'categories-view', 'disabled'=>'1')) !!}
            {!! Form::hidden('categories_ids',implode(', ', array_pluck($post->categories()->get(array('blog_category_id'))->toArray(), 'id')), array('id'=>'categories-hidden')) !!}
        </div>
        <div class="form-group @if ($errors->has('name')) has-error has-feedback @endif">
            {!! Form::label('name', trans('blog_posts.name'), array('class' => 'control-label')) !!}
            {!! Form::text('name',$post->name, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group @if ($errors->has('title')) has-error has-feedback @endif">
            {!! Form::label('title', trans('blog_posts.post'), array('class' => 'control-label')) !!}
            {!! Form::text('title',$post->title, array('class' => 'form-control')) !!}
        </div>

        <div class="form-group @if ($errors->has('description')) has-error has-feedback @endif">
            {!! Form::label('description', trans('blog_posts.description')) !!}
            {!! Form::textarea('description',$post->description, array('class' => 'form-control')) !!}
        </div>

        <div class="checkbox @if ($errors->has('is_comments')) has-error has-feedback @endif">
            <label>
                {!! Form::checkbox('is_comments','1',(!$post->id && Request::getMethod() == 'GET' || $post->is_comments ? true : false), array('id' => 'is_comments')) !!}
                {!! trans('blog_posts.is_comments') !!}
            </label>
        </div>
        <div class="form-group">
            <button class="btn btn-default btn-block"
                    id="btn_additional_options"><span class="glyphicon glyphicon-tasks"
                                                      aria-hidden="true"></span> {!! trans('blog_posts.additional_options') !!}
            </button>
        </div>

        <div id="additional_options" style="display:none;">
            <div class="form-group @if ($errors->has('meta_title')) has-error has-feedback @endif">
                {!! Form::label('meta_title', trans('blog_posts.meta_title'), array('class' => 'control-label')) !!}
                {!! Form::text('meta_title',$post->meta_title, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group @if ($errors->has('meta_description')) has-error has-feedback @endif">
                {!! Form::label('meta_description', trans('blog_posts.meta_description'), array('class' => 'control-label')) !!}
                {!! Form::text('meta_description',$post->meta_description, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group @if ($errors->has('meta_keywords')) has-error has-feedback @endif">
                {!! Form::label('meta_keywords', trans('blog_posts.meta_keywords'), array('class' => 'control-label')) !!}
                {!! Form::text('meta_keywords',$post->meta_keywords, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group @if ($errors->has('only_for_roles')) has-error has-feedback @endif">
                {!! Form::label('only_for_roles', trans('blog_posts.only_for_roles'), array('class' => 'control-label')) !!}
                {!! Form::text('only_for_roles',$post->only_for_roles, array('class' => 'form-control')) !!}
            </div>

            <div class="form-group @if ($errors->has('file')) has-error has-feedback @endif">
                {!! Form::label('file', trans('blog_posts.avatar'), array('class' => 'control-label')) !!}
                {!! Form::file('file') !!}
                @if ($errors->has('file')) <span class="glyphicon glyphicon-remove form-control-feedback"></span> @endif
                <img src="{!! Imagecache::get($post->avatar, '150x150resize')->src  !!}" id="thumb"
                     style="max-width:150px; max-height: 150px;@if ($post->avatar == '') display: none;@endif"
                     class="img-thumbnail">
                {!! Form::hidden('avatar', $post->avatar) !!}
                <div class="error alert alert-danger" style="display: none;"></div>
            </div>

        </div>

        <div class="form-group">
            {!! Form::submit(trans('blog_posts.submit_draft'), array('class' => 'btn btn-info', 'id' => 'draft')) !!}
            {!! Form::submit(trans('blog_posts.submit_publish'), array('class' => 'btn btn-danger', 'id' => 'publish')) !!}
            {!! link_to_route('posts.index', trans('blog_posts.cancel'), null, array('class' => 'btn btn-default')) !!}
        </div>
        <input type='hidden' name='active' value='0' id='active'/>
        {!! Form::close() !!}
    </div>
    @include('backend.blog.categories.select')
@stop

@section('scripts')
    <script src="{!! asset('vendor/tinymce/tinymce.min.js') !!}"></script>
    <script src="{!! asset('vendor/tinymce/jquery.tinymce.min.js') !!}"></script>
    <script type="text/javascript">

        $('#publish').on('click', function () {
            $('#active').val("1");
            return true;
        });
        $('#btn_additional_options').click(function () {
            $('#additional_options').toggle(1000);
            return false;
        });
        $('#categories').click(function () {

        });
        tinymce.init({
            selector: "#description",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
            image_advtab: true,
            external_filemanager_path: "{!! asset('vendor/filemanager/') !!}/",
            filemanager_title: "Менеджер файлов",
            external_plugins: {"filemanager": "{!! asset('vendor/filemanager/plugin.min.js') !!}"},
            language: "ru"
        });
        $(document).ready(function () {
            function split(val) {
                return val.split(/,\s*/);
            }

            function extractLast(term) {
                return split(term).pop();
            }

            $("#only_for_roles")
                    .bind("keydown", function (event) {
                        if (event.keyCode === $.ui.keyCode.TAB &&
                                $(this).data("ui-autocomplete").menu.active) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        source: function (request, response) {
                            $.getJSON("/roles", {
                                        term: extractLast(request.term),
                                    },
                                    function (data) {
                                        response($.map(data, function (item) {
                                            return {
                                                value: item.role
                                            }
                                        }))
                                    }
                            );
                        },
                        search: function () {
                            var term = extractLast(this.value);
                            if (term.length < 2) {
                                return false;
                            }
                        },
                        focus: function () {
                            return false;
                        },
                        select: function (event, ui) {
                            console.log(ui);
                            console.log(this);
                            var terms = split(this.value);
                            terms.pop();
                            terms.push(ui.item.value);
                            terms.push("");
                            this.value = terms.join(", ");
                            return false;
                        }
                    });

            var uploadInput = $('#file'),
                    imageInput = $('[name="avatar"]'),
                    thumb = document.getElementById('thumb'),
                    error = $('div.error');
            uploadInput.on('change', function () {
                var data = new FormData();
                data.append('file', uploadInput[0].files[0]);
                $.ajax({
                    url: '/posts/upload',
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (result) {
                        if (result.filelink) {
                            thumb.style.display = 'block';
                            thumb.setAttribute('src', result.filelink);
                            imageInput.val(result.filelink);
                            error.hide();
                        } else {
                            error.text(result.message);
                            error.show();
                        }
                    },
                    error: function (result) {
                        error.text("{{ trans('posts.upload_error') }}");
                        error.show();
                    }
                });
            });
        });

    </script>
@stop