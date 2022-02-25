<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hrm.dashboard') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <x-ui.icon icon="dashboard" />
                            </span>
                            <span class="nav-link-title">
                                Dashboard
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('hrm.employee.index') }}">
                          <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                              <x-ui.icon icon="users" />
                          </span>
                          <span class="nav-link-title">
                              Employees
                          </span>
                      </a>
                  </li>
                    

                </ul>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">

                  @if(is_module_enable('FileManagement'))
                    @include('fms::components.qr-navbar-search')
                  @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
