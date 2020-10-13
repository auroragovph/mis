
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aurora MIS | System Portal</title>

  <!-- Google Font: Source Sans Pro -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ asset('images/logo-md.png') }}" alt="" width="150px" height="150px">
    <br>

    <h3 class="mt-3 font-weight-bold">SYSTEM PORTAL</h3>
   
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

        <div class="row">

            <div class="col-md-6">
                <a href="{{ route('fms.dashboard') }}">
                    <div class="card bg-gradient-purple p-2 text-center">
                        <img class="mx-auto d-block" src="{{ asset('images/contract.png') }}" alt="" width="100px" height="100px">
                        <h6 class="mt-3">File Management</h6>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('fms.dashboard') }}">
                    <div class="card bg-gradient-olive p-2 text-center">
                        <img class="mx-auto d-block" src="{{ asset('images/message.png') }}" alt="" width="100px" height="100px">
                        <h6 class="mt-3">Messenger</h6>
                    </div>
                </a>
            </div>
        </div>

        @can('sys.sudo')
        <div class="row">

            <div class="col-md-12">
                <a href="{{ route('hrm.dashboard') }}">
                    <div class="card bg-gradient-maroon p-2 text-center">
                        <img class="mx-auto d-block" src="{{ asset('images/human-resources.png') }}" alt="" width="100px" height="100px">
                        <h6 class="mt-3">Human Resource Management</h6>
                    </div>
                </a>
            </div>

        </div>
        @endcan

        @can('sys.sudo')
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('sys.dashboard') }}">
                    <div class="card bg-gradient-navy p-2 text-center">
                        <img class="mx-auto d-block" src="{{ asset('images/system-tools.png') }}" alt="" width="100px" height="100px">
                        <h6 class="mt-3">System Tools</h6>
                    </div>
                </a>
            </div>
        </div>
        @endcan

        <hr>

        <button class="btn btn-block btn-lg bg-gradient-lightblue font-weight-bold">Sign Out</button>


     

    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>

</body>
</html>
