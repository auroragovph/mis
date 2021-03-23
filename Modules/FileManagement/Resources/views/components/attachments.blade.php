 <!--begin::Advance Table Widget 5-->
 <div class="card card-custom  gutter-b">

    <x-ui.card.title title="Attached Documents" />

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
                        <th>Information</th>
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
                        <td>
                            @if($attachment->properties['number'] != null) <p><strong>Number:</strong> {{ $attachment->properties['number'] }}</p> @endif
                            @if($attachment->properties['date'] != null) <p><strong>Date:</strong> {{ $attachment->properties['date'] }}</p> @endif
                            @if($attachment->properties['amount'] != null) <p><strong>Amount:</strong> {{ $attachment->properties['amount'] }}</p> @endif
                            @if($attachment->properties['page'] != null) <p><strong>Page:</strong> {{ $attachment->properties['page'] }}</p> @endif
                        </td>
                        <td>{{ name_helper($attachment->employee->name) }}</td>
                        <td>
                            @switch($attachment->mime)
                                @case('file')
                                    <a target="_blank" href="{{ route('fms.documents.attach.file', $attachment->url) }}" class="btn btn-icon btn-light-primary btn-sm mr-2">
                                        <i class="flaticon-attachment"></i>
                                    </a>
                                @break

                                @case('url/sys')
                                   <?php $route = json_decode($attachment->url); ?>
                                   {{-- {{ dd($route) }} --}}
                                    <a href="{{ route($route[0], $route[1]) }}" target="_blank" class="btn btn-sm btn-primary"> <i class="fal fa-eye"></i> View</a>

                                @break

                            @endswitch

                            
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