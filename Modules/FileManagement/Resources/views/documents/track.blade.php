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

    <div class="col-md-3">
        <div class="card card-default">

            <div class="card-body pt-15">
                <!--begin::User-->
                <div class="text-center mb-10">
                    {!! QrCode::size(150)->generate($document->id) ?? '' !!}
                    <br>
                    <br>
                    {!! show_status($document->status) !!}
                    <h4 class="font-weight-bold text-dark mt-2 mb-2">{{ strtoupper(doc_type_only($document->type)) }}</h4>
                    <div class="text-grey mb-2">{{ convert_to_series($document) }}</div>
                </div>
                <!--end::User-->
               
                <table class="table">
                    @foreach($datas as $key => $data)
                        <tr>
                            <td><strong>{{ $key }}</strong>:</td>
                            <td>{{ $data }}</td>
                        </tr>
                    @endforeach
                </table>
             
            </div>
            
        
        </div>
    </div>

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
                            <td>{{ name_helper($track->clerk) }}</td>
                            <td>
                                @if($track->liaison_id != 0)
                                {{ name_helper($track->liaison) }}
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