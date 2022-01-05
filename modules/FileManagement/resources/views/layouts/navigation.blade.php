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
                                    <a href="{{ route('fms.procurement.request.index') }}" class="dropdown-item">Purchase Request</a>
                                    <a href="{{ route('fms.procurement.order.index') }}" class="dropdown-item">Purchase Order</a>
                                    <a href="{{ route('fms.procurement.supplier.index') }}" class="dropdown-item">Supplier</a>
                                    <a href="{{ route('fms.procurement.ppmp.index') }}" class="dropdown-item">PPMP</a>
                                </div>
                            </div>

                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                    aria-expanded="false">
                                    Travel
                                </a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('fms.travel.order.index') }}" class="dropdown-item">Travel Order</a>
                                    <a href="./sign-in.html" class="dropdown-item">Itinerary of Travel</a>
                                </div>
                            </div>

                            <a class="dropdown-item" href="./gallery.html">
                                Purchase Request
                            </a>

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-ui.icon icon="files" />
                            </span>
                            <span class="nav-link-title">
                                Document
                            </span>
                        </a>

                        <div class="dropdown-menu">

                            <a class="dropdown-item" href="{{ route('fms.document.activate.index') }}">
                                Activate
                            </a>

                            <a class="dropdown-item" href="{{ route('fms.document.attach.index') }}">
                                Attachments
                            </a>

                            <a class="dropdown-item" href="{{ route('fms.document.rr.index') }}">
                                Receive / Release
                            </a>

                            <a class="dropdown-item" href="{{ route('fms.document.track') }}">
                                Track
                            </a>

                        </div>
                    </li>


                </ul>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    <form action="{{ route('fms.document.track') }}" method="get">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <x-ui.icon icon="search" />
                            </span>
                            <input type="text" class="form-control" name="qrcode" placeholder="Search…"
                                aria-label="Search in website">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
