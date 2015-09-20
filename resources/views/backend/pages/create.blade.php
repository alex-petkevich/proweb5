@extends('backend.layout')

@section('main')
@if ($errors->any())
<ul class="alert alert-warning error-list">
   {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
</ul>
@endif

<div class="col-xs-10">


   <h1 class="page-header">{!! trans('pages.create_page') !!}</h1>
   {!! Form::open(array('route' => 'pages.store', 'page' => 'form')) !!}
   <div class="form-group @if ($errors->has('parent_id')) has-error has-feedback @endif">
      {!! Form::label('parent_id', trans('pages.parent_id'), array('class' => 'control-label')) !!}
      {!! Form::select('parent_id',$catalog,$page->parent_id, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('name')) has-error has-feedback @endif">
      {!! Form::label('name', trans('pages.name'), array('class' => 'control-label')) !!}
      {!! Form::text('name',null, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('title')) has-error has-feedback @endif">
      {!! Form::label('title', trans('pages.page'), array('class' => 'control-label')) !!}
      {!! Form::text('title',null, array('class' => 'form-control')) !!}
   </div>

   <div class="checkbox @if ($errors->has('show_title')) has-error has-feedback @endif">
      <label>
         {!! Form::checkbox('show_title','1',null, array('id' => 'show_title')) !!}
         {!! trans('pages.show_title') !!}
      </label>
   </div>
   <div class="form-group @if ($errors->has('meta_title')) has-error has-feedback @endif">
      {!! Form::label('meta_title', trans('pages.meta_title'), array('class' => 'control-label')) !!}
      {!! Form::text('meta_title',null, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('meta_description')) has-error has-feedback @endif">
      {!! Form::label('meta_description', trans('pages.meta_description'), array('class' => 'control-label')) !!}
      {!! Form::text('meta_description',null, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('meta_keywords')) has-error has-feedback @endif">
      {!! Form::label('meta_keywords', trans('pages.meta_keywords'), array('class' => 'control-label')) !!}
      {!! Form::text('meta_keywords',null, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('only_for_roles')) has-error has-feedback @endif">
      {!! Form::label('only_for_roles', trans('pages.only_for_roles'), array('class' => 'control-label')) !!}
      {!! Form::text('only_for_roles',null, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('description')) has-error has-feedback @endif">
      {!! Form::label('description', trans('pages.description')) !!}
      {!! Form::textarea('description',null, array('class' => 'form-control')) !!}
   </div>

   <div class="checkbox @if ($errors->has('active')) has-error has-feedback @endif">
      <label>
         {!! Form::checkbox('active','1',null, array('id' => 'active')) !!}
         {!! trans('pages.active') !!}
      </label>
   </div>

   <div class="form-group">
      {!! Form::submit(trans('pages.submit'), array('class' => 'btn btn-info')) !!}
      {!! link_to_route('pages.index', trans('pages.cancel'), null, array('class' => 'btn btn-default')) !!}
   </div>
   {!! Form::close() !!}
</div>

@stop

@section('scripts')
<script src="{!! asset('vendor/tinymce/tinymce.min.js') !!}"></script>
<script src="{!! asset('vendor/tinymce/jquery.tinymce.min.js') !!}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#active").bootstrapSwitch({
            'size': 'small'
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