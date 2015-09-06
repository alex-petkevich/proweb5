@extends('backend.users.edit.parent_tabs')

@section('tab_content')


<div class="form-group @if ($errors->has('birthdate')) has-error has-feedback @endif">
   {!! Form::label('birthdate', trans('users.birthdate'), array('class' => 'control-label')) !!}


   <div class='input-group date' id='datetimepicker1'>
      {!! Form::text('birthdate', $user->birthdate, array('class' => 'form-control')) !!}
      <span class="input-group-addon">
         <span class="glyphicon glyphicon-calendar"></span>
      </span>
   </div>

   <script type="text/javascript">
      $(function () {
         $('#datetimepicker1').datetimepicker({
            locale: 'ru',
            showTodayButton: true,
            format: 'YYYY-MM-DD'
         });
      });
   </script>

</div>

<div class="form-group @if ($errors->has('fullname')) has-error has-feedback @endif">
   {!! Form::label('fullname', trans('users.fullname'), array('class' => 'control-label')) !!}
   {!! Form::text('fullname', $user->fullname, array('class' => 'form-control')) !!}
</div>

<div class="form-group @if ($errors->has('file')) has-error has-feedback @endif">
   {!! Form::label('file', trans('users.avatar'), array('class' => 'control-label')) !!}
   {!! Form::file('file') !!}
   @if ($errors->has('file')) <span class="glyphicon glyphicon-remove form-control-feedback"></span> @endif
   <img src="{!! Croppa::url($user->avatar, 100, null) !!}" id="thumb" style="max-width:300px; max-height: 200px;@if ($user->avatar == '') display: none;@endif"  class="img-thumbnail">
   {!! Form::hidden('image', $user->avatar) !!}
   <div class="error alert alert-danger" style="display: none;"></div>
</div>

<div class="checkbox @if ($errors->has('notifications')) has-error has-feedback @endif">
   <label>
      {!! Form::checkbox('notifications','1',$user->notifications, array('id' => 'notifications')) !!}
      {!! trans('users.notifications') !!}
   </label>
</div>


@stop

@section('scripts')
@include('backend.users.edit.scripts')
@stop
