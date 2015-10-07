@extends('backend.layout')

@section('main')
@if ($errors->any())
<ul class="alert alert-warning error-list">
   {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
</ul>
@endif

<div class="col-xs-10">

   @if ($promo->id)
   <h1 class="post-header">{!! trans('promos.edit_promo') !!}</h1>
   {!! Form::model($promo, array('method' => 'PATCH', 'route' => array('promos.update', $promo->id), 'post' => 'form')) !!}
   @else
   <h1 class="post-header">{!! trans('promos.create_promo') !!}</h1>
   {!! Form::open(array('route' => 'promos.store', 'post' => 'form', 'id'=>'mainForm')) !!}
   @endif

   <div class="form-group @if ($errors->has('category')) has-error has-feedback @endif">
      {!! Form::label('category', trans('promos.category'), array('class' => 'control-label')) !!} (<a
         href="javascript:;" id="categories" data-toggle="modal"
         data-target="#catSelector">{!! trans('promos.select') !!}</a>)
      {!! Form::text('category', Input::old('category', implode(', ', array_pluck($promo->category()->get(array('name'))->toArray(), 'name'))),array('class' => 'form-control', 'id' => 'categories-view', 'readonly'=>'1')) !!}
      {!! Form::hidden('category_id',$promo->category_id, array('id'=>'categories-hidden')) !!}
   </div>

   <div class="form-group @if ($errors->has('name')) has-error has-feedback @endif">
      {!! Form::label('name', trans('promos.name'), array('class' => 'control-label')) !!}
      {!! Form::text('name',$promo->name, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('link')) has-error has-feedback @endif">
      {!! Form::label('link', trans('promos.link'), array('class' => 'control-label')) !!}
      {!! Form::text('link',$promo->link, array('class' => 'form-control')) !!}
   </div>
   <div class="form-group @if ($errors->has('file')) has-error has-feedback @endif">
      {!! Form::label('file', trans('promos.img'), array('class' => 'control-label')) !!}
      {!! Form::file('file') !!}
      @if ($errors->has('file')) <span class="glyphicon glyphicon-remove form-control-feedback"></span> @endif
      <img src="{!! Imagecache::get($promo->img, '150x150resize')->src  !!}" id="thumb"
           style="max-width:150px; max-height: 150px;@if ($promo->img == '') display: none;@endif"
           class="img-thumbnail">
      {!! Form::hidden('img', $promo->img) !!}
      <div class="error alert alert-danger" style="display: none;"></div>
   </div>

   <div class="form-group @if ($errors->has('description')) has-error has-feedback @endif">
      {!! Form::label('description', trans('promos.description')) !!}
      {!! Form::textarea('description',$promo->description, array('class' => 'form-control')) !!}
   </div>

   <div class="checkbox @if ($errors->has('active')) has-error has-feedback @endif">
      <label>
         {!! Form::checkbox('active','1',(!$promo->id && Request::getMethod() == 'GET' || $promo->active ? true : false), array('id' => 'active')) !!}
         {!! trans('promos.active') !!}
      </label>
   </div>

   <div class="form-group">
      {!! Form::submit(trans('promos.submit'), array('class' => 'btn btn-info', 'id' => 'draft')) !!}
      {!! link_to_route('promos.index', trans('promos.cancel'), null, array('class' => 'btn btn-default')) !!}
   </div>
   {!! Form::close() !!}
</div>
@include('backend.promos.categories.select')
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
                   url: '/promos/upload',
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
                           error.text("{{ trans('promos.upload_error') }}");
                                   error.show();
                           }
                   });
           });
   });

</script>
@stop