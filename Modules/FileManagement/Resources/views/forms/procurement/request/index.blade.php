@extends('filemanagement::layouts.master')



@section('page-title')
Purchase Request (PR)
@endsection

@section('page-action')
<a href="{{ route('fms.procurement.request.create') }}" class="btn btn-primary px-3 font-size-base">
    <x-ui.icon icon="plus" /> New Purchase Request
</a>
@endsection

@section('content')
<x-ui.table.data-table-api title="Request Lists" />
@endsection


