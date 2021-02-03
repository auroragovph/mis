@extends('layouts.master')


@section('page-title')
Document Tracker
@endsection

@section('toolbar')
@isset($document)
<!--begin::Button-->
 <a href="{{ route('fms.documents.track') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base mr-2">
    <i class="fal fa-arrow-left"></i> Track Another Document
</a>
<!--end::Button-->
@endisset
@endsection

@section('content')

@isset($document)
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr  :document="$document" :datas="$datas" />
    </div>

    <div class="col-xl-8">
          <!--begin::Advance Table Widget 5-->
          <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Tracking Table</span>
                    {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-0">
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
                                <td>{{ Carbon\Carbon::parse($track->created_at)->format('F d, Y h:i A') }}</td>
                                <td>{{ office_helper($track->division, 'alias') }}</td>
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
                                    @else 
                                        {{ get_date_diff($document->created_at, $tracks[$i]['created_at']) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Advance Table Widget 5-->
        
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom  gutter-b">
           
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fms.documents.track') }}" method="GET">
                    <div class="form-group">
                        <label for="">Document ID</label>
                        <input type="text" name="qr" class="form-control" autofocus autocomplete="off" required>
                    </div>
                    <hr>
                    <button class="btn btn-primary"><i class="flaticon2-magnifier-tool"></i> Search</button>
                </form>
            </div>
            <!--end::Body-->
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


