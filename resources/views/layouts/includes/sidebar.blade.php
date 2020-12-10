 <!-- Sidebar Menu -->
 <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      <li class="nav-item">
        <a href="{{ route('root.home') }}" class="nav-link">
          <i class="nav-icon fal fa-tachometer-alt"></i> <p>Dashboard</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('messenger.home') }}" class="nav-link">
          <i class="nav-icon fal fa-inbox"></i> <p>Messenger</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fal fa-id-badge"></i> <p>Profile</p>
        </a>
      </li>


      @include('filetracking::layouts.sidebar')





      @can('godmode')
        @include('filemanagement::layouts.sidebar')
        @include('humanresource::layouts.sidebar')

        @include('system::layouts.sidebar')
      @endcan
     


      <form method="POST" action="/auth/signout" id="logout-form" style="display: none" >
        @csrf
      </form>

    </ul>
</nav>
<!-- /.sidebar-menu -->
