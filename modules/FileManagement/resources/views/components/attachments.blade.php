<x-ui.table.regular title="Attachments">
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
                <td>
                    <x-ui.icon class="text-muted"  icon="file-certificate"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Dynamic Form"/>
                </td>
                <td>{{ $form->formable->created_at->format('F d, Y h:i A') }}</td>

                <td>{{ $form->formable->particulars ?? ($form->formable->purpose ?? null) }}
                </td>
                <td>{{ name($form->encoder->name) }}</td>
                <td>
                    @switch($form->formable_type)


                        @case('Leave')
                            @php($href = route('fms.afl.show', $form->formable->id))
                        @break

                        @case('Purchase Request')
                            @php($href = route('fms.procurement.request.show', $form->formable->id))
                        @break

                        @case('Purchase Order')
                            @php($href = route('fms.procurement.order.show', $form->formable->id))
                        @break

                        @case('AIR')
                            @php($href = route('fms.procurement.air.show', $form->formable->id))
                        @break

                        @case('CAFOA')
                            @php($href = route('fms.cafoa.show', $form->formable->id))
                        @break

                        @case('Travel Order')
                            @php($href = route('fms.travel.order.show', $form->formable->id))
                        @break

                        @default
                            @php($href = '#')
                @break
            @endswitch

            @if ($href !== '#' and $href !== url()->current())
                <a href="{{ $href ?? '#' }}">
                     View
                </a>
            @endif

            </td>
            </tr>

            @php($x = $loop->last ? $loop->iteration : 0)

            @endforeach

            @foreach ($attachments as $attachment)
                <tr>
                    <td>{{ $loop->iteration + $x }}</td>
                    <td>{{ $attachment->description }}</td>
                    <td>
                        @switch( $attachment->mime)
                            @case('text')
                                <x-ui.icon class="text-muted"  icon="file-text"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Text"/>
                                @break
                            @default
                                <x-ui.icon class="text-muted"  icon="file"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="File"/>
                                @break

                        @endswitch
                    </td>
                    <td>{{ $attachment->created_at->format('F d, Y h:i A') }}</td>
                    <td>
                        @if ($attachment->properties['number'] ?? '' != '')
                            <p class="mb-0"><strong>Number:</strong> {{ $attachment->properties['number'] }}</p>
                        @endif

                        @if ($attachment->properties['date'] ?? '' != '')
                            <p class="mb-0"><strong>Date:</strong> {{ $attachment->properties['date']}}</p>
                        @endif

                        @if ($attachment->properties['amount'] ?? '' != '')
                            <p class="mb-0"><strong>Amount:</strong> {{ $attachment->properties['amount']}}</p>
                        @endif

                        @if ($attachment->properties['page'] ?? '' != '')
                            <p class="mb-0"><strong>Page:</strong> {{ $attachment->properties['page'] }}</p>
                        @endif

                    </td>
                    <td>{{ name($attachment->employee->name) }}</td>
                    <td>

                        @switch($attachment->mime)

                            @case('file')
                                <a target="_blank"
                                    href="{{ route('fms.document.attach.file', ['url' => $attachment->url]) }}">
                                    View
                                </a>
                            @break

                            @case('url/sys')
                                <?php $route = json_decode($attachment->url); ?>
                                {{-- {{ dd($route) }} --}}
                                <a href="{{ route($route[0], $route[1]) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fal fa-eye"></i> View</a>

                            @break

                        @endswitch


                    </td>
                </tr>
            @endforeach
        </tbody>
        </x-ui.table.data-table>
