@extends('filemanagement::layouts.app', ['module_side_bar' => 'filemanagement::layouts.sidebar'])

@section('page-title')
    Create AFL
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.afl.index') }}">Application For Leave</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<div class="row" id="app-root">
    <div class="col-md-12">
        <div class="card card-default px-5 py-3">
            <form action="#">

                <h5>Employee Details</h5>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" readonly class="form-control" value="{{ $employee->name['fname'] }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" readonly class="form-control" value="{{ $employee->name['lname'] }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" readonly class="form-control" value="{{ $employee->name['mname'] }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Position</label>
                            <input type="text" class="form-control" value="{{ $employee->position->position }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Salary</label>
                            <input type="text" class="form-control" value="{{ number_format($employee->position->salary_grade->step1, 2) }}" readonly>
                        </div>
                    </div>
                </div>


                <h5 class="mt-3">Leave Details  ({{ strtoupper($type) }})</h5>
                <hr>

                @switch($type)

                    @case('Vacation')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary">
                                    <input type="radio" id="vacation-tse" name="vacation1">
                                    <label for="vacation-tse">To seek employement</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="vacation-os" name="vacation1">
                                        <label for="vacation-os">Others (Specify)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group clearfix">
                                    <label for="">In case of Vacation Leave</label>
                                    <div class="icheck-primary">
                                    <input type="radio" id="vacation-witp" name="vacation2">
                                    <label for="vacation-witp">Within in the Philippines</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="vacation-as" name="vacation2">
                                        <label for="vacation-as">Abroad (Specify)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @break

                    @default 
                    @break 
                @endswitch


                <h5 class="mt-3">Inclusive dates</h5>
                <hr>
                <div class="row">

                    <div class="col-md-6">
                        <label for="" class="mb-3">Select dates: </label>
                        <div id="datepicker">
                            <input type="hidden" name="inclusive" value="" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group clearfix">
                            <label for="">Commutation</label>

                            <div class="icheck-primary">
                            <input type="radio" id="com-req" name="commutation">
                            <label for="com-req">Requested</label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" id="com-nreq" name="commutation">
                                <label for="com-nreq">Not Requested</label>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mt-3">Leave Credits</h5>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <label>Credits as of {{ date('Y-m-d') }}</label>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <td>Vacation</td>
                                    <td>Sick</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $employee->employement['leave']['vacation'] }}</td>
                                    <td>{{ $employee->employement['leave']['sick'] }}</td>
                                    <td>
                                        {{ $employee->employement['leave']['vacation'] + $employee->employement['leave']['sick'] }}</td>
                                </tr>
                                <tr>
                                    <td><input type="number" class="form-control"></td>
                                    <td><input type="number" class="form-control"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>

                <button class="btn bg-gradient-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
@endsection


@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/vue/vue.js') }}"></script>
@endsection

@section('js-custom')
<script src="{{ asset('js/filemanagement/form-afl-create.js') }}"></script>
@endsection