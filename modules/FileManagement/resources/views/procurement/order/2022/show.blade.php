@extends('fms::layouts.master')



@section('page-title', 'Purchase Order')
@section('page-pretitle', 'Procurement')

@section('content')
    <div class="row row-cards">
        <div class="col-md-3">
            <x-fms-qr :series="$po->series" />
        </div>
        <div class="col-md-9">

            <div class="row row-cards">
                <div class="col-12">
                    <x-ui.card title="Purchase Order Details">

                        <x-slot name="actions">

                            @if ($po->series->status !== \DocumentStatusEnum::CANCELLED->value)
                                <a href="{{ route('fms.procurement.order.edit', $po->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <x-ui.icon icon="pencil" />
                                    Edit
                                </a>
                            @endif

                            <a href="{{ route('fms.procurement.order.show', $po->id) }}?print=1"
                                class="btn btn-default btn-sm">
                                <x-ui.icon icon="printer" class="text-muted" />
                                Print
                            </a>


                        </x-slot>

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <tr>
                                    <td colspan="4" class="text-center"><strong>Supplier Information:</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Supplier:</strong></td>
                                    <td>{{ $po->supplier['name'] }}</td>

                                    <td><strong>TIN:</strong></td>
                                    <td>{{ $po->supplier['tin'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Address:</strong></td>
                                    <td colspan="3">{{ $po->supplier['address'] }}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-center"><strong>Delivery Information:</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Place of Delivery:</strong></td>
                                    <td>{{ $po->delivery['place'] }}</td>

                                    <td><strong>Date of Delivery:</strong></td>
                                    <td>{{ $po->delivery['date'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Delivery Term:</strong></td>
                                    <td>{{ $po->delivery['term'] }}</td>

                                    <td><strong>Payment Term:</strong></td>
                                    <td>{{ $po->delivery['payment'] }}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-center"><strong>PO Information:</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>PO Number:</strong></td>
                                    <td>{{ $po->number }}</td>

                                    <td><strong>Date:</strong></td>
                                    <td>{{ $po->created_at }}</td>
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

                    </x-ui.card>
                </div>
                <div class="col-12">
                    <x-ui.table.regular title="Items">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Stock</th>
                                <th class="text-center">Unit</th>
                                <th>Description</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Cost</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($po->items as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $list['stock'] }}</td>
                                    <td class="text-center">{{ $list['unit'] }}</td>
                                    <td>{{ $list['description'] }}</td>
                                    <td class="text-center">{{ $list['quantity'] }}</td>
                                    <td class="text-end">{{ number_format($list['amount'], 2) }}</td>
                                    <td class="text-end">{{ number_format($list['cost'], 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-end"><strong>TOTAL:</strong></td>
                                <td class="text-end">
                                    {{ number_format($po->total_amount, 2) }}
                                </td>
                            </tr>
                        </tbody>
                        </x-ui.table.table>
                </div>
                <div class="col-12">
                    <x-fms-attachments :attachments="$po->series->attachments" :forms="$po->series->forms" />
                </div>
            </div>
        </div>
    </div>
@endsection
