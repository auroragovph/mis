<div class="col-{{ $size }}">
    <div class="card">
        <div class="card-body">
            <h5 class="font-weight-bold">Latest Tracking Log</h5>
        <table class="table">
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ Carbon\Carbon::parse($track['created_at'])->format('F d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td><strong>Office:</strong></td>
                <td>{{ office_helper($track['division']) }}</td>
            </tr>
            <tr>
                <td><strong>Action:</strong></td>
                <td>
                    @if($track['action'] == 1)
                        <span class="btn-primary">RECEIVED</span>
                    @else 
                        <span class="btn-success">RELEASED</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Remarks:</strong></td>
                <td>{{ $track['purpose'] }}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>{!! tracking_table_status($track['status']) !!}</td>
            </tr>
            <tr>
                <td><strong>Clerk:</strong></td>
                <td>{{ name_helper($track['clerk']['name']) }}</td>
            </tr>
            <tr>
                <td><strong>Liaison:</strong></td>
                <td>
                    @if($track['liaison_id'] != 0)
                    {{ name_helper($track['liaison']['name']) }}
                    @endif
                </td>
            </tr>
        </table>
        </div>
    </div>
</div>