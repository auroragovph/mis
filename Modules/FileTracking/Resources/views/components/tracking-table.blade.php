<div class="col-{{ $size }}">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title font-weight-bold mt-2">Tracking Logs</h3>
        </div>
       <div class="card-body table-responsive">
        <table class="table table-hover table-sm table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Office</th>
                    <th>Action</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Clerk</th>
                    <th>Liaison</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($tracks as $i => $track)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($track['created_at'])->format('F d, Y h:i A') }}</td>
                        <td>{{ office_helper($track['division'], 'alias') }}</td>
                        <td>
                            @if($track['action'] == 1)
                                <span class="btn-primary">RECEIVED</span>
                            @else 
                                <span class="btn-success">RELEASED</span>
                            @endif
                        </td>
                        <td>{{ $track['purpose'] }}</td>
                        <td>{!! tracking_table_status($track['status']) !!}</td>
                        <td>{{ name_helper($track['clerk']['name']) }}</td>
                        <td>
                            @if($track['liaison_id'] != 0)
                            {{ name_helper($track['liaison']['name']) }}
                            @endif
                        </td>
                        <td>
                            @if(!$loop->last)
                                {{ get_date_diff($track['created_at'], $tracks[$i+1]['created_at']) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
       </div>
    </div>
</div>