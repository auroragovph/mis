@extends('filemanagement::layouts.app')


@section('page-title')
    Tracking Page
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Activation</li>
</ol>
@endsection

@section('content')



@isset($document)
<div class="row">

    <x-fms-qr size="sm-3" :document="$document" :datas="$datas" />
    

    <div class="col-md-9">
        <div class="card card-default">
           <div class="card-body table-responsive">
            <h3>Tracking Logs</h3>
            <hr>
            <table class="table table-hover table-sm">
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
                            <td>{{ Carbon\Carbon::parse($track->created_at)->format('F d, Y h:i A') }}</td>
                            <td>{{ office_helper($track->division) }}</td>
                            <td>
                                @if($track->action == 1)
                                    <span class="btn-primary">RECEIVED</span>
                                @else 
                                    <span class="btn-success">RELEASED</span>
                                @endif
                            </td>
                            <td>{{ $track->purpose }}</td>
                            <td>{!! tracking_table_status($track->status) !!}</td>
                            <td>{{ name_helper($track->clerk->name) }}</td>
                            <td>
                                @if($track->liaison_id != 0)
                                {{ name_helper($track->liaison->name) }}
                                @endif
                            </td>
                            <td>
                                @if(!$loop->last)
                                    {{ get_date_diff($track->created_at, $tracks[$i+1]['created_at']) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           </div>
        </div>
    </div>
</div>
@endisset
@endsection




@section('css-vendor')
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
    
@endsection

@section('js-custom')
    
@endsection