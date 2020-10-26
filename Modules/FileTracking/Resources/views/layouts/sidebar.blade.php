<form action="{{ route('fms.documents.track') }}" method="GET">
   <!-- SidebarSearch Form -->
 <div class="form-inline">
  <div class="input-group" data-widget="sidebar-search">
    <input name="document" class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
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
            <a href="{{ route('fms.dashboard') }}" class="nav-link">
              <i class="nav-icon fal fa-tachometer-alt"></i> <p>Dashboard</p>
            </a>
          </li>



          @canany(['fms.create', 'fms.edit', 'fms.edit.power', 'fms.view'])
            <li class="nav-item">
              <a href="{{ route('fms.documents.index') }}" class="nav-link">
                <i class="nav-icon fal fa-file-alt"></i> <p>Documents</p>
              </a>
            </li>
          @endcanany


          <li class="nav-header">Special Actions</li>

          @can('fms.sa.attach')
            <li class="nav-item">
              <a href="{{ route('fms.documents.attach.index') }}" class="nav-link">
                <i class="nav-icon fal fa-paperclip"></i> <p>Document Attach</p>
              </a>
            </li>
          @endcan

          @can('fms.sa.rr')
          <li class="nav-item">
            <a href="{{ route('fms.documents.rr.index') }}" class="nav-link">
              <i class="nav-icon fal fa-exchange-alt fa-rotate-90"></i> <p>Receive / Release</p>
            </a>
          </li>
          @endcan


          @can('fms.sa.activate')
          <li class="nav-item">
            <a href="{{ route('fms.documents.activate') }}" class="nav-link">
              <i class="nav-icon fal fa-clipboard-check"></i> <p>Activation</p>
            </a>
          </li>
          @endcan

          
          @can('fms.sa.number')
          <li class="nav-item">
            <a href="{{ route('fms.documents.number.index') }}" class="nav-link">
              <i class="nav-icon fal fa-sort-numeric-down"></i> <p>Numbering</p>
            </a>
          </li>
          @endcan


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