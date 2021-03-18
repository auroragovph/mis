<li class="menu-item menu-item-submenu menu-item-rel {{ menu_helper('file-management') }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">File Management</span>
        <span class="menu-desc"></span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
        <ul class="menu-subnav">
            @foreach(config('filemanagement.menu') as $menu)
            
                @empty($menu['sub'])


                    @empty($menu['permissions'])

                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route($menu['route']) }}" class="menu-link">
                                <i class="{{ $menu['icon'] ?? 'menu-bullet menu-bullet-dot' }}">
                                    <span></span>
                                </i>
                                <span class="menu-text">{{ $menu['name'] }}</span>
                            </a>
                        </li>


                    @else 
                        @canany($menu['permissions'])
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route($menu['route']) }}" class="menu-link">
                                <i class="{{ $menu['icon'] ?? 'menu-bullet menu-bullet-dot' }}">
                                    <span></span>
                                </i>
                                <span class="menu-text">{{ $menu['name'] }}</span>
                            </a>
                        </li>
                        @endcanany
                        
                    @endempty



                
                @else
                    
                    @php($list_permissisons = collect($menu['sub'])->pluck('permissions')->flatten())

                    @canany($list_permissisons)
                    
                    <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="{{ $menu['icon'] ?? 'menu-bullet menu-bullet-dot' }}">
                                <span></span>
                            </i>
                            <span class="menu-text">{{ $menu['name'] }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                            <ul class="menu-subnav">

                            @foreach($menu['sub'] as $sub)
                                @empty($sub['permissions'])
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route($sub['route']) }}" class="menu-link">
                                            <i class="{{ $sub['icon'] ?? 'menu-bullet menu-bullet-dot' }}">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ $sub['name'] }}</span>
                                        </a>
                                    </li>
                                @else
                                    @canany($sub['permissions'])
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route($sub['route']) }}" class="menu-link">
                                            <i class="{{ $sub['icon'] ?? 'menu-bullet menu-bullet-dot' }}">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ $sub['name'] }}</span>
                                        </a>
                                    </li>
                                    @endcanany
                                @endempty
                            @endforeach
                            </ul>
                        </div>
                    </li>
                    @endcanany




                @endempty

            @endforeach

        </ul>
    </div>
</li>