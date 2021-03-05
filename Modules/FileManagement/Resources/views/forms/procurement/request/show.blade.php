@extends('layouts.master')


@section('page-title')
Purchase Request
@endsection

@section('toolbar')
 <!--begin::Button-->
 <a href="{{ route('fms.procurement.request.index') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base mr-2">
    <i class="fal fa-arrow-left"></i> Return back
</a>
<!--end::Button-->

@include('filemanagement::forms.procurement.request.action_button')

@endsection

@section('content')
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr :document="$pr->document" />
    </div>
    <div class="col-xl-8">
          <!--begin::Advance Table Widget 5-->
          <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Purchare Request Details</span>
                    {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span> --}}
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-0">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td><strong>PR Number:</strong></td>
                            <td>{{ $pr->number }}</td>
    
                            <td><strong>Date:</strong></td>
                            <td>{{ $pr->document->encoded }}</td>
                        </tr>
    
                        <tr>
                            <td><strong>Signatories:</strong></td>
                            <td colspan="3">
                                {{ name_helper($pr->requesting->name) }} (Requesting) <br>
                                {{ name_helper($pr->treasury->name) }} (Treasury) <br>
                                {{ name_helper($pr->approval->name) }} (Approval) <br>
                            </td>
    
                        </tr>
    
                        <tr>
                            <td><strong>Purpose:</strong></td>
                            <td colspan="3">{{ $pr->purpose }}</td>
                           
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
                                @php($lists = collect($pr->lists))

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
        <x-fms-attachments :attachments="$pr->document->attachments" />
        
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


