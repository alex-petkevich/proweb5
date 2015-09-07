@extends('backend.layout')

@section('main')

<ul class=" error-list">
   {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
</ul>

<div class="col-xs-5">
   <h1 class="page-header">{!! trans('settings.edit_settings') !!}</h1>
   {!! Form::model($settings, array('method' => 'PATCH', 'route' => array(Route::current()->getName()), 'role' => 'form')) !!}

   <ul class="nav nav-tabs">
      <li role="presentation"
          @if (Route::current()->getName() == 'settings.index') class="active"@endif>{!! link_to_route('settings.index', trans('settings.tabs-general')) !!}</li>
      <li role="presentation"
          @if (Route::current()->getName() == 'settings.index_payment') class="active"@endif>{!! link_to_route('settings.index_payment', trans('settings.tabs-payment')) !!}</li>      
   </ul>
   <br/>

   @yield('tab_content')


   <div class="form-group">
      {!! Form::submit(trans('settings.update'), array('class' => 'btn btn-info')) !!}
      {!! link_to_route('settings.index', trans('settings.cancel'), null, array('class' => 'btn btn-default')) !!}
   </div>
   {!! Form::close() !!}
</div>

@stop
