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

            <div class="form-group @if ($errors->has('title')) has-error has-feedback @endif">
                {!! Form::label('title', trans('proposals.title'), array('class' => 'control-label')) !!}
                {!! Form::text('title',$proposal->title, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group @if ($errors->has('description')) has-error has-feedback @endif">
            {!! Form::label('description', trans('proposals.description')) !!}
            {!! Form::textarea('description',$proposal->description, array('class' => 'form-control')) !!}
        </div>

            <div class="form-group @if ($errors->has('published_at')) has-error has-feedback @endif">
                {!! Form::label('published_at', trans('proposals.published_at'), array('class' => 'control-label')) !!}

                <div class='input-group date' id='publishpicker'>
                    {!! Form::text('published_at',$proposal->published_at, array('class' => 'form-control')) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                </div>

            </div>
        <div class="form-group">
            {!! Form::submit(trans('proposals.submit'), array('class' => 'btn btn-info', 'id' => 'draft')) !!}
            {!! link_to_route('proposals.index', trans('proposals.cancel'), null, array('class' => 'btn btn-default')) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('scripts')
    <script src="{!! asset('vendor/tinymce/tinymce.min.js') !!}"></script>
    <script src="{!! asset('vendor/tinymce/jquery.tinymce.min.js') !!}"></script>
    <script type="text/javascript">

        $(function () {
            $('#publishpicker').datetimepicker({
                locale: 'ru',
                showTodayButton: true,
                format: 'YYYY-MM-DD'
            });
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
    </script>
@stop