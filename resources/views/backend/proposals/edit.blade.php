@extends('backend.layout')

@section('main')
    @if ($errors->any())
        <ul class="alert alert-warning error-list">
            {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
        </ul>
    @endif

    <div class="col-xs-10">

        @if ($proposal->id)
            <h1 class="post-header">{!! trans('proposals.edit_proposal') !!}</h1>
            {!! Form::model($proposal, array('method' => 'PATCH', 'route' => array('proposals.update', $proposal->id), 'post' => 'form')) !!}
        @else
            <h1 class="post-header">{!! trans('proposals.create_proposal') !!}</h1>
            {!! Form::open(array('route' => 'proposals.store', 'post' => 'form', 'id'=>'mainForm')) !!}
        @endif

        <div class="form-group @if ($errors->has('category')) has-error has-feedback @endif">
            {!! Form::label('category', trans('proposals.category'), array('class' => 'control-label')) !!} (<a
                    href="javascript:" id="categories" data-toggle="modal"
                    data-target="#catSelector">{!! trans('proposals.select') !!}</a>)
            {!! Form::text('category', Input::old('category', implode(', ', array_pluck($proposal->category()->get(array('name'))->toArray(), 'name'))),array('class' => 'form-control', 'id' => 'categories-view', 'readonly'=>'1')) !!}
            {!! Form::hidden('category_id',$proposal->category_id, array('id'=>'categories-hidden')) !!}
        </div>

        <div class="form-group @if ($errors->has('name')) has-error has-feedback @endif">
            {!! Form::label('name', trans('proposals.name'), array('class' => 'control-label')) !!}
            {!! Form::text('name',$proposal->name, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group @if ($errors->has('link')) has-error has-feedback @endif">
            {!! Form::label('link', trans('proposals.link'), array('class' => 'control-label')) !!}
            {!! Form::text('link',$proposal->link, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group @if ($errors->has('file')) has-error has-feedback @endif">
            {!! Form::label('file', trans('proposals.img'), array('class' => 'control-label')) !!}
            {!! Form::file('file') !!}
            @if ($errors->has('file')) <span class="glyphicon glyphicon-remove form-control-feedback"></span> @endif
            <img src="{!! Imagecache::get($proposal->img, '150x150resize')->src  !!}" id="thumb"
                 style="max-width:150px; max-height: 150px;@if ($proposal->img == '') display: none;@endif"
                 class="img-thumbnail">
            {!! Form::hidden('img', $proposal->img) !!}
            <div class="error alert alert-danger" style="display: none;"></div>
        </div>

        <div class="form-group @if ($errors->has('description')) has-error has-feedback @endif">
            {!! Form::label('description', trans('proposals.description')) !!}
            {!! Form::textarea('description',$proposal->description, array('class' => 'form-control')) !!}
        </div>

        <div class="checkbox @if ($errors->has('active')) has-error has-feedback @endif">
            <label>
                {!! Form::checkbox('active','1',(!$proposal->id && Request::getMethod() == 'GET' || $proposal->active ? true : false), array('id' => 'active')) !!}
                {!! trans('proposals.active') !!}
            </label>
        </div>

        <div class="form-group">
            {!! Form::submit(trans('proposals.submit'), array('class' => 'btn btn-info', 'id' => 'draft')) !!}
            {!! link_to_route('proposals.index', trans('proposals.cancel'), null, array('class' => 'btn btn-default')) !!}
        </div>
        {!! Form::close() !!}
    </div>
    @include('backend.proposals.categories.select')
@stop

@section('scripts')
    <script src="{!! asset('vendor/tinymce/tinymce.min.js') !!}"></script>
    <script src="{!! asset('vendor/tinymce/jquery.tinymce.min.js') !!}"></script>
    <script type="text/javascript">
        $('#categories').click(function () {

        });
        $(document).ready(function () {
            var uploadInput = $('#file'),
                    imageInput = $('[name="img"]'),
                    thumb = document.getElementById('thumb'),
                    error = $('div.error');
            uploadInput.on('change', function () {
                var data = new FormData();
                data.append('file', uploadInput[0].files[0]);
                $.ajax({
                    url: '/proposals/upload',
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
                        error.text("{{ trans('proposals.upload_error') }}");
                        error.show();
                    }
                });
            });
        });

    </script>
@stop