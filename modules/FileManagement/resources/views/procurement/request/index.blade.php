@extends('fms::layouts.master')


@section('page-pretitle', 'Procurement')
@section('page-title', 'Purchase Request')

@section('page-actions')
    <a href="{{ route('fms.procurement.request.create') }}" class="btn btn-primary">
        <x-ui.icon icon="plus" />New Request
    </a>
@endsection

@section('content')

    <div class="row row-cards">
        <div class="col-12">
            <x-ui.table.data-api title="Purchase Request List" />
        </div>
    </div>


@endsection
