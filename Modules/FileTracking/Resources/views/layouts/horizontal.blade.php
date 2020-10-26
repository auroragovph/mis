<div class="collapse navbar-collapse order-3" id="navbarCollapse">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fal fa-bars"></i></a>
      </li>

      <li class="nav-item">
        <a href="{{ route('fts.dashboard') }}" class="nav-link">Dashboard</a>
      </li>

      <li class="nav-item">
        <a href="{{ route('fts.documents.index') }}" class="nav-link">Documents</a>
      </li>

      <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Special Actions</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
          <li><a href="{{ route('fts.documents.attach.index') }}" class="dropdown-item">Document Attach</a></li>
          <li><a href="{{ route('fts.documents.rr.index') }}" class="dropdown-item">Receive / Release</a></li>
          <li><a href="{{ route('fms.documents.number.index') }}" class="dropdown-item">Numbering</a></li>


          <li><a href="{{ route('fts.qr.index') }}" class="dropdown-item">QR Codes</a></li>


        </ul>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-0 ml-md-3" action="{{ route('fts.documents.track') }}" method="GET">
      <div class="input-group input-group-sm">
        <input name="series" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" value="{{ request()->get('series') }}">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fal fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>