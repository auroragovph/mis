@foreach(config('mods.modules') as $module)
<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b tab-pane fade @if($loop->first) show active @endif" id="{{ $module['abbr'] }}-Tab" role="tabpanel" aria-labelledby="{{ $module['abbr'] }}-Tab-tab">
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">{{ $module['office'] }} Office Modules</h3>
            {{-- <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span> --}}
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <ol>
            @foreach($module['funcs'] as $function)
                {{-- {{ dd($function) }} --}}
                <li>
                    @if($function['route'] != null)
                        <a href="{{ route($function['route']) }}">
                            {{ $function['name'] }}
                        </a>
                    @else
                        <p>{{ $function['name'] }}</p>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->
@endforeach
