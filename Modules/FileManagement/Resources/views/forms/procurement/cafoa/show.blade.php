@extends('layouts.master')


@section('page-title')
CAFOA (Procurement)
@endsection

@section('toolbar')
    @include('filemanagement::forms.procurement.cafoa.action')
@endsection

@section('content')
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr :document="$cafoa->document" />
    </div>
    <div class="col-xl-8">

        <x-ui.card title="CAFOA Details">

            <div class="table-responsive">
                <table class="table table-hover mt-3 table-sm">
    
                    <tr>
                        <td><strong>Obligation No:</strong></td>
                        <td>{{ $cafoa->number }}</td>
                        <td><strong>Payee: </strong></td>
                        <td>{{ $cafoa->payee }}</td>
                    </tr>
    
                    <tr>
                        <td colspan="2"><strong>Requesting Officer:</strong></td>
                        <td colspan="2">{{ name_helper($cafoa->requesting->name ?? '') }}</td>
                    </tr>
    
                    <tr>
                        <td colspan="2"><strong>Signatory Officers:</strong></td>
                        <td colspan="2">
                            {{ name_helper($cafoa->accounting->name ?? '') }} (Accounting) <br>
                            {{ name_helper($cafoa->treasury->name ?? '') }} (Treasury) <br>
                            {{ name_helper($cafoa->budget->name ?? '') }} (Budget) <br>
                        </td>
                    </tr>
    
    
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mt-5 table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Function</th>
                            <th>Allotment Class</th>
                            <th>Expense Code</th>
                            <th class="text-right">Amount</th>
                        </tr>
    
                       
                    </thead>
                    <tbody>
                        @php($lists = collect($cafoa->lists))
                        
                        @foreach($lists as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list['function'] ?? '' }}</td>
                                <td>{{ $list['allotment'] ?? '' }}</td>
                                <td>{{ $list['expense'] ?? '' }}</td>
                                <td class="text-right">{{ number_format(floatval($list['amount'] ?? 0), 2) }}</td>
                            </tr>
                        @endforeach
                            <tr>
                                <td colspan="4" class="text-right"><strong>TOTAL AMOUNT:</strong></td>
                                <td colspan="1" class="text-right">
                                    <strong>
                                        {{ number_format($lists->sum(function($val){
                                            return floatval($val['amount'] ?? 0);
                                            }), 2) }}
                                    </strong>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>



        </x-ui.card>
        
        <x-fms-attachments :attachments="$cafoa->document->attachments" />
        
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


