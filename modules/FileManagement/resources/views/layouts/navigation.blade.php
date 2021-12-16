<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fms.dashboard') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <x-ui.icon icon="dashboard" />
                            </span>
                            <span class="nav-link-title">
                                Dashboard
                            </span>
                        </a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <x-ui.icon icon="puzzle" />
                            </span>
                            <span class="nav-link-title">
                                Modules
                            </span>
                        </a>
                        <div class="dropdown-menu">

                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                    aria-expanded="false">
                                    Procurement
                                </a>
                                <div class="dropdown-menu">
                                    <a href="./sign-in.html" class="dropdown-item">Purchase Request</a>
                                    <a href="./sign-in.html" class="dropdown-item">Purchase Order</a>
                                    <a href="./sign-in.html" class="dropdown-item">Supplier</a>
                                    <a href="./sign-in.html" class="dropdown-item">PPMP</a>
                                </div>
                            </div>

                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                    aria-expanded="false">
                                    Travel
                                </a>
                                <div class="dropdown-menu">
                                    <a href="./sign-in.html" class="dropdown-item">Travel Order</a>
                                    <a href="./sign-in.html" class="dropdown-item">Itinerary of Travel</a>
                                </div>
                            </div>

                            <a class="dropdown-item" href="./gallery.html">
                                Purchase Request
                            </a>

                        </div>
                    </li>


                </ul>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    <form action="." method="get">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <x-ui.icon icon="search" />
                            </span>
                            <input type="text" class="form-control" placeholder="Search…"
                                aria-label="Search in website">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
