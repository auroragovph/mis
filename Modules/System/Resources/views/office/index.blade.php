@extends('system::layouts.app')

@section('page-title')
Office
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('sys.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Office</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-1">Lists</h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#modal-default"><i class="fas fa-plus"></i> Create New Office</a>
                   </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Alias</th>
                      <th>Employees</th>
                      <th>Divisions</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($offices as $office)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $office->name }}</td>
                            <td>{{ $office->alias }}</td>
                            <td></td>
                            <td>{{ $office->divisions->count() - 1 }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
   
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create New Office</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <form action="{{ route('sys.office.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="">Alias</label>
                    <input type="text" name="alias" class="form-control" required>
                </div>

                <hr>

                <button type="submit" class="btn bg-gradient-primary">Submit</button>
            </form>
         
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

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