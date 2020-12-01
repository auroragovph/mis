<li class="nav-header">Human Resource Management</li>

<li class="nav-item has-treeview">

    <a href="#" class="nav-link">
      <i class="nav-icon fal fa-user"></i>
      <p>Employee Management<i class="right fal fa-angle-left"></i></p>
    </a>

    <ul class="nav nav-treeview">

      <li class="nav-item">
        <a href="{{ route('hrm.employee.index') }}" class="nav-link">
          <i class="fal fa-circle nav-icon"></i>
          <p>Employees</p>
        </a>
      </li>

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