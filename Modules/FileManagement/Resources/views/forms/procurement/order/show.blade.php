@extends('layouts.master')


@section('page-title')
Purchase Order
@endsection

@section('toolbar')
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
                <a href="{{ route('fms.procurement.order.edit', $po->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-contract"></i> Edit Document
                    </span>
                </a>
            </li>
            <li class="navi-item">
                <a href="{{ route('fms.documents.cancel.form', $po->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-cancel"></i> Cancel Document
                    </span>
                </a>
            </li>

            <li class="navi-separator mb-3 opacity-70"></li>


            <li class="navi-item">
                <a href="{{ route('fms.procurement.order.print', $po->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-printer"></i> Print Document
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a target="_new" href="{{ route('fms.documents.receipt', $po->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-copy"></i> Print Receipt
                    </span>
                </a>
            </li>

            <li class="navi-item">
                <a target="_new" href="{{ route('fms.documents.attach.form', $po->document_id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon2-clip-symbol"></i> Attach Document
                    </span>
                </a>
            </li>

            <li class="navi-separator mb-3 opacity-70"></li>

            <li class="navi-item">
                <a target="_new" href="{{ route('fms.procurement.request.show', $po->document->purchase_request->id) }}" class="navi-link">
                    <span class="navi-text">
                        <i class="flaticon-eye"></i> Show Purchase Request
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
        <x-fms-qr :document="$po->document" />
    </div>
    <div class="col-xl-8">
          <!--begin::Advance Table Widget 5-->
          <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Purchare Order Details</span>
                    {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-0">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td colspan="4" class="text-center"><strong>Supplier Information:</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Supplier:</strong></td>
                            <td>{{ $po->supplier['firm'] }}</td>
    
                            <td><strong>TIN:</strong></td>
                            <td>{{ $po->supplier['tin']}}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td colspan="3">{{ $po->supplier['address']}}</td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-center"><strong>Delivery Information:</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Place of Delivery:</strong></td>
                            <td>{{ $po->delivery['place'] }}</td>
    
                            <td><strong>Date of Delivery:</strong></td>
                            <td>{{ $po->delivery['date']}}</td>
                        </tr>
                        <tr>
                            <td><strong>Delivery Term:</strong></td>
                            <td>{{ $po->delivery['term'] }}</td>
    
                            <td><strong>Payment Term:</strong></td>
                            <td>{{ $po->delivery['payment']}}</td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-center"><strong>PO Information:</strong></td>
                        </tr>
                        <tr>
                            <td><strong>PO Number:</strong></td>
                            <td>{{ $po->number }}</td>
    
                            <td><strong>Date:</strong></td>
                            <td>{{ $po->created_at}}</td>
                        </tr>
                        <tr>
                            <td><strong>Mode of Procurement:</strong></td>
                            <td>{{ $po->mode_of_procurement }}</td>
    
                            <td><strong>PR Number/s:</strong></td>
                            <td>
                                {{ implode(', ', $po->pr_number ?? []) }}
                            </td>
                        </tr>
    
                        <tr>
                            <td><strong>Particulars:</strong></td>
                            <td colspan="3">{{ $po->particulars }}</td>
                           
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
                                @php($lists = collect($po->lists))

                                @foreach($lists as $i => $list)
                                    <?php 
                                        $amount = floatval($list['amount'] ?? 0);
                                        $qty = floatval($list['quantity'] ?? 0);
                                    ?>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $list['stock'] ?? '' }}</td>
                                        <td>{{ $list['unit'] ?? '' }}</td>
                                        <td>{{ $list['description'] ?? '' }}</td>
                                        <td>{{ $qty }}</td>
                                        <td class="text-right">
                                            {{ $amount }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($qty * $amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-right text-dark" colspan="6">TOTAL COST:</td>
                                    <td class="text-right text-dark" colspan="">
                                        {{ number_format($lists->sum(function($row){
                                            return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
                                        }), 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    
             
            </div>
            <!--end::Body-->
        </div>
        <!--end::Advance Table Widget 5-->
        <x-fms-attachments :attachments="$po->document->attachments" />
        
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


