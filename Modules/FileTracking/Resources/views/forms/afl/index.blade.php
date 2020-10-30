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




<div class="modal fade" id="modal-create">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">AFL Form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="form-create" action="{{ route('fts.afl.store') }}" method="POST">
          @csrf
          <div class="row">

            <div class="col-md-6">

              <div class="form-group">
                <label for="">Select Series #:</label> <br>
                <select name="series" class="form-control select2" required style="width: 100%">
                    <option value="" hidden disabled selected></option>
                    @foreach($qrs as $qr)
                      <option value="{{ $qr->id }}">{{ $qr->series }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">

              <div class="form-group">
                <label for="">Requesting Office:</label> <br>
                <select name="division" class="form-control select2" required style="width: 100%">
                    <option value="" hidden disabled selected></option>
                    @foreach($divisions as $division)
                      <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                    @endforeach
                </select>
              </div>

            </div>

          </div>
        

          <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                  <label for="">Name:</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                  <label for="">Position:</label>
                  <input name="position" type="text" class="form-control" required>
                </div>
  
              </div>
            
          </div>



          <div class="row">

            
            <div class="col-md-6">
              <label for="" class="mb-3">Select inclusive dates: </label>
                <div id="datepicker">
                    <input type="hidden" name="inclusive" value="" required>
                </div>
            </div>


            <div class="col-md-6">

              <div class="row">

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Leave Type:</label> <br>
                    <select name="type" class="form-control select2-type" style="width: 100%;">
                      <option>Vacation Leave</option>
                      <option>Sick Leave</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Credits:</label>
                    <input type="date" name="credits" class="form-control" required value="{{ date('Y-m-d') }}">
                  </div>
                </div>

              </div>


                
            </div>

          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Vacation:</label>
                <input type="number" name="v1" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Sick:</label>
                <input type="number" name="s1" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Vacation:</label>
                <input type="number" name="v2" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Sick:</label>
                <input type="number" name="s2" class="form-control" required>
              </div>
            </div>
          </div>

         
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Liaison Officer:</label> <br>
                <select name="liaison" class="form-control select2" required style="width: 100%">
                    <option value="" hidden disabled selected></option>
                    @foreach($liaisons as $liaison)
                      <option value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                    @endforeach
                </select>
              </div>
            </div>
          </div>
          
          <hr>

          <button class="btn bg-gradient-primary">Save</button>
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
<script>
    $(function () {

      $(".select2").select2({
        placeholder: "Select from list",
      });
      $(".select2-type").select2({
        tags: true
      });

      $('#datepicker').datepicker({
        multidate: true,
        clearBtn: true,
      });

      var dt = $("#dataTables").DataTable({
        processing: true,
        ajax: "{{ route('fts.afl.index') }}",
        columns: [
          { data: 'encoded' },
          { data: 'series' },
          { data: 'office' },

          { data: 'name' },
          { data: 'position' },
          { data: 'type' },
          { data: 'inclusives' },

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



      $("#form-create").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');


        // add whirl traditional
        $(".modal-content").addClass("whirl traditional");

        $.post(url, form.serialize(), function(data){

          dt.ajax.reload();

          $('#modal-create').modal('hide');
          form.trigger('reset');

          $(".select2").select2({
            placeholder: "Select from list"
          });

          $(".select2-type").select2({
            tags: true
          });

          $('#datepicker').datepicker({
            multidate: true,
            clearBtn: true,
          });



          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: data.message
          });



        }).fail(function(data){

          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.responseJSON.message
          });
          
        }).always(function(){

          $(".modal-content").removeClass("whirl");
          $(".modal-content").removeClass("traditional");

        });


      });
    });
</script>
@endsection