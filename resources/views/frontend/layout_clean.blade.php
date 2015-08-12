<!doctype html>
<html>
<head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="{!! asset('vendor/bootstrap/css/bootstrap.min.css') !!}">
   <link href="{!! asset('vendor/jquery/jquery-ui.css') !!}" rel="stylesheet">

   <link rel="stylesheet" type="text/css" href="{!! asset('css/main.css') !!}">
   @yield('styles')
</head>

<body>

<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
       <div class="container-fluid">
        <div class="navbar-header">
         <a class="navbar-brand" href="{!! route('home') !!}">{!! trans('general.index_page') !!}</a>
        </div>
            <ul class="nav nav-pills pull-right">
            @if(Auth::guest())
                <li><a href="{!! route('login.index') !!}">{!! trans('general.login') !!}</a></li>
                <li><a href="{!! route('login.register') !!}">{!! trans('general.register') !!}</a></li>
            @else
            @if(Auth::user()->isAdmin())
                <li><a href="{!! route('login.dashboard') !!}" class="btn">{!! trans('general.backend') !!}</a></li>
            @endif
                <li><a href="{!! route('user.profile') !!}" class="btn">{!! trans('general.profile') !!}</a></li>
                <li><a href="{!! route('login.logout') !!}" class="btn">{!! trans('general.logout') !!}</a></li>
            @endif
            </ul>

      </div>
</nav>

<div class="container">

   @if (Session::has('message'))
   <div class="flash alert">
      <p>{!! Session::get('message') !!}</p>
   </div>
   @endif

   @yield('content')



</div>

<script type="text/javascript" src="{!! asset('vendor/jquery/jquery.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('vendor/jquery/jquery-ui.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('vendor/bootstrap/js/bootstrap.min.js') !!}"></script>
@yield('scripts')

</body>

</html>
