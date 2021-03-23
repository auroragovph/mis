
@foreach($menus as $menu)


@if(array_key_exists('header', $menu))
    <li class="nav-header text-uppercase">{{ $menu['header'] }}</li>
@else

    @empty($menu['sub'])

        <li class="nav-item">
            <a href="{{ route($menu['route']) }}" class="nav-link">
                <i class="nav-icon {{ $menu['icon'] ?? 'fas fa-circle' }}"></i>
                <p>{{ $menu['name'] }}</p>
            </a>
        </li>

    @else 

        <li class="nav-item">

            <a href="#" class="nav-link">
                <i class="nav-icon {{ $menu['icon'] ?? 'fas fa-circle' }}"></i>
                <p>{{ $menu['name'] }} <i class="right fas fa-angle-left"></i> </p>
            </a>

            <ul class="nav nav-treeview">
                @foreach($menu['sub'] as $sub)
                <li class="nav-item">
                    <a href="{{ route($sub['route']) }}" class="nav-link">
                        <i class="{{ $sub['icon'] ?? 'far fa-circle' }} nav-icon"></i>  <p>{{ $sub['name'] }}</p>
                    </a>
                </li>
                @endforeach
            </ul>
        </li>

    @endempty





@endif

@endforeach