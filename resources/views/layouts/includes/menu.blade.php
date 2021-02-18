<!--begin::Header Menu Wrapper-->
<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
    <div class="container">
        <!--begin::Header Menu-->
        <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default header-menu-root-arrow">
            <!--begin::Header Nav-->
            <ul class="menu-nav">

                <!-- class="menu-item-here" YAN YUNG CLASS PAG DAPAT ACTIVE -->
                <li class="menu-item menu-item-submenu menu-item-rel {{ menu_helper('dashboard') }}" aria-haspopup="true">
                    <a href="/dashboard" class="menu-link">
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                
                @include('filemanagement::layouts.menu-fms')

                @include('filetracking::layouts.menu-fts')

                @if(authenticated()->employee->division_id == config('constants.office.HRMO') || authenticated()->can('sys.sudo'))
                    @include('humanresource::layouts.menu-hrm')
                @endif

                @can('sys.sudo')
                    @include('system::layouts.menu-sys')
                @endcan
                
            </ul>
            <!--end::Header Nav-->
        </div>
        <!--end::Header Menu-->
    </div>
</div>
<!--end::Header Menu Wrapper-->