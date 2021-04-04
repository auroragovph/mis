@extends('layouts.master')


@section('page-title')
CAFOA
@endsection

@section('toolbar')
<a href="{{ route('fms.cafoa.create') }}" class="btn btn-primary px-3 font-size-base">
    <i class="fas fa-plus"></i> New CAFOA
</a>
@endsection

@section('content')
<x-ui.card>
    <table id="kt_datatable_fms_cafoa_list" class="table table-bordered table-striped table-sm">
        <thead>
              <tr>
                <th>QR</th>
                <th>Number</th>
                <th>Office</th>
                <th>Payee</th>
                <th>Particulars</th>
                <th>Amount</th>
                <th>Action</th>
              </tr>
        </thead>
    </table>
</x-ui.card>
@endsection


@section('css-vendor')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/forms/cafoa/index.js') }}"></script>
@endsection


