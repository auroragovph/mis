@extends('filemanagement::layouts.app')

@section('page-title')
    Purchase Request
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-default">
            <div class="card-body pt-15">
                <!--begin::User-->
                <div class="text-center mb-10">
                    {!! QrCode::size(150)->generate($document->id); !!}
                    <br>
                    <br>
                    {!! show_status($document->status) !!}
                    <h4 class="font-weight-bold text-dark mt-2 mb-2">PURCHASE REQUEST</h4>
                    <div class="text-grey mb-2">{{ convert_to_series($document) }}</div>
                </div>
                <!--end::User-->
               
                <table class="table">
                    <tr>
                        <td><strong>Requesting Office:</strong></td>
                        <td>{{ office_helper($document->division) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Liaison Officer:</strong></td>
                        <td>{{ name_helper($document->liaison) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Encoded By: </strong></td>
                        <td>{{ name_helper($document->encoder) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Encoded Date: </strong></td>
                        <td>{{ Carbon\Carbon::parse($document->created_at)->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
             
            </div>
        </div>
    </div>
     <div class="col-md-9">
        <div class="card card-default">
            <div class="card-header"> 
                <h3 class="font-weight-bold mt-2 card-title">Request Details</h3>
                <div class="card-tools">
                
                    <button type="button" class="btn bg-navy dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span> Action
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="{{ route('fms.procurement.request.edit', $document->id) }}"><i class="fal fa-edit"></i> Edit</a>
                        <a class="dropdown-item" href="{{ route('fms.documents.cancel', $document->id) }}"><i class="fal fa-file-times"></i> Cancel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" target="_blank" href="{{ route('fms.procurement.request.print', $document->id) }}"><i class="fal fa-print"></i> Print</a>
                        <a class="dropdown-item" href="{{ route('fms.documents.attach.form', $document->id) }}"><i class="fal fa-paperclip"></i> Attach</a>
                    </div>
                    
                </div>
            </div>
            <!--begin::Body-->
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <td><strong>PR Number:</strong></td>
                        <td>{{ $document->purchase_request->number }}</td>

                        <td><strong>Date:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($document->created_at)->format('F d, Y h:i A') }}</td>
                    </tr>

                    <tr>
                        <td><strong>Requested By:</strong></td>
                        <td>{{ name_helper($document->purchase_request->requesting) }}</td>

                        <td><strong>Charging:</strong></td>
                        <td>{{ office_helper($document->purchase_request->charging) }}</td>
                    </tr>

                    <tr>
                        <td><strong>Purpose:</strong></td>
                        <td colspan="3">{{ $document->purchase_request->purpose }}</td>
                       
                    </tr>
                </table>
               </div>

                <div class="table-responsive">
                    <table class="table table-hover mt-10">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Stock No.</th>
                                <th>Unit</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th class="text-right">Unit Cost</th>
                                <th class="text-right">Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($document->purchase_request->lists as $i => $list)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $list->stock }}</td>
                                    <td>{{ $list->unit }}</td>
                                    <td>{{ $list->desc }}</td>
                                    <td>{{ $list->qty }}</td>
                                    <td class="text-right">{{ number_format($list->cost, 2) }}</td>
                                    <td class="text-right">{{ number_format($list->qty * $list->cost, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-right text-dark" colspan="6">TOTAL COST:</td>
                                <td class="text-right text-dark" colspan="">{{ number_format($document->purchase_request->lists->sum(function($arr){ return $arr['qty'] * $arr['cost']; }), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4>Attached Documents</h4>
                <hr>

                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($document->attachments as $attachment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attachment->description }}</td>
                                <td>{{ $attachment->mime }}</td>
                                <td>{{ Carbon\Carbon::parse($attachment->created_at)->format('F d, Y h:i A') }}</td>
                                <td>{{ name_helper($attachment->employee) }}</td>
                                <td>
                                    @if($attachment->mime !== 'text')
                                        <a href="{{ Storage::url($attachment->url)}}" target="_blank"> View</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



            </div>
            <!--end::Body-->
        </div>
     </div>
</div>
@endsection




@section('css-vendor')
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
    
@endsection

@section('js-custom')
    
@endsection