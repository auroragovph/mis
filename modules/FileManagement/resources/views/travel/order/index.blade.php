@extends('fms::layouts.master')


@section('page-pretitle', 'Travels')
@section('page-title', 'Order')

@section('page-actions')
<a href="{{ route('fms.travel.order.create') }}" class="btn btn-primary">
<x-ui.icon icon="plus" /> New Travel Order
</a>
@endsection

@section('content')
<div class="row row-cards">
    <div class="col-12">
        <x-ui.table.data title="Travel Orders">
            <thead>
                <tr>
                    <th>#</th>
                    <th>QR Code</th>
                    <th>Number</th>
                    <th>Destination</th>
                    <th>Employees</th>
                    <th>Purpose</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tos as $to)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $to->series->qrcode }}</td>
                        <td>{{ $to->number }}</td>
                        <td>{{ $to->destination }}</td>
                        <td>{{ collect($to->employees)->pluck('name')->implode(', ') }}</td>
                        <td>{{ $to->purpose }}</td>
                        <td>
                            <a href="{{ route('fms.travel.order.show', $to->id) }}">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table.data>
    </div>
</div>
@endsection

