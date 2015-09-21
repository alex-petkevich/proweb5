@extends('backend.layout')

@section('main')
@if ($errors->any())
<ul class="alert alert-warning error-list">
   {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
</ul>
@endif

<div class="col-xs-10">

    @if ($page->id)
        <h1 class="page-header">{!! trans('pages.edit_page') !!}</h1>
        {!! Form::model($page, array('method' => 'PATCH', 'route' => array('pages.update', $page->id), 'page' => 'form')) !!}
    @else
   <h1 class="page-header">{!! trans('pages.create_page') !!}</h1>
        {!! Form::open(array('route' => 'pages.store', 'page' => 'form', 'id'=>'mainForm')) !!}
    @endif    
   <div class="form-group @if ($errors->has('parent_id')) has-error has-feedback @endif">
      {!! Form::label('parent_id', trans('pages.parent_id'), array('class' => 'control-label')) !!}
      {!! Form::select('parent_id',$catalog,$page->parent_id, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('name')) has-error has-feedback @endif">
      {!! Form::label('name', trans('pages.name'), array('class' => 'control-label')) !!}
       {!! Form::text('name',$page->name, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('title')) has-error has-feedback @endif">
      {!! Form::label('title', trans('pages.page'), array('class' => 'control-label')) !!}
       {!! Form::text('title',$page->title, array('class' => 'form-control')) !!}
   </div>

   <div class="checkbox @if ($errors->has('show_title')) has-error has-feedback @endif">
      <label>
          {!! Form::checkbox('show_title','1',$page->show_title, array('id' => 'show_title')) !!}
         {!! trans('pages.show_title') !!}
      </label>
   </div>
   <div class="form-group @if ($errors->has('meta_title')) has-error has-feedback @endif">
      {!! Form::label('meta_title', trans('pages.meta_title'), array('class' => 'control-label')) !!}
       {!! Form::text('meta_title',$page->meta_title, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('meta_description')) has-error has-feedback @endif">
      {!! Form::label('meta_description', trans('pages.meta_description'), array('class' => 'control-label')) !!}
       {!! Form::text('meta_description',$page->meta_description, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('meta_keywords')) has-error has-feedback @endif">
      {!! Form::label('meta_keywords', trans('pages.meta_keywords'), array('class' => 'control-label')) !!}
       {!! Form::text('meta_keywords',$page->meta_keywords, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('only_for_roles')) has-error has-feedback @endif">
      {!! Form::label('only_for_roles', trans('pages.only_for_roles'), array('class' => 'control-label')) !!}
       {!! Form::text('only_for_roles',$page->only_for_roles, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('description')) has-error has-feedback @endif">
      {!! Form::label('description', trans('pages.description')) !!}
       {!! Form::textarea('description',$page->description, array('class' => 'form-control')) !!}
   </div>

   <div class="form-group">
      {!! Form::submit(trans('pages.submit_draft'), array('class' => 'btn btn-info', 'id' => 'draft')) !!}
      {!! Form::submit(trans('pages.submit_publish'), array('class' => 'btn btn-danger', 'id' => 'publish')) !!}
      {!! link_to_route('pages.index', trans('pages.cancel'), null, array('class' => 'btn btn-default')) !!}
   </div>
   <input type='hidden' name='active' value='0' id='active' />
   {!! Form::close() !!}
</div>
@stop

@section('scripts')
<script src="{!! asset('vendor/tinymce/tinymce.min.js') !!}"></script>
<script src="{!! asset('vendor/tinymce/jquery.tinymce.min.js') !!}"></script>
<script type="text/javascript">

           $('#publish').on('click', function(){
   $('#active').val("1");
           return true;
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
   });
</script>
@stop