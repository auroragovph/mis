@extends('fms::layouts.master')


@section('page-pretitle', 'Procurement')
@section('page-title', 'Management Plan')


@section('content')
<x-ui.table.data title="PPMP Lists">
    <thead>
        <tr>
            <th>#</th>
            <th>Fiscal Year</th>
            <th>Total Budget</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ppmps as $ppmp)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ppmp->fiscal_year }}</td>
            <td>{{ number_format($ppmp->total_budget, 2) }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</x-ui.table.data>
@endsection

