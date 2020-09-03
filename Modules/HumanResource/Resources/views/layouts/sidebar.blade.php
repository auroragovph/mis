 <!-- Sidebar Menu -->
 <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
     

      <li class="nav-item">
        <a href="{{ route('hrm.dashboard') }}" class="nav-link">
          <i class="nav-icon fal fa-tachometer-alt"></i> <p>Dashboard</p>
        </a>
      </li>


      <li class="nav-header">Employee Management</li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fal fa-user"></i>
          <p>Employees<i class="right fal fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('hrm.employee.index') }}" class="nav-link">
              <i class="fal fa-circle nav-icon"></i>
              <p>Lists</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('hrm.employee.create') }}" class="nav-link">
              <i class="fal fa-circle nav-icon"></i>
              <p>Register</p>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fal fa-user-hard-hat"></i>
          <p>Plantilla<i class="right fal fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('hrm.plantilla.position.index') }}" class="nav-link">
              <i class="fal fa-circle nav-icon"></i>
              <p>Position</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('hrm.plantilla.sg.index') }}" class="nav-link">
              <i class="fal fa-circle nav-icon"></i>
              <p>Salary Grade</p>
            </a>
          </li>
        </ul>
      </li>


      

      

      <form method="POST" action="/auth/signout" id="logout-form" style="display: none" >
        @csrf
      </form>

    </ul>
  </nav>
  <!-- /.sidebar-menu -->