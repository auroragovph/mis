
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">

        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>

        <a class="nav-link" href="javascript:;" onclick="document.getElementById('logoutForm').submit();" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>

      </li>