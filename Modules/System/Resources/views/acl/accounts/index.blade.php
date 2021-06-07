@extends('layouts.system')


@section('page-title', 'Accounts')

@section('action')
@endsection

@section('content')
<x-ui.card>
  <table id="dt_table" class="table table-bordered table-striped table-sm">
      <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Username</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
      </thead>
      <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ name_helper($account->employee->name) }}</td>
                    <td>{{ strtolower($account->username) }}</td>
                    <td>
                      {{ $account->roles->first() }}
                    </td>
                    <td></td>
                </tr>
            @endforeach
      </tbody>
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
<script src="{{ asset('/js/Modules/System/dt.js') }}"></script>
@endsection


