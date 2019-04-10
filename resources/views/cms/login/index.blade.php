
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CMS | Sign in</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('asset/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/adminlte/dist/css/AdminLTE.min.css') }}">

  <link rel="stylesheet" href="{{ asset('asset/css/loading.css') }}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>C</b>MS
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <div id="info" class="callout callout-info">
        <p></p>
      </div>
      <form id="sign" action="{{ route('cms.login.exe') }}" method="post">
        <div class="form-group has-feedback">
          <input name="email" type="email" class="form-control" placeholder="Email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input name="password" type="password" class="form-control" placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <div id="loading-page">
    <div class="dis-table">
      <div class="row">
        <div class="cel">
          <img src="{{ asset('asset/picture-default/loading.gif') }}">
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('asset/adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('asset/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  
  <script type="text/javascript">
    $('#info.callout-info').hide();
    $(document).ready(function() {
      $('#loading-page').hide();
    });
    
    $(document).on('submit', 'form#sign', function (eval) {
      var data = {};
      data['url'] = $(this).attr('action');
      data['input']  = new FormData($(this)[0]);
      
      exeLogin(data);
      return false;
    });

    function exeLogin(data) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: data.url,
        type: 'post',
        dataType: 'json',
        data: data.input,
        processData:false, // untuk menggunakan new FormData wajib menggunakan ini dengan value false
        contentType:false, // untuk menggunakan new FormData wajib menggunakan ini dengan value false
        beforeSend: function() {
          $('#loading-page').show();
        },
        error: function(data) {
          $('#loading-page').hide();
        },
        success: function(data) {
          $('#info.callout-info').show().html(data.msg);
          if (data.response == true) {
            window.location.replace(data.url);
          }
          $('#loading-page').hide();
        }
      });
    }
  </script>
</body>
</html>
