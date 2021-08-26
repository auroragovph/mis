@extends('layouts.tabler.horizontal')


@section('page-title')
CAFOA
@endsection

@section('page-action')

@include('filemanagement::forms._includes.buttons', [
    'qrcode' => $cafoa->document->qr,
    'document_id' => $cafoa->document->id
])
@endsection

@section('content')
<div class="row row-cards">

    <div class="col-md-3">
        <x-fms-qr :document="$cafoa->document" />
    </div>

    <div class="col-md-9">
        <div class="row row-cards">
            <div class="col-12">
                <x-ui.card title="CAFOA Details">

                    <x-slot name="actions">
                        @include('filemanagement::forms.cafoa.buttons')
                    </x-slot>

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
                                <td colspan="2">{{ $cafoa->signatories['requester']['name'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Particulars:</strong></td>
                                <td colspan="2">{{ $cafoa->particulars }}</td>
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
                            <th>Function</th>
                            <th>Allotment Class</th>
                            <th>Expense Code</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cafoa->lists as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list['function'] ?? '' }}</td>
                            <td>{{ $list['allotment'] ?? '' }}</td>
                            <td>{{ $list['expense'] ?? '' }}</td>
                            <td class="text-end">{{ number_format(floatval($list['amount'] ?? 0), 2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end"><strong>TOTAL AMOUNT:</strong></td>
                            <td colspan="1" class="text-end">
                                <strong>
                                    {{ number_format($cafoa->total_amount, 2) }}
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </x-ui.table.table>
            </div>
            <div class="col-12">
                <x-fms-attachments :attachments="$cafoa->document->attachments" :forms="$cafoa->document->forms" />

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


