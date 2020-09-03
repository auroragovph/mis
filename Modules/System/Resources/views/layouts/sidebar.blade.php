 <!-- Sidebar Menu -->
 <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
     

      <li class="nav-item">
        <a href="{{ route('sys.dashboard') }}" class="nav-link">
          <i class="nav-icon fal fa-tachometer-alt"></i> <p>Dashboard</p>
        </a>
      </li>


      <li class="nav-header">Office Management</li>

      <li class="nav-item">
        <a href="{{ route('sys.office.index') }}" class="nav-link">
          <i class="nav-icon fal fa-building"></i> <p>Office</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('sys.office.division.index') }}" class="nav-link">
          <i class="nav-icon fal fa-building"></i> <p>Division</p>
        </a>
      </li>


      <li class="nav-header">User Management</li>

      <li class="nav-item">
        <a href="{{ route('sys.user.index') }}" class="nav-link">
          <i class="nav-icon fal fa-user-alt"></i> <p>Users</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('sys.user.acl.index') }}" class="nav-link">
          <i class="nav-icon fal fa-shield-alt"></i> <p>Access Control List</p>
        </a>
      </li>

   

      <li class="nav-header">Tools</li>

      <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link">
          <i class="nav-icon fal fa-database"></i> <p>Database</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link">
          <i class="nav-icon fal fa-calendar-day"></i> <p>Scheduler</p>
        </a>
      </li>

      

      <form method="POST" action="/auth/signout" id="logout-form" style="display: none" >
        @csrf
      </form>

    </ul>
</nav>
<!-- /.sidebar-menu -->
