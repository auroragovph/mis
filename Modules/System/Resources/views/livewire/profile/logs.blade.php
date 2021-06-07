<div>
    <table class="table table-sm">
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

    @if($take < $count_logs)
        <button class="btn btn-info" wire:click='loadData'>Load</button>
    @endif
    
</div>