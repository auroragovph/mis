<li class="nav-header">System Management</li>

<li class="nav-item has-treeview">

  <a href="#" class="nav-link">
    <i class="nav-icon fal fa-building"></i>
    <p>Office Management<i class="right fal fa-angle-left"></i></p>
  </a>
    
  <ul class="nav nav-treeview">

    <li class="nav-item">
      <a href="{{ route('sys.office.index') }}" class="nav-link">
        <i class="nav-icon fal fa-circle"></i> <p>Office</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ route('sys.office.division.index') }}" class="nav-link">
        <i class="nav-icon fal fa-circle"></i> <p>Division</p>
      </a>
    </li>

  </ul>
    
</li>

<li class="nav-item">

  <a href="#" class="nav-link">
    <i class="nav-icon fal fa-users"></i>
    <p>
      User Management
    <i class="right fal fa-angle-left"></i>
    </p>
  </a>

  <ul class="nav nav-treeview">

    <li class="nav-item">
      <a href="{{ route('sys.user.index') }}" class="nav-link">
        <i class="fal fa-user nav-icon"></i>
        <p>Users</p>
      </a>
    </li>

    <li class="nav-item">

      <a href="#" class="nav-link">
        <i class="fal fa-shield-alt nav-icon"></i>
        <p>
          Access Control Level
          <i class="right fal fa-angle-left"></i>
        </p>
      </a>

      <ul class="nav nav-treeview">

        <li class="nav-item">
          <a href="{{ route('sys.acl.permission.index') }}" class="nav-link">
            <i class="fal fa-shield-check nav-icon"></i>
            <p>Permissions</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('sys.acl.role.index') }}" class="nav-link">
            <i class="fal fa-user-tag nav-icon"></i>
            <p>Roles</p>
          </a>
        </li>

      </ul>

    </li>
    
  </ul>
</li>