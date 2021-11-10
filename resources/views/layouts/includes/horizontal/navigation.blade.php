<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link">
        <i class="fas fa-th-large"></i>
        Dashboard
    </a>
</li>



@foreach ($menus as $i => $menu)


    @if (array_key_exists('header', $menu))
        @continue
    @else

        @empty($menu['sub'])

            <li class="nav-item">
                <a href="{{ route($menu['route']) }}" class="nav-link">
                    <i class="{{ $menu['icon'] ?? 'fas fa-circle' }} mr-1"></i>
                    {{ $menu['name'] }}
                </a>
            </li>

        @else

            <li class="nav-item dropdown">
                <a id="dropdownSubMenu{{ $i }}" href="#" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" class="nav-link dropdown-toggle">
                    <i class="{{ $menu['icon'] ?? 'fas fa-circle' }} mr-1"></i>
                    {{ $menu['name'] }}
                </a>
                <ul aria-labelledby="dropdownSubMenu{{ $i }}" class="dropdown-menu border-0 shadow">
                    @foreach ($menu['sub'] as $sub)


                        <li>
                            <a href="{{ route($sub['route']) }}" class="dropdown-item">
                                <i class="{{ $sub['icon'] ?? 'far fa-circle' }} mr-2"></i>
                                {{ $sub['name'] }}
                            </a>
                        </li>



                    @endforeach

                </ul>
            </li>


        @endempty





    @endif

@endforeach


<li class="nav-item">
    <a href="{{ route('sys.admin.dashboard') }}" class="nav-link text-danger font-weight-bolder">
        <i class="fas fa-tools mr-1"></i>
        ADMIN TOOLS
    </a>
</li>