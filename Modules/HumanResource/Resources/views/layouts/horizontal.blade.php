<div class="collapse navbar-collapse order-3" id="navbarCollapse">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fal fa-bars"></i></a>
      </li>

      <li class="nav-item">
        <a href="{{ route('hrm.dashboard') }}" class="nav-link">Dashboard</a>
      </li>

      <li class="nav-item">
        <a href="{{ route('hrm.employee.index') }}" class="nav-link">Employees</a>
      </li>

      <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Plantilla</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
          <li><a href="{{ route('hrm.plantilla.position.index') }}" class="dropdown-item">Positions</a></li>
          <li><a href="{{ route('hrm.plantilla.sg.index') }}" class="dropdown-item">Salary Grade</a></li>
        </ul>
      </li>
    </ul>

  </div>