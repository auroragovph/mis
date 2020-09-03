@extends('filemanagement::layouts.app')

@section('page-title')
   Procurement
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Procurement</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-1">Lists</h3>
                <div class="card-tools">
                   <a href="{{ route('fms.obr.create') }}" class="btn btn-sm bg-gradient-primary"><i class="fas fa-plus"></i> Create New Obligation Request</a>
                  </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Encoded Date</th>
                      <th>Document ID</th>
                      <th>Number</th>
                      <th>Payee</th>
                      <th>Address</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                     
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