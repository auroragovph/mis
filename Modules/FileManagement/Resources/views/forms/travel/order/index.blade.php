@extends('filemanagement::layouts.master')



@section('page-title')
Travel Order
@endsection

@section('page-action')
<a href="{{ route('fms.travel.order.create') }}" class="btn btn-primary">
    <x-ui.icon icon="plus" /> New Travel Order
</a>
@endsection

@section('content')
<x-ui.table.data-table-api title="Travel Lists" />
@endsection


