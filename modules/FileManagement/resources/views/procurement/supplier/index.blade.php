@extends('fms::layouts.master')


@section('page-pretitle', 'Procurement')
@section('page-title', 'Supplier')

@section('page-actions')
<a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal">
    Simple modal
</a>
@endsection

@section('content')
{{-- <div class="row row-cards">
    <div class="col-12">
        <x-ui.table.data>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Address</th>
                    <th>TIN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->owner }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>{{ $supplier->tin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table.data>
    </div>
</div> --}}

@livewire('supplier')

@include('fms::procurement.supplier.create')
@endsection

