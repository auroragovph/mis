@extends('filemanagement::layouts.app')

@section('page-title')
    Purchase Request
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item">Procurement</li>
    <li class="breadcrumb-item"><a href="{{ route('fms.procurement.request.index') }}">Request</a></li>
    <li class="breadcrumb-item active">Show</li>
</ol>
@endsection

@section('content')
<div class="row">

    <x-fms-qr size="sm-4" :document="$document" />

    
     <div class="col-md-8">
        <div class="row">

            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header"> 
                        <h3 class="font-weight-bold mt-2 card-title">Request Details</h3>
                        <div class="card-tools">
                        
                            <button type="button" class="btn btn-sm bg-navy dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span> Action
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="{{ route('fms.procurement.request.edit', $document->id) }}"><i class="fal fa-edit"></i> Edit</a>
                                @if($document->status !== 0)
                                <a class="dropdown-item" href="{{ route('fms.documents.cancel', $document->id) }}"><i class="fal fa-file-times"></i> Cancel</a>
                                @endif
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
                                <td><strong>Signatories:</strong></td>
                                <td colspan="3">
                                    {{ name_helper($document->purchase_request->requesting->name) }} (Requesting) <br>
                                    {{ name_helper($document->purchase_request->treasury->name) }} (Treasury) <br>
                                    {{ name_helper($document->purchase_request->approval->name) }} (Approval) <br>
                                </td>
        
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
                                            <td>{{ $list['stock'] }}</td>
                                            <td>{{ $list['unit'] }}</td>
                                            <td>{{ $list['description'] }}</td>
                                            <td>{{ $list['qty'] }}</td>
                                            <td class="text-right">{{ number_format($list['cost'], 2) }}</td>
                                            <td class="text-right">{{ number_format($list['qty'] * $list['cost'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-right text-dark" colspan="6">TOTAL COST:</td>
                                        <td class="text-right text-dark" colspan="">{{ number_format($document->purchase_request->lists->sum(function($arr){ return $arr['qty'] * $arr['cost']; }), 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        
                    
        
                    </div>
                    <!--end::Body-->
                </div>
            </div>

            <x-fms-attachment size="md-12" :attachments="$document->attachments" />

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