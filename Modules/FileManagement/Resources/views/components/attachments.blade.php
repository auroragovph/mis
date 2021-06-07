<x-ui.card title="Attachment Details">
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

                @php($x = 0)

                    @foreach ($forms as $form)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $form->formable_type }}</td>
                            <td>Dynamic Form</td>
                            <td>{{ $form->formable->created_at }}</td>
                            <td>{{ $form->formable->particulars ?? null }}</td>
                            <td></td>
                            <td></td>
                        </tr>

                        @php($x = $loop->last ? $loop->iteration : 0)

                        @endforeach

                        @foreach ($attachments as $attachment)
                            <tr>
                                <td>{{ $loop->iteration + $x }}</td>
                                <td>{{ $attachment->description }}</td>
                                <td>{{ $attachment->mime }}</td>
                                <td>{{ Carbon\Carbon::parse($attachment->created_at)->format('F d, Y h:i A') }}</td>
                                <td>
                                    <p><strong>Number:</strong> {{ $attachment->properties['number'] ?? '' }}</p> 
                                    <p><strong>Date:</strong> {{ $attachment->properties['date'] ?? '' }}</p>

                                    <p><strong>Amount:</strong> {{ $attachment->properties['amount'] ?? '' }}</p>
                                    <p><strong>Page:</strong> {{ $attachment->properties['page'] ?? '' }}</p>
                                    
                                </td>
                                <td>{{ name_helper($attachment->employee->name) }}</td>
                                <td>
                                    @switch($attachment->mime)
                                        @case('file')
                                            <a target="_blank" href="{{ route('fms.documents.attach.file', $attachment->url) }}"
                                                class="btn btn-icon btn-light-primary btn-sm mr-2">
                                                <i class="flaticon-attachment"></i>
                                            </a>
                                        @break

                                        @case('url/sys')
                                            <?php $route = json_decode($attachment->url); ?>
                                            {{-- {{ dd($route) }} --}}
                                            <a href="{{ route($route[0], $route[1]) }}" target="_blank"
                                                class="btn btn-sm btn-primary"> <i class="fal fa-eye"></i> View</a>

                                        @break

                                    @endswitch


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.card>
