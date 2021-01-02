<li class="menu-item menu-item-submenu menu-item-rel {{ menu_helper('file-management') }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">File Management</span>
        <span class="menu-desc"></span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
        <ul class="menu-subnav">

            <li class="menu-item" aria-haspopup="true">
                <a href="{{ route('fms.documents.index') }}" class="menu-link">
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
                            <a href="{{ route('fms.documents.activation.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Activation</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('fms.documents.cancel.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Cancellation</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('fms.documents.rr.index') }}" class="menu-link">
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