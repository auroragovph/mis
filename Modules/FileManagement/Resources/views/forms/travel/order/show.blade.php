@extends('layouts.master')


@section('page-title')
Travel Order
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
                <a href="{{ route('fms.travel.order.edit', $to->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-contract"></i> Edit Document
                    </span>
                </a>
            </li>
            <li class="navi-item">
                <a href="{{ route('fms.documents.cancel.index', $to->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-cancel"></i> Cancel Document
                    </span>
                </a>
            </li>

            <li class="navi-separator mb-3 opacity-70"></li>


            <li class="navi-item">
                <a href="{{ route('fms.travel.order.print', $to->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-printer"></i> Print Document
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a target="_new" href="{{ route('fms.documents.receipt', $to->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-copy"></i> Print Receipt
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a href="{{ route('fms.documents.attach.form', $to->document_id) }}" class="navi-link">
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
        <x-fms-qr :document="$to->document" />

    </div>
    <div class="col-xl-8">
          <!--begin::Advance Table Widget 5-->
          <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Travel Order Details</span>
                    {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-0">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td><strong>TO No:</strong></td>
                            <td>{{ $to->number }}</td>
                            <td><strong>Destination: </strong></td>
                            <td>{{ $to->destination }}</td>
                        </tr>
    
                        <tr>
                            <td><strong>Departure:</strong></td>
                            <td>{{ Carbon\Carbon::parse($to->departure)->format('F d, Y') }}</td>
                            <td><strong>Arrival: </strong></td>
                            <td>{{ Carbon\Carbon::parse($to->departure)->format('F d, Y') }}</td>
                        </tr>
    
    
                        <tr>
                            <td><strong>Charging Office:</strong></td>
                            <td>{{ office_helper($to->charging) }}</td>
                            <td><strong>Approval Officer: </strong></td>
                            <td>{{ name_helper($to->approval->name ?? '') }}</td>
                        </tr>
    
                        <tr>
                            <td><strong>Purpose:</strong></td>
                            <td>{{ $to->purpose }}</td>
                            <td><strong>Special Instruction: </strong></td>
                            <td>{{ $to->instruction }}</td>
                        </tr>
    
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Position</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($to->lists as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ name_helper($list->employee->name ?? []) }}</td>
                                    <td>{{ $list->employee->position->position ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Advance Table Widget 5-->
        <x-fms-attachments :attachments="[]" />
        
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


