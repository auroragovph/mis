@extends('bac::layouts.master')



@section('page-title', 'Suppliers')

@section('page-action')
    <a href="{{ route('bac.supplier.create') }}" class="btn btn-primary px-3 font-size-base">
        <x-ui.icon icon="plus" /> New Supplier
    </a>
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-md-8">
            <x-ui.table.data-table-api title="Supplier Lists" />
        </div>
        <div class="col-md-4">
            @include('bac::supplier.create')
        </div>
    </div>
@endsection


<x-include.form.ajax />



