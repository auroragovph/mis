<div class="col-{{ $size }}">
    <!--begin::Card-->
    <div class="card card-default">

        <div class="card-header">
            <h3 class="font-weight-bold mt-2 card-title">Attachments</h3>
        </div>
        <!--begin::Body-->
        <div class="card-body">
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
                                    <a href="{{ Storage::url($attachment->url) }}" target="_blank" class="btn btn-xs bg-gradient-primary"> <i class="fal fa-eye"></i> View</a>
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
    <!--end::Card-->
</div>