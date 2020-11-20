
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aurora MIS | System Portal</title>

  <!-- Google Font: Source Sans Pro -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">

<div class="login-box" style="width: 80vw;">
    
  <div class="card">
    <div class="card-body login-card-body">
        <div class="row">
            
            <div class="col-md-5 offset-md-1">

                <div class="row align-items-center justify-content-center h-100">

                    <div class="col-12 text-center">
                        <h4>Welcome to</h4>
                        <h1>Aurora MIS System Portal</h1>
        
                        <img class="my-3" src="{{ asset('images/logo-md.png') }}" alt="" width="175px" height="175px">
    
        
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-4">

                <h5 class="text-center mb-2">System Modules</h5>

                <hr>

                <div class="row">

                    <div class="col-md-6">
                        <a href="{{ route('fts.dashboard') }}">
                            <div class="card bg-gradient-purple p-2 text-center">
                                <img class="mx-auto d-block" src="{{ asset('images/contract.png') }}" alt="" width="100px" height="100px">
                                <h6 class="mt-3">File Tracking</h6>
                            </div>
                        </a>
                    </div>
        
                    <div class="col-md-6">
                        <a href="{{ route('messenger.home') }}">
                            <div class="card bg-gradient-olive p-2 text-center">
                                <img class="mx-auto d-block" src="{{ asset('images/message.png') }}" alt="" width="100px" height="100px">
                                <h6 class="mt-3">Messenger</h6>
                            </div>
                        </a>
                    </div>
                </div>
                
                @include('modules')

                @can('godmode')
                <div class="row">
                    <div class="col-md-12">

                        <a href="{{ route('sys.dashboard') }}">
                            <div class="card bg-gradient-navy p-2 text-center">
                                <img class="mx-auto d-block" src="{{ asset('images/system-tools.png') }}" alt="" width="100px" height="100px">
                                <h6 class="mt-3">System Tools</h6>
                            </div>
                        </a>

                        <hr>

                        <label for="">All Modules</label>
                        <select class="form-control select2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option value="" selected hidden></option>
                            <option value="{{ route('messenger.home') }}">Messenger</option>
                            <option value="{{ route('fts.dashboard') }}">File Tracking</option>
                            <option value="{{ route('fms.dashboard') }}">File Management</option>
                            <option value="{{ route('hrm.dashboard') }}">Human Resource Management</option>
                            <option value="{{ route('sys.dashboard') }}">System Tools</option>
                        </select>
                    </div>
                </div>
                @endcan

            </div>
        </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script>
    $(function () {

        $(".select2").select2({
        placeholder: "Select from list",
        });

    });
</script>
</body>
</html>
