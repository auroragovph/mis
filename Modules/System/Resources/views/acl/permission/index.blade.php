@extends('layouts.system')


@section('page-title', 'Permissions')

@section('action')
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <x-ui.card>
            <table id="dt_table" class="table table-bordered table-striped table-sm">
                <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Associated Roles</th>
                        <th>Accounts</th>
                        <th>Action</th>
                      </tr>
                </thead>
                <tbody>
                    @foreach($perms as $perm)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $perm->name }}</td>
                            <td>
                                @foreach($perm->roles->pluck('name') as $role)
                                    <span class="right badge badge-info">{{ $role }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $perm->users->count() }}
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </x-ui.card>
    </div>
</div>
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
<script src="{{ asset('/js/Modules/System/dt.js') }}"></script>
@endsection


