@extends('humanresource::layouts.app')

@section('page-title')
    Register New Employee
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
            <div class="card-body">
               <form action="#">

                    <h4>Employee Personal Details</h4>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">First Name</label>
                                <input type="text" class="form-control" placeholder="Juan">
                            </div>
                            <div class="col-md-4">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control" placeholder="Dela Cruz">
                            </div>
                            <div class="col-md-3">
                                <label for="">Middle Name</label>
                                <input type="text" class="form-control" placeholder="Santos">
                            </div>
                            <div class="col-md-1">
                                <label for="">Suffix</label>
                                <input type="text" class="form-control" placeholder="Jr">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Gender</label>
                                <input type="text" class="form-control" placeholder="Juan">
                            </div>
                            <div class="col-md-4">
                                <label for="">Birthday</label>
                                <input type="text" class="form-control" placeholder="Dela Cruz">
                            </div>
                            <div class="col-md-4">
                                <label for="">Civil Status</label>
                                <input type="text" class="form-control" placeholder="Santos">
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Address</label>
                                <input type="text" class="form-control" placeholder="Juan">
                            </div>
                            <div class="col-md-6">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Dela Cruz">
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-5">Job Details</h4>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Office / Division</label>
                                <select name="division" class="form-control select2" style="width:100%">
                                    <option hidden></option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Position</label>
                                <select name="position" class="form-control select2" style="width:100%">
                                    <option hidden></option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Employment Type</label>
                                <select name="employment-type" class="form-control select2" style="width:100%">
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
                                    <option value="1">Active</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">ID No:</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group clearfix mt-3">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="liaison-officer">
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
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js-custom')
<script>
    $(function () {
  //Initialize Select2 Elements
  $(".select2").select2({
    placeholder: "Select from list"
  });
});
</script>
@endsection