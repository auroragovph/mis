<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  
  @include('layouts.includes.meta')
  @include('layouts.includes.styles')


</head>
<body class="hold-transition sidebar-collapse layout-top-nav accent-olive">

<div class="wrapper">

  @include('layouts.includes.horizontal.header')
  @include('layouts.includes.horizontal.navbar')

  {{-- @include('layouts.includes.sidebar') --}}


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('page-title')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <div class="float-right">
              @yield('toolbar')
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        @include('layouts.includes.alerts')
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.includes.footer')

  
</div>
<!-- ./wrapper -->

@routes()


@include('layouts.includes.scripts')

</body>
</html>
