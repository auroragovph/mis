@extends('humanresource::layouts.app')

@section('page-title')
    Register New Employee
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('hrm.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('hrm.employee.index') }}">Employees</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
               <form id="form-create" action="{{ route('hrm.employee.store') }}" method="POST">
                   @csrf

                    <h4>Employee Personal Details</h4>
                    <hr>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">First Name</label>
                                <input name="fname" type="text" class="form-control" placeholder="Juan" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Last Name</label>
                                <input name="lname" type="text" class="form-control" placeholder="Dela Cruz" required>
                            </div>
                            <div class="col-md-3">
                                <label for="">Middle Name</label>
                                <input name="mname" type="text" class="form-control" placeholder="Santos">
                            </div>
                            <div class="col-md-1">
                                <label for="">Suffix</label>
                                <input name="sname" type="text" class="form-control" placeholder="Jr">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-2">
                                <label for="">Gender</label>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" type="radio" id="genderMale" name="gender" required>
                                      <label for="genderMale" class="custom-control-label">Male</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" type="radio" id="genderFemale" name="gender" required>
                                      <label for="genderFemale" class="custom-control-label">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Birthday</label>
                                <input type="date" name="birthday" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="">Civil Status</label>
                                <select name="civil" class="form-control select2" required>
                                    <option>Single</option>
                                    <option>Married</option>
                                    <option>Widowed</option>
                                    <option>Anulled</option>
                                    <option>Separated</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Title</label>
                                <input type="text" class="form-control" name="title" placeholder="eg. Atty">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Address</label>
                                <input type="text" class="form-control" name="address">
                            </div>
                            <div class="col-md-6">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-5">Job Details</h4>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Office / Division</label>
                                <select name="division" class="form-control select2" style="width:100%" required>
                                    <option hidden></option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Position</label>
                                <select name="position" class="form-control select2-ajax-position" style="width:100%" required>
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
                                    <option value="1">Job Order</option>
                                    <option value="2">Casual</option>
                                    <option value="3">Permanent</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Employment Status</label>
                                <select name="employment-status" class="form-control select2" style="width:100%">
                                    <option hidden></option>
                                    <option value="0">Inactive</option>
                                    <option selected value="1">Active</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">ID No:</label>
                                <input name="card" type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group clearfix mt-3">
                              <div class="icheck-primary d-inline">
                                <input name="liaison" type="checkbox" id="liaison-officer">
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



    $("#form-create").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');


        // add whirl traditional
        $(".card").addClass("whirl traditional");

        $.post(url, form.serialize(), function(data){

            form.trigger('reset');

            $(".select2").select2({
                placeholder: "Select from list"
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

            $(".card").removeClass("whirl");
            $(".card").removeClass("traditional");

        });


    });

});
</script>
@endsection