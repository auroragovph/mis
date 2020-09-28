@extends('humanresource::layouts.app')

@section('page-title')
    Salary Grade Table
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
                <h3 class="card-title mt-1">SG Table</h3>
                
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Step 1</th>
                      <th>Step 2</th>
                      <th>Step 3</th>
                      <th>Step 4</th>
                      <th>Step 5</th>
                      <th>Step 6</th>
                      <th>Step 7</th>
                      <th>Step 8</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                     @foreach($sgs as $sg)
                        <tr>
                            <td>{{ $sg->id }}</td>
                            <td>{{ number_format((integer)$sg->step1, 2) }}</td>
                            <td>{{ number_format((integer)$sg->step2, 2) }}</td>
                            <td>{{ number_format((integer)$sg->step3, 2) }}</td>
                            <td>{{ number_format((integer)$sg->step4, 2) }}</td>
                            <td>{{ number_format((integer)$sg->step5, 2) }}</td>
                            <td>{{ number_format((integer)$sg->step6, 2) }}</td>
                            <td>{{ number_format((integer)$sg->step7, 2) }}</td>
                            <td>{{ number_format((integer)$sg->step8, 2) }}</td>
                            <td></td>
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