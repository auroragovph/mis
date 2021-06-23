@extends('layouts.master')


@section('page-title')
Inspection and Acceptance Report
@endsection

@section('toolbar')
    
@endsection

@section('content')
<div class="row">
    
    <div class="col-xl-3">
        <x-fms-qr :document="$air->document" />
    </div>

    <div class="col-xl-9">

        <x-ui.card>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <tr>
                        <td colspan="4" class="text-center"><strong>Supplier Information</strong></td>
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
                        <td colspan="4" class="text-center"><strong>Purchase Order Information</strong></td>
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

            <hr>

            <div class="table-responsive">
                <h5>Received Items</h5>
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
        </x-ui.card>
        
        <x-fms-attachments :attachments="$air->document->attachments" />
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


