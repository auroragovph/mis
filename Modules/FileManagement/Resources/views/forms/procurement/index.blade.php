@extends('filemanagement::layouts.master')


@section('page-title', 'Procurement')


@section('page-action')
    <a href="{{ route('fms.procurement.request.create') }}" class="btn btn-primary">
        <x-ui.widget.svg>
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </x-ui.widget.svg>
        New Purchase Request
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <x-ui.table.data-table-api title="Procurement List" />
    </div>
</div>
@endsection
