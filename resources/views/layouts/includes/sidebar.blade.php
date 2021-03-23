<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-olive elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('media/logos/logo-md.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">AURORA MIS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('adminlte/dist/images/user.png') }}" class="elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ name_helper(authenticated()->employee->name) }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <form action="{{ route('fms.documents.track') }}" method="GET">
          <div class="input-group">
            <input name="qr" class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button type="submit" class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
         @include('layouts.includes.sidebar-menu', ['menus' => config('filemanagement.menu')])
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>