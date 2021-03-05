<ul class="nav flex-column nav-pills">
    @foreach(config('mods.modules') as $module)
        <li class="nav-item mb-2">
            <a class="nav-link @if($loop->first) active @endif" id="{{ $module['abbr'] }}-Tab-tab" data-toggle="tab" href="#{{ $module['abbr'] }}-Tab" @if(!$loop->first) aria-controls="employment" @endif>
                <span class="nav-icon">
                    <i class="{{ $module['icon'] }}"></i>
                </span>
                <span class="nav-text">{{ $module['office'] }}</span>
            </a>
        </li>
    @endforeach
</ul>