@extends('layouts.tabler.horizontal')


@section('page-title')
CAFOA
@endsection

@section('page-action')
<a href="{{ route('fms.cafoa.create') }}" class="btn btn-primary px-3 font-size-base">
    <x-ui.icon icon="plus" /> New CAFOA
</a>
@endsection

@section('content')
<x-ui.table.data-table-api title="CAFOA Lists" />
@endsection

