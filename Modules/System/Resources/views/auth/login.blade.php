
<!DOCTYPE html>
<html lang="en">
<head>

    
    @include('layouts.includes.meta')
    @include('layouts.includes.styles')

    <style>
        .login-box{
            width: 460px;
        }
    </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-olive">
    <div class="card-header text-center">
        <img src="{{ asset('media/logos/logo-md.png') }}" alt="" width="100px" height="100px">

        <p class="h3 mt-3"><b>AURORA</b> MIS</p>
        <p class="h5">Management Information System</p>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      @if ($errors->any())
      <div class="alert alert-danger">
          {{ $errors->first() }}
      </div>
      @endif

      <form action="/login" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
        </div>
        <hr>
        <button type="submit" class="btn bg-olive btn-block">Sign In</button>
      </form>

   
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

@include('layouts.includes.scripts')


</body>
</html>
