@extends('layouts.master')


@section('page-title')
Purchase Request
@endsection

@section('toolbar')
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
           
            <x-ui.card.title title="Purchase Request Details" />
            
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
                        <table class="table table-hover mt-10 table-sm">
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


