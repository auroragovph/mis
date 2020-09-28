@extends('filemanagement::layouts.app')

@section('page-title')
    CAFOA Details
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.cafoa.index') }}">CAFOA</a></li>
    <li class="breadcrumb-item active">Show</li>
</ol>
@endsection

@section('content')

<div class="row">
    <x-fms-qr size="sm-4" :document="$document" />

    <div class="col-sm-8">
        <div class="row">

            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-default">
        
                    <div class="card-header">
                        <h3 class="font-weight-bold mt-2 card-title">CAFOA Details</h3>
        
                        <div class="card-tools">
                        
                            <button type="button" class="btn bg-navy dropdown-toggle dropdown-icon btn-sm" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span> Action
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="{{ route('fms.cafoa.edit', $document->id) }}"><i class="fal fa-edit"></i> Edit</a>
                                @if($document->status != 0)
                                <a class="dropdown-item" href="{{ route('fms.documents.cancel', $document->id) }}"><i class="fal fa-ban"></i> Cancel</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item" target="_blank" href="{{ route('fms.obr.print', $document->id) }}"><i class="fal fa-print"></i> Print</a> --}}
                                <a class="dropdown-item" href="{{ route('fms.documents.attach.form', $document->id) }}"><i class="fal fa-paperclip"></i> Attach</a>
                            </div>
                            
                        </div>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
        
                                <tr>
                                    <td><strong>Obligation No:</strong></td>
                                    <td>{{ $document->cafoa->number }}</td>
                                    <td><strong>Payee: </strong></td>
                                    <td>{{ $document->cafoa->payee }}</td>
                                </tr>
        
                                <tr>
                                    <td colspan="2"><strong>Requesting Officer:</strong></td>
                                    <td colspan="2">{{ name_helper($document->cafoa->requesting->name) }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2"><strong>Signatory Officers:</strong></td>
                                    <td colspan="2">
                                        {{ name_helper($document->cafoa->accounting->name) }} (Accounting) <br>
                                        {{ name_helper($document->cafoa->treasury->name) }} (Treasury) <br>
                                        {{ name_helper($document->cafoa->budget->name) }} (Budget) <br>
                                    </td>
                                </tr>


                            </table>
                        </div>
        
                        <div class="table-responsive">
                            <table class="table table-hover mt-5">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Function</th>
                                        <th>Allotment Class</th>
                                        <th>Expense Code</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                    
                                    @foreach($document->cafoa->lists as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $list['function'] }}</td>
                                            <td>{{ $list['allotment'] }}</td>
                                            <td>{{ $list['expense'] }}</td>
                                            <td class="text-right">{{ number_format($list['amount'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>TOTAL AMOUNT:</strong></td>
                                            <td colspan="1" class="text-right"><strong>{{ number_format($document->cafoa->lists->sum('amount'), 2) }}</strong></td>
                                        </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
        
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
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