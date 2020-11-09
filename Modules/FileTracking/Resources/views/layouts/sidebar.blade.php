<form action="{{ route('fts.documents.track') }}" method="GET">
   <!-- SidebarSearch Form -->
 <div class="form-inline">
  <div class="input-group" data-widget="sidebar-search">
    <input name="series" class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
      <button class="btn btn-sidebar">
        <i class="fal fa-search fa-fw"></i>
      </button>
    </div>
  </div>
</div>
</form>

<hr>




      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
          <li class="nav-item">
            <a href="{{ route('fts.dashboard') }}" class="nav-link">
              <i class="nav-icon fal fa-tachometer-alt"></i> <p>Dashboard</p>
            </a>
          </li>



          @canany(['fts.create', 'fts.edit'])
            <li class="nav-item">
              <a href="{{ route('fts.documents.index') }}" class="nav-link">
                <i class="nav-icon fal fa-file-alt"></i> <p>Documents</p>
              </a>
            </li>
          @endcanany


          <li class="nav-header">Special Actions</li>

          @can('fts.sa.attach')
            <li class="nav-item">
              <a href="{{ route('fts.documents.attach.index') }}" class="nav-link">
                <i class="nav-icon fal fa-paperclip"></i> <p>Document Attach</p>
              </a>
            </li>
          @endcan

          @can('fts.sa.rr')
          <li class="nav-item">
            <a href="{{ route('fts.documents.rr.index') }}" class="nav-link">
              <i class="nav-icon fal fa-exchange-alt fa-rotate-90"></i> <p>Receive / Release</p>
            </a>
          </li>
          @endcan

          @can('fts.sa.qr')
          <li class="nav-item">
            <a href="{{ route('fts.qr.index') }}" class="nav-link">
              <i class="nav-icon fal fa-qrcode"></i> <p> QR Codes</p>
            </a>
          </li>
          @endcan
          
          {{-- @can('fts.sa.number')
          <li class="nav-item">
            <a href="{{ route('fts.documents.number.index') }}" class="nav-link">
              <i class="nav-icon fal fa-sort-numeric-down"></i> <p>Numbering</p>
            </a>
          </li>
          @endcan --}}


          <li class="nav-item">
            <a href="javascript:void(0);" onclick="$('#logout-form').submit();" class="nav-link">
              <i class="nav-icon fal fa-sign-out-alt"></i> <p>Sign Out</p>
            </a>
          </li>

          <form method="POST" action="/auth/signout" id="logout-form" style="display: none" >
            @csrf
          </form>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->