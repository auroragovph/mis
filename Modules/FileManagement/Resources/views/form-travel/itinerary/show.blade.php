@extends('filemanagement::layouts.app')

@section('page-title')
    Itinerary of Travel
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.travel.itinerary.index') }}">Itinerary</a></li>
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
                        <h3 class="font-weight-bold mt-2 card-title">Itinerary Details</h3>

                        <div class="card-tools">
                        
                            <button type="button" class="btn btn-sm bg-navy dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span> Action
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="{{ route('fms.travel.itinerary.edit', $document->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" href="{{ route('fms.documents.cancel', $document->id) }}"><i class="fas fa-ban"></i> Cancel</a>
                                
                                <div class="dropdown-divider"></div>
                                
                                <a class="dropdown-item" target="_blank" href="#"><i class="fas fa-print"></i> Print</a>
                                <a class="dropdown-item" href="{{ route('fms.documents.attach.form', $document->id) }}"><i class="fas fa-paperclip"></i> Attach</a>
                            </div>
                            
                        </div>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">

                                <tr>
                                    <td><strong>Employee:</strong></td>
                                    <td colspan="3">{{ name_helper($document->itinerary->employee->name) }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Number:</strong></td>
                                    <td>{{ $document->itinerary->number }}</td>
                                    <td><strong>Fund:</strong></td>
                                    <td>{{ $document->itinerary->fund }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Date of Travel:</strong></td>
                                    <td>{{ $document->itinerary->properties['date'] }}</td>
                                    <td><strong>Purpose of Travel:</strong></td>
                                    <td>{{ $document->itinerary->properties['purpose'] }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Signatories:</strong></td>

                                    <td colspan="3">
                                        {{ name_helper($document->itinerary->supervisor->name) }} (Supervisor) <br>
                                        {{ name_helper($document->itinerary->approval->name) }} (Approval) 
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mt-10">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Destination</th>
                                        <th>Departure</th>
                                        <th>Arrival</th>
                                        <th>Means of <br> Transportation</th>
                                        <th>Transportation</th>
                                        <th>Per diem</th>
                                        <th>Others</th>
                                        <th>Total Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($document->itinerary->lists as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $list['date'] }}</td>
                                            <td>{{ $list['destination'] }}</td>
                                            <td>{{ $list['departure'] }}</td>
                                            <td>{{ $list['arrival'] }}</td>
                                            <td>{{ $list['means'] }}</td>
                                            <td>{{ $list['trans'] }}</td>
                                            <td>{{ $list['diem'] }}</td>
                                            <td>{{ $list['other'] }}</td>
                                            <td>{{ $list['amount'] }}</td>
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