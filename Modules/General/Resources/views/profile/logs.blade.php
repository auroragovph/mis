
<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b tab-pane fade" id="actlogsTab" role="tabpanel" aria-labelledby="actlogsTab-tab">
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Activity Logs</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Logs</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->log }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->
