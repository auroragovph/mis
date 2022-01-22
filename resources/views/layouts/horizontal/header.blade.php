<header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('home') }}">{{ $__module_title__ ?? 'PROVINCIAL GOVERNMENT OF AURORA' }}</a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">

            @auth

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                        aria-label="Open user menu">

                        @if(authenticated('image') == null)
                            <span class="avatar avatar-sm">{{ name(authenticated('name'), 'SYM-FL') }}</span>
                        @else
                            <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                        @endif


                        <div class="d-none d-xl-block ps-2">
                            <div>{{ name(authenticated('name')) }}</div>
                            <div class="mt-1 small text-muted">{{ '@'.authenticated('username') }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                        <a href="?theme=dark" class="dropdown-item hide-theme-dark">Dark mode</a>
                        <a href="?theme=light" class="dropdown-item hide-theme-light">Light mode</a>

                        <a href="#" class="dropdown-item">Set status</a>
                        <a href="#" class="dropdown-item">Profile & account</a>
                        <a href="#" class="dropdown-item">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Settings</a>
                        @livewire('system::auth.logout')
                    </div>
                </div>
            @else
                @if(!Route::is('login'))
                <div class="nav-item d-none d-md-flex me-3">

                    <a href="{{ route('login') }}" class="btn">
                        <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                        <x-ui.icon icon="login" />
                        Login
                    </a>

                </div>
                @endif
            @endauth





        </div>
    </div>
</header>
