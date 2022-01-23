<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b {{ $class ?? '' }}" {{ $attributes }}>



    @empty(!$title)
    <div class="card-header">

        <h3 class="card-title">
            {{ $title }}
        </h3>

        <div class="card-actions">
            {{ $actions ?? null }}
        </div>

      </div>
    @endempty

    <!--begin::Body-->
    <div class="card-body">
        {{ $slot }}
    </div>

    {{-- {{ $slot_outside }} --}}

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->
