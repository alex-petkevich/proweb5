@extends('backend.layout')

@section('main')

    <h1>{{{ trans('login.dashboard') }}}</h1>

    <p>{{{ trans('login.nice_to_see') }}}, <b>{{{ Auth::user()->username }}}</b></p>

@stop