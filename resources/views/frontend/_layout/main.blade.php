<!DOCTYPE html>
<html>
<head>
  @yield('title')
  <meta charset="utf-8">
  <meta http-equiv="Content-Language" content="{{ App::getLocale() }}" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta name="image" content=""> -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="index, follow" />
  <meta name="googlebot" content="all"/>
  @yield('meta')
  <link rel="icon" type="image/png" href="{{ asset('asset/picture-default/cos_logo_full.png') }}" />
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="{{ asset('asset/css/main_public.css?v=2019') }}">
  
  @if(!route::is('main.home'))
  <link rel="stylesheet" href="{{ asset('asset/css/main_sub-public.css?v=2019') }}">
  @endif

  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Kanit:300' rel='stylesheet' type='text/css'>
  @yield("include_css")
  <script src="{{ asset('asset/vendors/jquery/jquery-3.2.0.min.js') }}"></script>

</head>
<body>
  @include('frontend._layout.navigasibar')
  @yield("body")
  @include('frontend._layout.footer')
  <script type="text/javascript" src="{{ asset('asset/js/main_public.js') }}"></script>
  @yield("include_js")
</body>
</html>