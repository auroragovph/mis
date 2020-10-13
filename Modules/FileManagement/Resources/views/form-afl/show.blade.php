@extends('filemanagement::layouts.app')

@section('page-title')
    Travel Order
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.afl.index') }}">AFL</a></li>
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
                        <h3 class="font-weight-bold mt-2 card-title">Leave Details</h3>
    
                        <div class="card-tools">
                        
                            <button type="button" class="btn btn-sm bg-navy dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span> Action
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="{{ route('fms.afl.edit', $document->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                <a class="dropdown-item" href="{{ route('fms.documents.cancel', $document->id) }}"><i class="fas fa-ban"></i> Cancel</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" target="_blank" href="{{ route('fms.travel.order.print', $document->id) }}"><i class="fas fa-print"></i> Print</a>
                                <a class="dropdown-item" href="{{ route('fms.documents.attach.form', $document->id) }}"><i class="fas fa-paperclip"></i> Attach</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                @switch($document->afl->properties['type'])

                                    @case('Vacation')
                                    
                                            <tr>
                                                <td><strong>Leave Type:</strong></td>
                                                <td>Vacation</td>
                                                <td><strong>Reason:</strong></td>
                                                <td>
                                                    @if($document->afl->properties['details']['reason'] == 'tse')
                                                        To seek employment
                                                    @else 
                                                        {{ $document->afl->properties['details']['reason'] }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Where leave will be spent:</strong></td>
                                                <td colspan="3">
                                                    @if($document->afl->properties['details']['place'] == 'ph')
                                                        Within the Philippines
                                                    @else 
                                                        {{ $document->afl->properties['details']['place'] }}
                                                    @endif
                                                </td>
                                            </tr>
                                    
                                    @break 

                                    @case('Sick')
                                    
                                            <tr>
                                                <td><strong>Leave Type:</strong></td>
                                                <td>Sick</td>
                                                <td><strong>Hospital:</strong></td>
                                                <td>{{ $document->afl->properties['details'] }}</td>
                                            </tr>
                                            
                                    
                                    @break


                                    @default 
                                        <tr>
                                            <td><strong>Leave Type:</strong></td>
                                            <td colspan="3">
                                                @if($document->afl->properties['details'] == null)
                                                    {{ $document->afl->properties['type'] }}
                                                @else 
                                                    {{ $document->afl->properties['details'] }}
                                                @endif
                                            </td>
                                       
                                        </tr>
                                    @break

                                    

                                @endswitch
                                
                                <tr>
                                    <td><strong>Inclusive Dates:</strong></td>
                                    <td colspan="3">
                                        @foreach($document->afl->inclusives as $date)
                                            {{ Carbon\Carbon::parse($date)->format('F d, Y') }} <br>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Commutation:</strong></td>
                                    <td colspan="3">
                                        @if($document->afl->properties['commutation'])
                                            Requested
                                        @else 
                                            Not Requested
                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <h5 class="mt-3">Application Details of Action</h5>
                        <hr>
        

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Certification of Leave Credits as of:</strong> <br> {{ Carbon\Carbon::parse($document->afl->credits['as-of'])->format('F d, Y') }}</p>
                                <table class="table table-sm table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $document->afl->credits['vacation'][0] }}</td>
                                            <td>{{ $document->afl->credits['sick'][0] }}</td>
                                            <td>{{ $document->afl->credits['vacation'][0] + $document->afl->credits['sick'][0]}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $document->afl->credits['vacation'][1] }}</td>
                                            <td>{{ $document->afl->credits['sick'][1] }}</td>
                                            <td>{{ $document->afl->credits['vacation'][1] + $document->afl->credits['sick'][1]}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $document->afl->credits['vacation'][0] - $document->afl->credits['vacation'][1] }}</td>
                                            <td>{{ $document->afl->credits['sick'][0] - $document->afl->credits['sick'][1] }}</td>
                                            <td>{{ ($document->afl->credits['vacation'][0] - $document->afl->credits['vacation'][1] ) +  ($document->afl->credits['sick'][0] - $document->afl->credits['sick'][1])}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Signatories</h5>
                                <hr>

                                <p class="text-center"><strong>{{ name_helper($document->afl->approval->name) }}</strong> <br> <small>Approving Officer</small> </p>
                                <p class="text-center"><strong>{{ name_helper($document->afl->hr->name) }}</strong> <br> <small>HRMO Officer</small> </p>


                            </div>
                        </div>


                       
                    </div>
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