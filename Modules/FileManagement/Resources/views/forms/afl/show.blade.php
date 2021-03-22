@extends('layouts.master')


@section('page-title')
Application For Leave
@endsection

@section('toolbar')
 <!--begin::Button-->
 <a href="{{ route('fms.cafoa.index') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base mr-2">
    <i class="fal fa-arrow-left"></i> Return back
</a>
<!--end::Button-->

<!--begin::Dropdown-->
<div class="dropdown dropdown-inline">
    <a href="#" class="btn btn-light-dark btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <i class="flaticon2-menu-2"></i> Actions
    </a>
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right py-3 m-0">
        <!--begin::Navigation-->
        <ul class="navi navi-hover">

            <li class="navi-header font-weight-bold py-4">
                <span class="font-size-lg">Actions:</span>
            </li>

            <li class="navi-separator mb-3 opacity-70"></li>

            <li class="navi-item">
                <a href="{{ route('fms.cafoa.edit', $afl->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-contract"></i> Edit Document
                    </span>
                </a>
            </li>
            <li class="navi-item">
                <a href="{{ route('fms.documents.cancel.form', $afl->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-cancel"></i> Cancel Document
                    </span>
                </a>
            </li>

            <li class="navi-separator mb-3 opacity-70"></li>


            <li class="navi-item">
                <a href="{{ route('fms.travel.order.print', $afl->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-printer"></i> Print Document
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a target="_new" href="{{ route('fms.documents.receipt', $afl->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-copy"></i> Print Receipt
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a target="_new" href="{{ route('fms.documents.attach.form', $afl->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-clip-symbol"></i> Attach Document
                    </span>
                </a>
            </li>
        </ul>
        <!--end::Navigation-->
    </div>
</div>
<!--end::Dropdown-->
@endsection

@section('content')
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr :document="$afl->document" />
    </div>
    <div class="col-xl-8">
          <!--begin::Advance Table Widget 5-->
          <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">AFL Details</span>
                    {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-0">
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td><strong>Employe:</strong></td>
                            <td colspan="3">{{ name_helper($afl->employee->name) }}</td>
                        </tr>
                        @switch($afl->properties['type'])

                            @case('Vacation')
                            
                                    <tr>
                                        <td><strong>Leave Type:</strong></td>
                                        <td>Vacation</td>
                                        <td><strong>Reason:</strong></td>
                                        <td>
                                            @if($afl->properties['details']['reason'] == 'tse')
                                                To seek employment
                                            @else 
                                                {{ $afl->properties['details']['reason'] }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Where leave will be spent:</strong></td>
                                        <td colspan="3">
                                            @if($afl->properties['details']['place'] == 'ph')
                                                Within the Philippines
                                            @else 
                                                {{ $afl->properties['details']['place'] }}
                                            @endif
                                        </td>
                                    </tr>
                            
                            @break 

                            @case('Sick')
                            
                                    <tr>
                                        <td><strong>Leave Type:</strong></td>
                                        <td>Sick</td>
                                        <td><strong>Hospital:</strong></td>
                                        <td>{{ $afl->properties['details'] }}</td>
                                    </tr>
                                    
                            
                            @break


                            @default 
                                <tr>
                                    <td><strong>Leave Type:</strong></td>
                                    <td colspan="3">
                                        @if($afl->properties['details'] == null)
                                            {{ $afl->properties['type'] }}
                                        @else 
                                            {{ $afl->properties['details'] }}
                                        @endif
                                    </td>
                               
                                </tr>
                            @break

                            

                        @endswitch
                        
                        <tr>
                            <td><strong>Inclusive Dates:</strong></td>
                            <td colspan="3">
                                @foreach($afl->inclusives as $date)
                                    {{ Carbon\Carbon::parse($date)->format('F d, Y') }} <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Commutation:</strong></td>
                            <td colspan="3">
                                @if($afl->properties['commutation'])
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
                                <p><strong>Certification of Leave Credits as of:</strong> <br> {{ Carbon\Carbon::parse($afl->credits['as-of'])->format('F d, Y') }}</p>
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
                                            <td>{{ $afl->credits['vacation'][0] }}</td>
                                            <td>{{ $afl->credits['sick'][0] }}</td>
                                            <td>{{ $afl->credits['vacation'][0] + $afl->credits['sick'][0]}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $afl->credits['vacation'][1] }}</td>
                                            <td>{{ $afl->credits['sick'][1] }}</td>
                                            <td>{{ $afl->credits['vacation'][1] + $afl->credits['sick'][1]}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $afl->credits['vacation'][0] - $afl->credits['vacation'][1] }}</td>
                                            <td>{{ $afl->credits['sick'][0] - $afl->credits['sick'][1] }}</td>
                                            <td>{{ ($afl->credits['vacation'][0] - $afl->credits['vacation'][1] ) +  ($afl->credits['sick'][0] - $afl->credits['sick'][1])}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Signatories</h5>
                                <hr>

                                <p class="text-center"><strong>{{ name_helper($afl->approval->name) }}</strong> <br> <small>Approving Officer</small> </p>
                                <p class="text-center"><strong>{{ name_helper($afl->hr->name) }}</strong> <br> <small>HRMO Officer</small> </p>


                            </div>
                        </div>
             
            </div>
            <!--end::Body-->
        </div>
        <!--end::Advance Table Widget 5-->
        <x-fms-attachments :attachments="$afl->document->attachments" />
        
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


