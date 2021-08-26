@extends('layouts.system')


@section('page-title', 'Office')

@section('toolbar')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            @can('sys.office.read')
            <x-ui.card>
                <table id="dt_table" class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Alias</th>
                            <th>Divisions</th>
                            <th>Department Head</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offices as $office)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $office->name }}</td>
                                <td>{{ $office->alias }}</td>
                                <td>{{ count($office->divisions) - 1 }}</td>
                                <td>{{ name_helper($office->head->name ?? null) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('sys.admin.office.edit', $office->id) }}"
                                        class="btn btn-default btn-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-ui.card>
            @endcan
        </div>
        <div class="col-md-4">
            @can('sys.office.create')
                @include('system::office.create')
            @endcan
        </div>
    </div>
@endsection


@section('css-vendor')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">


@endsection

@section('css-custom')
@endsection


@section('js-vendor')

   

    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>


@endsection

@section('js-custom')
    <script src="{{ asset('/js/Modules/System/dt.js') }}"></script>
    <script src="{{ asset('/js/Modules/System/select2-init.js') }}"></script>

@endsection
