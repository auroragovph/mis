@extends('humanresource::layouts.app')

@section('page-title')
    Edit Employee
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('hrm.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
<div class="row">
    
    <div class="col-12 col-sm-12">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="employeeTab" role="tablist">
              
            <li class="nav-item">
                <a class="nav-link active" id="employeeTabProfileController" data-toggle="pill" href="#employeeTabProfileContent" role="tab" aria-controls="employeeTabProfileContent" aria-selected="false">
                  Information Details
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="employeeTabJobController" data-toggle="pill" href="#employeeTabJobContent" role="tab" aria-controls="employeeTabJobContent" aria-selected="false">
                  Employment Details
                </a>
            </li>
            
          </ul>
        </div>
        <div class="card-body">
            
            <div class="tab-content" id="employeeTabContent">

                <div class="tab-pane fade active show" id="employeeTabProfileContent" role="tabpanel" aria-labelledby="employeeTabProfileController">
                    <form class="form-edit" action="{{ route('hrm.employee.update', $employee->id) }}" method="POST">
                        @csrf
                        <h4>Employee Personal Details</h4>
                        <input type="hidden" name="_type" value="profile">
                        <hr>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input name="fname" type="text" class="form-control" placeholder="eg. Juan" value="{{ $employee->name['fname'] ?? '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Midddle Name</label>
                                    <input name="mname" type="text" class="form-control" placeholder="eg. Santos" value="{{ $employee->name['mname'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input name="lname" type="text" class="form-control" placeholder="eg. Dela Cruz" value="{{ $employee->name['lname'] ?? '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Suffix</label>
                                    <input name="sname" type="text" class="form-control" placeholder="eg. Jr" value="{{ $employee->name['sname'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input name="title" type="text" class="form-control" placeholder="eg. Atty." value="{{ $employee->name['title'] ?? '' }}">
                                </div>

                            </div>

                            <div class="col-md-6 border-left">

                                <div class="form-group">
                                    <label for="">Birthday</label>
                                    <input type="date" name="birthday" class="form-control" value="{{ $employee->info['birthday'] ?? date('Y-m-d') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Civil Status</label>
                                    <select name="civil" class="form-control select2" required>
                                        @foreach(config('static-lists.civilStatus') as $civil)
                                            <option {{ sh($civil, $employee->info['civilStatus'] ?? '') }} >{{ $civil }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="genderMale" name="gender" value="0" required @if($employee->info['gender'] == '0') checked @endif>
                                            <label for="genderMale" class="custom-control-label">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="genderFemale" name="gender" value="1" required @if($employee->info['gender'] == '1') checked @endif>
                                            <label for="genderFemale" class="custom-control-label">Female</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ $employee->info['address'] ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $employee->info['phoneNumber'] ?? '' }}">
                                </div>
                                
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
                    </form>

                </div>

                <div class="tab-pane fade" id="employeeTabJobContent" role="tabpanel" aria-labelledby="employeeTabJobController">
                    <form class="form-edit" action="{{ route('hrm.employee.update', $employee->id) }}" method="POST">
                        @csrf
                        <h4>Job Details</h4>
                        <input type="hidden" name="_type" value="employment">
                        <hr>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Office / Division</label>
                                    <select name="division" class="form-control select2" style="width:100%" required>
                                        <option hidden></option>
                                        @foreach($divisions as $division)
                                            <option {{ sh($division->id, $employee->division_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Position</label>
                                    <select name="position" class="form-control select2-ajax-position" style="width:100%" required>
                                        <option value="{{ $employee->position_id }}" selected>{{ $employee->position->position ?? '' }}</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Status of Appointment</label>
                                    <select name="employment-type" class="form-control select2" style="width:100%" required>
                                        <option hidden></option>
                                        @foreach(config('static-lists.statusOfAppointment') as $key => $soas)
                                            <option {{ sh($key, $employee->employment['type'] ?? 0) }} value="{{ $key }}">{{ $soas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Employment Status</label>
                                    <select name="employment-status" class="form-control select2" style="width:100%">
                                        <option hidden></option>
                                        <option value="0" {{ sh(0, $employee->employment['status']) }}>Inactive</option>
                                        <option value="1" {{ sh(1, $employee->employment['status']) }}>Active</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">ID No:</label>
                                    <input name="card" type="password" value="{{ $employee->card }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group clearfix mt-3">
                                    <div class="icheck-primary d-inline">
                                    <input name="liaison" type="checkbox" id="liaison-officer" @if($employee->liaison == 1) checked @endif>
                                    <label for="liaison-officer">
                                        Liaison Officer
                                    </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <button class="btn bg-gradient-primary"> Submit</button>
                    </form>
                </div>

            </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

  </div>
@endsection



@section('css-vendor')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/whirl/whirl.css') }}">

@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js")}}"></script>

@endsection

@section('js-custom')
<script>
$(function () {

    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });

    $(".select2-ajax-position").select2({
        ajax: {
            url: '{{ route("hrm.plantilla.position.lists") }}',
            dataType: 'json',
            delay: 500,
            processResults: function(data, page) {
                return { results: data };
            },
            cache: true
        }
    });

    $(".form-edit").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');


        // add whirl traditional
        $(".card").addClass("whirl traditional");

        $.post(url, form.serialize(), function(data){

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

            $(".card").removeClass("whirl");
            $(".card").removeClass("traditional");

        });


    });


});
</script>
@endsection