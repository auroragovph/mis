@extends('layouts.master')


@section('page-title')
Itinerary Of Travel
@endsection

@section('toolbar')
 <!--begin::Button-->
 <a href="{{ route('fms.travel.order.index') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base mr-2">
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
                <a href="{{ route('fms.travel.itinerary.edit', $iot->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-contract"></i> Edit Document
                    </span>
                </a>
            </li>
            <li class="navi-item">
                <a href="{{ route('fms.documents.cancel.index', $iot->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-cancel"></i> Cancel Document
                    </span>
                </a>
            </li>

            <li class="navi-separator mb-3 opacity-70"></li>


            <li class="navi-item">
                <a href="{{ route('fms.travel.itinerary.print', $iot->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-printer"></i> Print Document
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a target="_new" href="{{ route('fms.documents.receipt', $iot->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-copy"></i> Print Receipt
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a href="{{ route('fms.documents.attach.form', $iot->document_id) }}" class="navi-link">
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
        <x-fms-qr :document="$iot->document" />

    </div>
    <div class="col-xl-8">
          <!--begin::Advance Table Widget 5-->
          <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Itinerary of Travel Details</span>
                    {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-0">

                <div class="table-responsive">
                    <table class="table">

                        <tr>
                            <td><strong>Employee:</strong></td>
                            <td colspan="3">{{ name_helper($iot->employee->name) }}</td>
                        </tr>

                        <tr>
                            <td><strong>Number:</strong></td>
                            <td>{{ $iot->number }}</td>
                            <td><strong>Fund:</strong></td>
                            <td>{{ $iot->fund }}</td>
                        </tr>

                        <tr>
                            <td><strong>Date of Travel:</strong></td>
                            <td>{{ $iot->travel_date }}</td>
                            <td><strong>Purpose of Travel:</strong></td>
                            <td>{{ $iot->travel_purpose }}</td>
                        </tr>

                        <tr>
                            <td><strong>Signatories:</strong></td>

                            <td colspan="3">
                                {{ name_helper($iot->supervisor->name) }} (Supervisor) <br>
                                {{ name_helper($iot->head->name) }} (Approval) 
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
                            @foreach($iot->lists as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $list['date'] }}</td>
                                    <td>{{ $list['destination'] }}</td>
                                    <td>{{ $list['departure'] }}</td>
                                    <td>{{ $list['arrival'] }}</td>
                                    <td>{{ $list['means'] }}</td>
                                    <td>{{ pretty_number($list['trans']) }}</td>
                                    <td>{{ pretty_number($list['diem']) }}</td>
                                    <td>{{ pretty_number($list['other']) }}</td>
                                    <td>{{ pretty_number($list['trans'] + $list['other'] + $list['diem']) }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

              
            </div>
            <!--end::Body-->
        </div>
        <!--end::Advance Table Widget 5-->
        <x-fms-attachments :attachments="$iot->document->attachments" />
        
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


