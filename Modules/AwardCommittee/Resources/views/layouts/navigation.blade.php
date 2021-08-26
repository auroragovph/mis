<div class="navbar-expand-md">
  <div class="collapse navbar-collapse" id="navbar-menu">
      <div class="navbar navbar-light">
          <div class="container-xl">
              <ul class="navbar-nav">

                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('fms.dashboard') }}">
                          <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <x-ui.icon icon="dashboard" />
                          </span>

                          <span class="nav-link-title">
                              Dashboard
                          </span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('bac.supplier.index') }}">
                          <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <x-ui.icon icon="building-store" />
                          </span>

                          <span class="nav-link-title">
                              Supplier
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
                              Special Actions
                          </span>
                      </a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ route('fms.documents.activation.index') }}">
                              Activation
                          </a>
                          <a class="dropdown-item" href="{{ route('fms.documents.attach.index') }}">
                              Attach Document
                          </a>
                          <a class="dropdown-item" href="{{ route('fms.documents.cancel.index') }}">
                              Cancellation
                          </a>
                          <a class="dropdown-item" href="./search-results.html">
                              Numbering
                          </a>
                          <a class="dropdown-item" href="{{ route('fms.documents.rr.index') }}">
                              Receive / Release
                          </a>
                      </div>
                  </li>


              </ul>
              
          </div>
      </div>
  </div>
</div>
