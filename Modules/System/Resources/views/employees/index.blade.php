@extends('layouts.system')


@section('page-title', 'Employees')

@section('toolbar')
<a href="{{ route('sys.admin.employee.create') }}" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> New Employee</a>
@endsection

@section('content')
<x-ui.card>
  <table id="dt_table" class="table table-bordered table-striped table-sm">
      <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Office</th>
              <th>Position</th>
              <th>Appointment</th>
              <th>Action</th>
            </tr>
      </thead>
      <tbody>
            @php($can_edit = authenticated()->can('sys.employee.update'))
            @foreach($employees as $employee)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ name_helper($employee->name) }}</td>
                <td>{{ office_helper($employee->division) }}</td>
                <td>{{ $employee->position->name ?? null }}</td>
                <td>{{ $employee->employment['type'] ?? null }}</td>
                <td class="text-center">
                  @if($can_edit)
                    <a href="{{ route('sys.admin.employee.edit', $employee->id) }}" class="btn btn-xs btn-default" ><i class="fas fa-edit"></i></a>
                  @endif
                </td>
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


