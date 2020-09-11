@extends('filemanagement::layouts.app')

@section('page-title')
    Obligation Request Details
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.obr.index') }}">Obligation Request</a></li>
    <li class="breadcrumb-item active">Show</li>
</ol>
@endsection

@section('content')

<div class="row">
    <x-fms-qr size="sm-4" :document="$document" />

    <div class="col-md-8">
        <!--begin::Card-->
        <div class="card card-default">

            <div class="card-header">
                <h3 class="font-weight-bold mt-2 card-title">Request Details</h3>

                <div class="card-tools">
                
                    <button type="button" class="btn bg-navy dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span> Action
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="{{ route('fms.obr.edit', $document->id) }}"><i class="fal fa-edit"></i> Edit</a>
                        <a class="dropdown-item" href="{{ route('fms.documents.cancel', $document->id) }}"><i class="fal fa-ban"></i> Cancel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" target="_blank" href="{{ route('fms.obr.print', $document->id) }}"><i class="fal fa-print"></i> Print</a>
                        <a class="dropdown-item" href="{{ route('fms.documents.attach.form', $document->id) }}"><i class="fal fa-paperclip"></i> Attach</a>
                    </div>
                    
                </div>
            </div>
            <!--begin::Body-->
            <div class="card-body">

                
            
            
                
                <div class="table-responsive">
                    <table class="table table-hover mt-3">

                        <tr>
                            <td><strong>OBR No:</strong></td>
                            <td>{{ $document->obligation_request->number }}</td>
                            <td><strong>Payee: </strong></td>
                            <td>{{ $document->obligation_request->payee }}</td>
                        </tr>
            
                        
            
                        <tr>
                            <td><strong>Address</strong></td>
                            <td>{{ $document->obligation_request->address }}</td>
                            <td><strong>Purpose:</strong></td>
                            <td>{{ @$document->obligation_request->lists[0]['particulars'] }}</td>
                        </tr>
            
                        <tr>
                            <td><strong>Department Head:</strong></td>
                            <td>{{ name_helper($document->obligation_request->dh) }}</td>
                            <td><strong>Budget Officer: </strong></td>
                            <td>{{ name_helper($document->obligation_request->bo) }}</td>
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Responsibility Center</th>
                                <th>Particulars</th>
                                <th>FPP</th>
                                <th>Acount Code</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($document->obligation_request->lists as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $list->responsibility_center }}</td>
                                    <td>{{ $list->particulars }}</td>
                                    <td>{{ $list->fpp }}</td>
                                    <td>{{ $list->account_code }}</td>
                                    <td class="text-right">{{ number_format($list->amount, 2) }}</td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td colspan="5" class="text-right font-weight-boldest">TOTAL AMOUNT:</td>
                                    <td  class="text-right font-weight-boldest">{{ number_format($document->obligation_request->lists->sum('amount'), 2) }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="font-weight-bold mt-3">Attached Documents</h3>

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
                                        <a href="#" class="btn btn-sm"> View</a>
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
        <!--end::Card-->
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