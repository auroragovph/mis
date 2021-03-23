<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" >

    @empty(!$title)
        <!--begin::Header-->
        <div class="card-header border-0 mt-2">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">{{ $title }}</span>
            </h3>
        </div>
        <!--end::Header-->
    @endempty

    <!--begin::Body-->
    <div class="card-body">
        {{ $slot }}
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->