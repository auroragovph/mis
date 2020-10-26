@extends('filetracking::layouts.app')

@section('page-title')
    QR Codes
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">QR Codes</li>
</ol>
@endsection

@section('content')
<div class="row">


    <div class="col-md-9">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-1">Available QR Codes</h3>
            </div>
            <div class="card-body">
                <table id="dataTables" class="table table-sm table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Series #</th>
                    </tr>
                    </thead>
                    
                  </table>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Generate QR Code</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('fts.qr.generate') }}" method="POST">

                            @csrf
                            <div class="form-group">
                                <label for="">QR Counts</label>
                                <input class="form-control" type="number" name="counts" max="1500" min="1" required>
                            </div>

                            <button class="btn bg-gradient-primary btn-block">Generate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
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
    $(".select2").select2({
        placeholder: "Select from list"
    });

    $("#dataTables").DataTable({
        processing: true,
        ajax: "{{ route('fts.qr.index') }}",
        columns: [
          { data: 'id' },
          { data: 'series' },
        ],
        "responsive": true,
        "autoWidth": false,
      });


});

</script>
@endsection