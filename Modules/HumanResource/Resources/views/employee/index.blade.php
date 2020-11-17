@extends('humanresource::layouts.app')

@section('page-title')
    Employees
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('hrm.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-1">Lists</h3>
                <div class="card-tools">
                   <a href="{{ route('hrm.employee.create') }}" class="btn btn-sm bg-gradient-primary"><i class="fal fa-plus"></i> Register New Employee</a>
                  </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Office</th>
                      <th>Position</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                     @foreach($employees as $employee)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td></td>
                            <td>{{ name_helper($employee->name) ?? '' }}</td>
                            <td>{{ @office_helper($employee->division) ?? '' }}</td>
                            <td>{{ $employee->position->position ?? '' }}</td>
                            <td>
                                <a href="#" class="btn btn-xs bg-gradient-primary"><i class="fal fa-eye"></i> View</a>
                                <a href="{{ route('hrm.employee.edit', $employee->id) }}" class="btn btn-xs bg-gradient-warning"><i class="fal fa-edit"></i> Edit</a>
                            </td>
                        </tr>
                     @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>


@endsection




@section('css-vendor')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>  
@endsection

@section('js-custom')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
     
    });
</script>
@endsection