@extends('layouts.system')


@section('page-title', 'Division')

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
                            <th>Office</th>
                            <th>Division Head</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php($can_edit = authenticated()->can('sys.office.edit'))

                        @foreach($divisions as $division)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $division->name }}</td>
                                <td>{{ $division->alias }}</td>
                                <td>{{ office_name($division->office) }}</td>
                                <td>{{ name_helper($division->head->name ?? null) }}</td>
                                <td class="text-center">
                                    @if($can_edit)
                                        <a href="{{ route('sys.admin.division.edit', $division->id) }}"
                                            class="btn btn-default btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
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
                @include('system::office.division.create')
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

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>


@endsection

@section('js-custom')
    <script src="{{ asset('/js/Modules/System/dt.js') }}"></script>
    <script src="{{ asset('/js/Modules/System/select2-init.js') }}"></script>

@endsection
