@extends('filetracking::layouts.app')

@section('page-title')
   Application for Leave (AFL)
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fts.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Application for Leave</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-1">Lists</h3>
                @can('fms.create')
                  <div class="card-tools">

                    <button type="button" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#modal-create">
                     <i class="fal fa-plus"></i>  Create New AFL
                    </button>

                  </div>
                @endcan
            </div>
            <div class="card-body">
                <table id="dataTables" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Encoded Date</th>
                      <th>Series #</th>
                      <th>Office</th>

                      <th>Name</th>
                      <th>Position</th>
                      <th>Type</th>
                      <th>Inclusive Dates</th>
                      
                      <th>Status</th>
                      <th></th>
                    </tr>
                    </thead>
                    
                  </table>
            </div>
        </div>
    </div>
</div>

@includeWhen(auth()->user()->can('fts.document.create'), 'filetracking::forms.afl.create')


@endsection




@section('css-vendor')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/whirl/whirl.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">

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

<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js")}}"></script>

<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

@endsection

@section('js-custom')
<script src="{{ asset('js/filetracking/form-afl-create.js') }}"></script>
@endsection