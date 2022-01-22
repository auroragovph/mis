@extends('fms::layouts.master')

@section('page-title', 'Purchase Request')
@section('page-pretitle', 'Procurement')


@section('page-action')

@endsection

@section('content')
    <div class="row row-cards">

        <div class="col-md-3">
            <x-fms-qr :series="$pr->series" />
        </div>

        <div class="col-md-9">
            <div class="row row-cards">
                <div class="col-12">
                    <x-ui.card title="Purchase Request Detail">

                        <x-slot name="actions">
                            @include('fms::procurement.request.button')
                        </x-slot>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <td><strong>PR Number:</strong></td>
                                    <td>{{ $pr->number }}</td>

                                    <td><strong>Date:</strong></td>
                                    <td>{{ $pr->series->encoded }}</td>
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
                    <x-ui.table.regular title="Items">
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
                            @foreach($pr->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['stock'] }}</td>
                                    <td>{{ $item['unit'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td class="text-end">{{ number_format($item['cost'], 2) }}</td>
                                    <td class="text-end">{{ number_format($item['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-end" colspan="6">TOTAL AMOUNT</th>
                                <th class="text-end">{{ number_format($pr->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </x-ui.table.regular>
                </div>

                <div class="col-12">
                    <x-fms-attachments :attachments="$pr->series->attachments" :forms="$pr->series->forms" />
                </div>
            </div>
        </div>
    </div>
@endsection
