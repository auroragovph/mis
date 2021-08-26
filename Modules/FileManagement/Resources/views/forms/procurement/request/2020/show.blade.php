@extends('filemanagement::layouts.master')



@section('page-title')
Purchase Request
@endsection

@section('page-action')
    @include('filemanagement::forms._includes.buttons', [
        'qrcode' => $pr->document->qr,
        'document_id' => $pr->document->id
    ])
@endsection

@section('content')
<div class="row row-cards">
    
    <div class="col-md-3">
        <x-fms-qr :document="$pr->document" />
    </div>

    <div class="col-md-9">
        <div class="row row-cards">
            <div class="col-12">
                <x-ui.card title="Purchase Request Detail">

                    <x-slot name="actions">
                        @include('filemanagement::forms.procurement.request.buttons')
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <td><strong>PR Number:</strong></td>
                                <td>{{ $pr->number }}</td>
                    
                                <td><strong>Date:</strong></td>
                                <td>{{ $pr->document->encoded }}</td>
                            </tr>
                    
                           
                    
                            <tr>
                                <td><strong>Particulars:</strong></td>
                                <td>{{ $pr->particulars }}</td>
        
                                <td><strong>Purpose:</strong></td>
                                <td>{{ $pr->purpose }}</td>
                               
                            </tr>
        
                            <tr>
                                <td><strong>Signatories:</strong></td>
                                <td colspan="3">
                                   
                                </td>
                    
                            </tr>
                        </table>
                    </div>
                    
        
        
                </x-ui.card>
            </div>

            <div class="col-12">
                <x-ui.table.table title="Items">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Stock No.</th>
                            <th>Unit</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th class="text-end">Unit Cost</th>
                            <th class="text-end">Total Cost</th>
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
                                <td class="text-end">
                                    {{ $amount }}
                                </td>
                                <td class="text-end">
                                    {{ number_format($qty * $amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-end fw-bold" colspan="6"><strong>TOTAL COST:</strong></td>
                            <td class="text-end fw-bold" colspan="">
                                {{ number_format($lists->sum(function($row){
                                    return (floatval($row['quantity'] ?? 0) * floatval($row['amount'] ?? 0));
                                }), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </x-ui.table.table>
            </div>

            <div class="col-12">
                <x-fms-attachments :attachments="$pr->document->attachments" :forms="$pr->document->forms" />
            </div>
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


