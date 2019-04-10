<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('title')
  @include('cms._layout.head')
  @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    @include('cms._layout.header')
    @include('cms._layout.aside')

    
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->
    @include('cms._layout.footer')
    @include('cms._layout.aside-config')
  </div>
  <!-- ./wrapper -->

  <div id="loading-page">
    <div class="dis-table">
      <div class="row">
        <div class="cel">
          <img src="{{ asset('asset/picture-default/loading.gif') }}">
        </div>
      </div>
    </div>
  </div>
  @include('cms._layout.script')
  @yield('js')
</body>
</html>
