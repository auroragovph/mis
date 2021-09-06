<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sys.admin.dashboard') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-ui.icon icon="home" />
                            </span>

                            <span class="nav-link-title">
                                Home
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sys.admin.employee.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-ui.icon icon="user" />
                            </span>

                            <span class="nav-link-title">
                                Employees
                            </span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button"
                            aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <x-ui.icon icon="shield-lock" />
                            </span>
                            <span class="nav-link-title">
                                Access Control
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('sys.admin.acl.account.index') }}">
                                Account
                            </a>
                            <a class="dropdown-item" href="{{ route('sys.admin.acl.role.index') }}">
                               Roles
                            </a>
                            
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
