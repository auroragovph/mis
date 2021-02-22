<li class="menu-item menu-item-submenu {{ menu_helper('system') }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">System Tools</span>
        <span class="menu-desc"></span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-fixed menu-submenu-center" style="width:1150px">
        <div class="menu-subnav">
            <ul class="menu-content">

                <li class="menu-item">
                    <h3 class="menu-heading menu-toggle">
                        <span class="menu-text">Access Control</span>
                        <i class="menu-arrow"></i>
                    </h3>
                    <ul class="menu-inner">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('sys.account.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-line">
                                    <span></span>
                                </i>
                                <span class="menu-text">Accounts</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('sys.acl.role.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-line">
                                    <span></span>
                                </i>
                                <span class="menu-text">Roles</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <li class="menu-item">
                    <h3 class="menu-heading menu-toggle">
                        <span class="menu-text">Office Management</span>
                        <i class="menu-arrow"></i>
                    </h3>
                    <ul class="menu-inner">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('sys.office.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-line">
                                    <span></span>
                                </i>
                                <span class="menu-text">Office</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('sys.office.division.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-line">
                                    <span></span>
                                </i>
                                <span class="menu-text">Division</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="menu-item">
                    <h3 class="menu-heading menu-toggle">
                        <span class="menu-text">Database</span>
                        <i class="menu-arrow"></i>
                    </h3>
                    <ul class="menu-inner">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('sys.office.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-line">
                                    <span></span>
                                </i>
                                <span class="menu-text">Office</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('sys.office.division.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-line">
                                    <span></span>
                                </i>
                                <span class="menu-text">Division</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </div>
    </div>
</li>