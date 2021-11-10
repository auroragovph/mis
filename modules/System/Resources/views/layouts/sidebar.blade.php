<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-olive elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('media/logos/logo-md.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">AURORA MIS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/dist/images/user.png') }}" class="elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('sys.profile.index') }}"
                    class="d-block">{{ name_helper(authenticated()->employee->name) }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-collapse-hide-child nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item mb-3">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Return Back</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('sys.admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <li class="nav-header text-uppercase text-muted text-sm">User Management</li>

                <li class="nav-item">
                    <a href="{{ route('sys.admin.employee.index') }}"
                        class="nav-link">
                        <i class="nav-icon fas fa-id-badge"></i>
                        <p>Employees</p>
                    </a>
                </li>

                

                <li class="nav-item">

                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Access Control <i class="right fas fa-angle-left"></i> </p>
                    </a>
        
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item">
                            <a href="{{ route('sys.admin.acl.role.index') }}" class="nav-link ">
                                <i class="fas fa-user-tie nav-icon"></i>  <p>Roles</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('sys.admin.acl.account.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Accounts</p>
                            </a>
                        </li>

                       
                    </ul>
                </li>

                <li class="nav-header text-uppercase text-muted text-sm">System Management</li>
                
                <li class="nav-item">

                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Office Management <i class="right fas fa-angle-left"></i> </p>
                    </a>
        
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item">
                            <a href="{{ route('sys.admin.office.index') }}" class="nav-link ">
                                <i class="fas fa-circle nav-icon"></i>  <p>Office</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('sys.admin.division.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>Division</p>
                            </a>
                        </li>

                       
                    </ul>
                </li>

                <li class="nav-header text-uppercase text-muted text-sm">Database Management</li>

                <li class="nav-item">
                    <a href="#"
                        class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Database</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#"
                        class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Migrations</p>
                    </a>
                </li>







            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
