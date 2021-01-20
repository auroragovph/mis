<li class="menu-item menu-item-submenu menu-item-rel {{ menu_helper('file-tracking') }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">File Tracking</span>
        <span class="menu-desc"></span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
        <ul class="menu-subnav">

            <li class="menu-item" aria-haspopup="true">
                <a href="{{ route('fts.documents.index') }}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:media/svg/icons/General/Shield-check.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3" />
                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Documents</span>
                </a>
            </li>

            <li class="menu-item" aria-haspopup="true">
                <a href="{{ route('fts.documents.track') }}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:media/svg/icons/General/Shield-check.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g id="Stockholm-icons-/-General-/-Search" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" id="Path-2" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" id="Path" fill="#000000" fill-rule="nonzero"></path>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Track</span>
                </a>
            </li>

            <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">

                        <!--begin::Svg Icon | path:media/svg/icons/Communication/Clipboard-list.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3" />
                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" x="10" y="9" width="7" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="13" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="10" y="13" width="7" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="7" y="17" width="2" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.3" x="10" y="17" width="7" height="2" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->

                    </span>
                    <span class="menu-text">Special Actions</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('fts.qr.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">QR Code</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('fts.documents.rr.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Receive / Release</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
        </ul>
    </div>
</li>