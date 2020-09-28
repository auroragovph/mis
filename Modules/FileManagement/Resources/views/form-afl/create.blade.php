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
            <form action="{{route('fms.afl.store')}}" method="POST">
                @method('PUT')
                @csrf 

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
                                <div class="form-group">

                                    <input type="radio" id="vacation-tse" name="vacation1" value="vac-tse" v-model="vacation.type">
                                    <label for="vacation-tse">To seek employement</label>
                                    <br>
                                    <input type="radio" id="vacation-os" name="vacation1" value="vac-oth" v-model="vacation.type">
                                    <label for="vacation-os">Others (Specify)</label>
                                </div>

                                <div class="form-group" v-if="vacation.type == 'vac-oth' ">
                                    <input type="text" class="form-control" name="vac-oth">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">In case of Vacation Leave</label>
                                    <br>
                                    <input type="radio" id="vacation-witp" name="vacation2" value="vac-ph" v-model="vacation.details">
                                    <label for="vacation-witp">Within in the Philippines</label>
                                    <br>
                                    <input type="radio" id="vacation-as" name="vacation2" value="vac-abr" v-model="vacation.details">
                                    <label for="vacation-as">Abroad (Specify)</label>
                                </div>

                                <div class="form-group" v-if="vacation.details == 'vac-abr' ">
                                    <input type="text" class="form-control" name="vac-abr">
                                </div>
                            </div>
                        </div>
                    @break

                    @case('Sick')
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">In case of sick leave</label>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="sick-inh" id="sick-inh" v-model="sick.inh">
                                    <label class="form-check-label" for="sick-inh">In hospital</label>
                                </div>

                                <div class="form-group mt-2" v-if="sick.inh">
                                    <label for="">Specify:</label>
                                    <input type="text" class="form-control" name="sick-spec">
                                </div>
                            </div>
                        </div>
                    @break

                    @case('Maternity')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Specify your leave</label>
                                    <input type="text" class="form-control" value="Maternity" readonly>
                                </div>
                            </div>
                        </div>
                    @break

                    @default 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Specify your leave</label>
                                <input type="text" class="form-control" name="leave-other">
                            </div>
                        </div>
                    </div>
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
                            <input type="radio" id="com-req" name="commutation" value="1">
                            <label for="com-req">Requested</label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" id="com-nreq" name="commutation" value="0">
                                <label for="com-nreq">Not Requested</label>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mt-3">Leave Credits</h5>
                <hr>
                <div class="row">
                    <div class="col-md-12">


                        <label>Credits as of :</label>
                        <input type="date" class="form-control" name="caf">



                        
                        <table class="table table-bordered table-sm mt-3">
                            <thead>
                                <tr>
                                    <td>Vacation</td>
                                    <td>Sick</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="number" min="0" name="v1" class="form-control" v-model.null="v1"></td>
                                    <td><input type="number" min="0" name="s1" class="form-control" v-model.null="s1"></td>
                                    <td>@{{ v1 + s1 }}</td>
                                </tr>
                                <tr>
                                    <td><input type="number" min="0" name="v2" class="form-control" v-model.null="v2"></td>
                                    <td><input type="number" min="0" name="s2" class="form-control" v-model.null="s2"></td>
                                    <td>@{{ v2 + s2 }}</td>
                                </tr>
                                <tr>
                                    <td>@{{ v1 - v2 }}</td>
                                    <td>@{{ s1 - s2 }}</td>
                                    <td>@{{ (v1 + s1) - (v2 + s2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <h5 class="mt-3">Days Approved</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Days with pay</label>
                        <input type="number" name="days-with-pay" class="form-control" value="0">
                    </div>
                    <div class="col-md-6">
                        <label for="">Days without pay</label>
                        <input type="number" name="days-without-pay" class="form-control" value="0">
                    </div>
                </div>


                <h5 class="mt-3">Signatories</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Approval</label>
                        <select name="approval" class="form-control select2">
                            <option value=""></option>
                            <?php $approvals = $employees->where('division_id', Auth::user()->employee->division_id); ?>
                            @foreach($approvals as $approval)
                                <option value="{{ $approval->id }}">{{ name_helper($approval->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">HR Officer</label>
                        <select name="hr" class="form-control select2">
                            <?php $hrs = $employees->where('division_id', config('constants.office.HRMO')) ?>
                            <option value=""></option>
                            @foreach($hrs as $hr)
                                <option value="{{ $hr->id }}">{{ name_helper($hr->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h5 class="mt-3">Liaison Officer</h5>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                       <select name="liaison" id="" class="form-control select2">
                            <option value=""></option>
                            <?php $liaisons = $employees->where('division_id', Auth::user()->employee->division_id)->where('liaison', true); ?>
                            @foreach($liaisons as $liaison)
                                <option value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                            @endforeach
                       </select>
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
<script src="{{ asset('plugins/vue/vue.js') }}"></script>

<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js-custom')
<script src="{{ asset('js/filemanagement/form-afl-create.js') }}"></script>
@endsection