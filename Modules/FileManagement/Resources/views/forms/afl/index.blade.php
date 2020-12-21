@extends('filemanagement::layouts.app', ['module_side_bar' => 'filemanagement::layouts.sidebar'])

@section('page-title')
    Application for Leave
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Application For Leave</li>
</ol>
@endsection


@section('content')

<div class="row">
  <div class="col-12">
    @can('fms.create')
        <div class="card-tools">
          <button type="button" class="btn bg-gradient-primary" data-toggle="modal" data-target="#modal-default">
            <i class="fal fa-plus"></i> Create new AFL
          </button>
        </div>
    @endcan
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-default mt-3">
            <div class="card-header">
                <h3 class="card-title mt-1">Lists</h3>
            </div>
            <div class="card-body">
                <table id="dataTables" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Encoded Date</th>
                      <th>Document ID</th>
                      <th>Applicant</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                  </table>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">AFL Form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('fms.afl.create') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Employee</label> <br>
            <select name="employee" class="form-control select2 d-block" style="width: 100%" required>
              <option value=""></option>
              @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="">Type</label> <br>
            <select name="type" class="form-control select2 d-block" style="width: 100%" required>
              <option value=""></option>
              <option>Vacation</option>
              <option>Sick</option>
              <option>Maternity</option>
              <option>Others</option>
            </select>
          </div>

          <hr>

          <button class="btn bg-gradient-primary"> Submit</button>

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

<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>  

<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

@endsection

@section('js-custom')
<script>
    $(function () {

      //Initialize Select2 Elements
      $(".select2").select2({
          placeholder: "Select from list"
      });
      
      $("#dataTables").DataTable({
        processing: true,
        ajax: "{{ route('fms.afl.index') }}",
        columns: [
          { data: 'encoded' },
          { data: 'qr' },
          { data: 'applicant' },
          { data: 'type' },
          { data: 'status' },
          { 
            data: 'action',
            searchable: false,
            orderable: false
          },
        ],
        "responsive": true,
        "autoWidth": false,
      });
     
    });
</script>
@endsection