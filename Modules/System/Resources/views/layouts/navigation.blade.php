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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button"
                            aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <x-ui.icon icon="clipboard-check" />
                                
                            </span>
                            <span class="nav-link-title">
                                Users
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('sys.admin.employee.index') }}">
                                Employees
                            </a>
                            <a class="dropdown-item" href="{{ route('fms.documents.attach.index') }}">
                               Access Control
                            </a>
                            
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
