<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.includes.meta')
    @include('layouts.includes.styles')
</head>
<body class="hold-transition sidebar-mini accent-olive">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>
   

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @include('layouts.includes.navbar')
    </ul>
  </nav>
  <!-- /.navbar -->

  @include('system::layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('page-title')</h1>
          </div>
          <div class="col-sm-6">
            <div class="float-right">
              @yield('toolbar')
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      

      @include('layouts.includes.alerts')
      
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.includes.footer')


</div>
<!-- ./wrapper -->

@include('layouts.includes.scripts')


<script>
  $(document).ready(function () {

    var url = window.location.href;

    $('.nav-sidebar li a').filter(function() {
          return this.href == url;
    }).addClass('active');

    $('.nav-sidebar li a').filter(function() {
      return this.href == url;
    }).addClass('active')
    .parent().parent().parent()
    .addClass('menu-open')
    .children(':first-child')
    .addClass('active');

  })
</script>

</body>
</html>
