<!doctype html>
<html>
<head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="{!! asset('vendor/bootstrap/css/bootstrap.min.css') !!}">
   <link href="{!! asset('vendor/jquery/jquery-ui.css') !!}" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="{!! asset('css/sb-admin.css') !!}">
   <link href="{!! asset('vendor/font-awesome-4.1.0/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css">
   <!--[if lt IE 9]>
       <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
       <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->

   @yield('styles')
</head>

<body>
 <div id="wrapper">

  <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
  <div class="navbar-header">
   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
       <span class="sr-only">Toggle navigation</span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
   </button>
   <a class="navbar-brand" href="{!! route('home') !!}">{!! trans('general.index_page') !!}</a>
  </div>
    @if(!Auth::guest())
    <ul class="nav navbar-right top-nav">
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{{ Auth::user()->username }}} <b class="caret"></b></a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{!! route('user.profile') !!}"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{!! route('login.logout') !!}"><i class="fa fa-fw fa-power-off"></i> {{{ trans('general.logout') }}}</a>
                </li>
            </ul>
        </li>
    </ul>

    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li @if(Request::path() == 'roles') class="active"@endif>
                <a href="{!! route('roles.index') !!}"><i class="glyphicon glyphicon-list"></i> {{{ trans('general.roles') }}}</a>
            </li>
            <li @if(Request::path() == 'users') class="active"@endif>
                <a href="{!! route('users.index') !!}"><i class="glyphicon glyphicon-user"></i> {{{ trans('general.users') }}}</a>
            </li>
        </ul>
    </div>

   @else
        <ul class="nav nav-pills pull-right">
            <li><a href="{!! route('login.index') !!}">{!! trans('general.login') !!}</a></li>
            <li><a href="{!! route('login.register') !!}">{!! trans('general.register') !!}</a></li>
        </ul>
   @endif
   </nav>


<div id="page-wrapper">

   <div class="container-fluid">
       @if (Session::has('message'))
       <div class="alert alert-warning alert-dismissable">
          <p>{!! Session::get('message') !!}</p>
       </div>
       @endif

           @yield('main')

       </div>
    </div>
</div>

<script type="text/javascript" src="{!! asset('vendor/jquery/jquery.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('vendor/jquery/jquery-ui.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('vendor/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('js/admin.js') !!}"></script>
@yield('scripts')

</body>

</html>