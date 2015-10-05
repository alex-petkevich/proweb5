@extends('frontend.layout_clean')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- LEFT COLUMN HERE -->
        </div>

        <div class="col-md-9">
            @yield('main')
        </div>
    </div>

@stop

