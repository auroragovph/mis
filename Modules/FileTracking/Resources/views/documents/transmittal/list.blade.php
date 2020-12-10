
<div class="row">
    <div class="col-12">
       
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Last 10 transmittal</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
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
                        @foreach($transmittals as $transmittal)
                            <tr>
                                <td>{{ $transmittal->created_at }}</td>
                                <td>{{ $transmittal->id }}</td>
                                <td>{{ office_helper($transmittal->receivingOffice) }}</td>
                                <td>{{ collect($transmittal->documents)->implode(', ') }}</td>
                                <td>
                                    @if($transmittal->isExpired == true)
                                        <span class="badge bg-danger">EXPIRED</span>
                                    @else
                                        {!! transmittal_status($transmittal->status) !!}
                                    @endif
                                </td>
                                <td><a href="{{ route('fts.documents.transmittal.release.print', $transmittal->id) }}" class="btn bg-gradient-navy btn-xs"><i class="fal fa-print"></i> Print</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>