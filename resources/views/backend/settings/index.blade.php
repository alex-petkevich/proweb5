@extends('backend.settings.parent')

@section('tab_content')

@foreach ($settings as $setting)
<div class="form-group @if ($errors->has('name')) has-error has-feedback @endif">
   {!! Form::label("name[$setting->name]", $setting->title, array('class' => 'control-label')) !!}
   {!! Form::text("name[$setting->name]", $setting->value, array('class' => 'form-control')) !!}
   @if ($setting->description!='')
   <p class="help-block">{!! $setting->description !!}</p>
   @endif
</div>
@endforeach

@stop