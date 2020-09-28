@extends('filemanagement::layouts.app')

@section('page-title')
    Travel Order
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.travel.order.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">Show</li>
</ol>
@endsection

@section('content')
<div class="row">
    
    <x-fms-qr size="sm-4" :document="$document" />
   
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-default">

                    <div class="card-header">
                        <h3 class="font-weight-bold mt-2 card-title">Travel Order Details</h3>

                        <div class="card-tools">
                        
                            <button type="button" class="btn btn-sm bg-navy dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span> Action
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="{{ route('fms.travel.order.edit', $document->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" href="{{ route('fms.documents.cancel', $document->id) }}"><i class="fas fa-ban"></i> Cancel</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" target="_blank" href="{{ route('fms.travel.order.print', $document->id) }}"><i class="fas fa-print"></i> Print</a>
                                <a class="dropdown-item" href="{{ route('fms.documents.attach.form', $document->id) }}"><i class="fas fa-paperclip"></i> Attach</a>
                            </div>
                            
                        </div>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <td><strong>TO No:</strong></td>
                                    <td>{{ $document->travel_order->number }}</td>
                                    <td><strong>Destination: </strong></td>
                                    <td>{{ $document->travel_order->destination }}</td>
                                </tr>
            
                                <tr>
                                    <td><strong>Departure:</strong></td>
                                    <td>{{ Carbon\Carbon::parse($document->travel_order->departure)->format('F d, Y') }}</td>
                                    <td><strong>Arrival: </strong></td>
                                    <td>{{ Carbon\Carbon::parse($document->travel_order->arrival)->format('F d, Y') }}</td>
                                </tr>
            
            
                                <tr>
                                    <td><strong>Charging Office:</strong></td>
                                    <td>{{ office_helper($document->travel_order->charging) }}</td>
                                    <td><strong>Approval Officer: </strong></td>
                                    <td>{{ name_helper($document->travel_order->approval->name) }}</td>
                                </tr>
            
                                <tr>
                                    <td><strong>Purpose:</strong></td>
                                    <td>{{ $document->travel_order->purpose }}</td>
                                    <td><strong>Special Instruction: </strong></td>
                                    <td>{{ $document->travel_order->instruction }}</td>
                                </tr>
            
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mt-10">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Position</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($document->travel_order->employees as $employee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                        <td>{{ name_helper($employee->name) }}</td>
                                        <td>{{ $employee->position->position }}</td>
                                        <td></td>
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