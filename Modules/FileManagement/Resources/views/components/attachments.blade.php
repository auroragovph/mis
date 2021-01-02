 <!--begin::Advance Table Widget 5-->
 <div class="card card-custom  gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Attached Documents</span>
            {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-0">

        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attachments as $attachment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attachment->description }}</td>
                        <td>{{ $attachment->mime }}</td>
                        <td>{{ Carbon\Carbon::parse($attachment->created_at)->format('F d, Y h:i A') }}</td>
                        <td>{{ name_helper($attachment->employee->name) }}</td>
                        <td>
                            @if($attachment->mime !== 'text')
                                <a href="{{ Storage::url('public/documents/'.$attachment->url) }}" target="_blank" class="btn btn-sm btn-primary"> <i class="fal fa-eye"></i> View</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 5-->