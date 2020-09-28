<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aurora MIS | {{ $module_title ?? '' }}</title>

  <!-- Font Awesome Icons -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  @yield('css-vendor')

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

  @yield('css-custom')

</head>

<body class="hold-transition sidebar-collapse layout-top-nav layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{ route('root.home') }}" class="navbar-brand">
        <img src="{{ asset('images/logo-sm.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AURORA MIS</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- sdkjghakdsfgfdg --}}
      @include($module_horizontal)



      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        
      
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fal fa-user"></i> Profile
          </a>
        </li>
      </ul>

    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('root.home') }}" class="brand-link">
        <img src="{{ asset('images/logo-sm.png') }}" alt="Aurora Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light ml-2">AURORA MIS</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('images/user-default.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ name_helper(Auth::user()->employee->name, 'FL') }}</a>
          </div>
        </div>
       @include($module_side_bar)
  
      </div>
      <!-- /.sidebar -->



  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('page-title')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            @yield('breadcrumbs')
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">

        @if(session('alert-success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fal fa-check"></i> Success!</h5>
            {{ session('alert-success') }}
          </div>
        @endif

        @if(session('alert-info'))
          <div class="alert alert-primary alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fal fa-exclamtion-mark"></i> Information!</h5>
            {{ session('alert-info') }}
          </div>
        @endif

        @if(session('alert-warning'))
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fal fa-exclamation-triangle"></i> Warning!</h5>
            {{ session('alert-warning') }}
          </div>
        @endif

        @if(session('alert-error'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fal fa-ban"></i> Error!</h5>
            {{ session('alert-error') }}
          </div>
        @endif

        

        @yield('content')
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.includes.aside')

  @include('layouts.includes.footer')
  
</div>
<!-- ./wrapper -->



<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

@yield('js-vendor')

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/adminlte.sidebar.min.js') }}"></script>

@yield('js-custom')


</body>
</html>
