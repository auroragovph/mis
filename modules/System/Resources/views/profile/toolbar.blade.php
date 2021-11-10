  <div class="d-none d-lg-block col-lg-3">
    <x-ui.card>
      <ul class="nav nav-pills nav-vertical">
        <li class="nav-item">
            <a href="?tab=overview" class="nav-link">
                Overview
            </a>
        </li>
        <li class="nav-item">
            <a href="#menu-base" class="nav-link" data-bs-toggle="collapse" aria-expanded="false">
                Security
                <span class="nav-link-toggle"></span>
            </a>
            <ul class="nav nav-pills collapse" id="menu-base">
                <li class="nav-item">
                    <a href="?tab=security.username" class="nav-link">
                        Username
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?tab=security.password" class="nav-link">
                        Password
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
          <a href="?tab=logs" class="nav-link">
              Activity Logs
          </a>
      </li>
    </ul>
    </x-ui.card>
</div>
