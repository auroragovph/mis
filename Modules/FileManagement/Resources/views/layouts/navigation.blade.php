<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fms.dashboard') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-ui.icon icon="home" />
                            </span>

                            <span class="nav-link-title">
                                Home
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fms.documents.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-ui.icon icon="files" />
                            </span>

                            <span class="nav-link-title">
                                Document
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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button"
                            aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                              <x-ui.icon icon="stars" />

                            </span>
                            <span class="nav-link-title">
                                Office Actions
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="./activity.html">
                                Inspection and Acceptance Report (AIR)
                            </a>
                            <a class="dropdown-item" href="./gallery.html">
                                PR Consolidation
                            </a>
                            <a class="dropdown-item" href="./invoice.html">
                                Requisition Slip (RIS)
                            </a>

                        </div>
                    </li>

                </ul>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    <form action="{{ route('fms.documents.track') }}" method="GET">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <x-ui.icon icon="search" />
                            </span>
                            <input type="text" name="qrcode" class="form-control" placeholder="Search QR Code"
                                aria-label="Search in website">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
