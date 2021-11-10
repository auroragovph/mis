<div class="col-md-7">
    <div class="row">
        <div class="col-xl-6">
            <x-ui.widget.simple color="bg-success" title="Today's Document"
                desc="{{ $documents->whereBetween('created_at', [Carbon\Carbon::now()->startOfDay(), Carbon\Carbon::now()->endOfDay()])->count() }}" />
            <x-ui.widget.simple color="bg-primary" title="Total Document" :desc="$total" />
        </div>
        <div class="col-xl-6">

            <x-ui.widget.simple color="bg-warning" title="On Process" desc="N/A" />
            <x-ui.widget.simple color="bg-danger" title="Returned" desc="N/A" />



        </div>

    </div>
    <!--begin::Mixed Widget 20-->
    <div class="card card-custom bgi-no-repeat gutter-b"
        style="height: 180px; background-color: #4AB58E; background-position: calc(100% + 0.5rem) bottom; background-size: 25% auto; background-image: url(/media/svg/humans/custom-1.svg)">
        <!--begin::Body-->
        <div class="card-body d-flex align-items-center">
            <div class="py-2">
                <h3 class="text-white font-weight-bolder mb-3">File Management Announcements</h3>
                <p class="text-white font-size-lg">
                    Please attach the documents when you released the documents.
                </p>
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Mixed Widget 20-->
</div>
