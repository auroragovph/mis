<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Last 10 Transmittal</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Receiving Office</th>
                            <th>Documents</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transmits as $transmit)
                            <tr>
                                <td>{{ $transmit->created_at }}</td>
                                <td>{{ $transmit->id }}</td>
                                <td>{{ office_helper($transmit->receivingOffice) }}</td>
                                <td>
                                    @foreach(collect($transmit->documents) as $document)
                                        <a target="_blank" href="{{ route('fts.documents.track', ['series' => $document]) }}">
                                            {{ fts_series($document, 'encode') }}
                                        </a>
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td>
                                    {!! transmittal_status($transmit) !!}
                                </td>
                                <td>
                                    <a target="_new" href="{{ route('fts.documents.transmittal.print', $transmit->id) }}" class="btn btn-icon btn-light-success">
                                        <i class="flaticon2-print"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>