@extends('layouts.master')


@section('page-title')
Application For Leave Form
@endsection

@section('toolbar')

@endsection

@section('content')
<x-ui.card>
    <form action="{{ route('fms.afl.store') }}" method="POST" x-data="{leaveType: 'Vacation'}">
        @csrf

        <h5>Employee Details</h5>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.select2 name="employee" required label="Employee">
                    <?php $approvals = $employees->where('division_id', auth_division()); ?>
                    @foreach($approvals as $approval)
                        <option value="{{ $approval->id }}">{{ name_helper($approval->name) }}</option>
                    @endforeach
                </x-ui.form.select2>
            </div>

            <div class="col-md-6">
                <x-ui.form.select name="leave_type" x-model="leaveType" label="Leave Type">
                    <option>Vacation</option>
                    <option>Sick</option>
                    <option>Maternity</option>
                    <option>Others</option>
                </x-ui.form.select>
            </div>
        </div>

        <h5 class="mt-3">Leave Details (<span x-text="leaveType"></span>)</h5>
        <hr>

        <template x-if="leaveType == 'Vacation'">
            <div class="row" x-data="{vac1: 'vac-tse', vac2: 'vac-ph'}">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="radio" id="vacation-tse" name="vacation1" value="vac-tse" x-model="vac1">
                        <label for="vacation-tse">To seek employement</label>
                        <br>
                        <input type="radio" id="vacation-os" name="vacation1" value="vac-oth" x-model="vac1">
                        <label for="vacation-os">Others (Specify)</label>
                    </div>

                    <template x-if="vac1 == 'vac-oth' ">
                        <div class="form-group">
                            <input type="text" class="form-control" name="vac-oth">
                        </div>
                    </template>

                   
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">In case of Vacation Leave</label>
                        <br>
                        <input type="radio" id="vacation-witp" name="vacation2" value="vac-ph" x-model="vac2">
                        <label for="vacation-witp">Within in the Philippines</label>
                        <br>
                        <input type="radio" id="vacation-as" name="vacation2" value="vac-abr" x-model="vac2">
                        <label for="vacation-as">Abroad (Specify)</label>
                    </div>

                    <template x-if="vac2 == 'vac-abr' ">
                        <div class="form-group">
                            <input type="text" class="form-control" name="vac-abr">
                        </div>
                    </template>

                    
                </div>
            </div>
        </template>

        <template x-if="leaveType == 'Sick'">
            <div class="row" x-data="{sick: false}">
                <div class="col-md-12">
                    <label for="">In case of sick leave</label>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="sick-inh" id="sick-inh" x-model="sick">
                        <label class="form-check-label" for="sick-inh">In hospital</label>
                    </div>

                    <template x-if="sick == true">
                        <div class="form-group mt-2" v-if="sick.inh">
                            <label for="">Specify:</label>
                            <input type="text" class="form-control" name="sick-spec">
                        </div>
                    </template>

                </div>
            </div>
        </template>

        <template x-if="leaveType == 'Maternity'">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Specify your leave</label>
                        <input type="text" class="form-control" value="Maternity" disabled>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="leaveType == 'Others'">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Specify your leave</label>
                        <input type="text" class="form-control" name="leave-other">
                    </div>
                </div>
            </div>
        </template>


        <h5>Inclusive dates</h5>
        <hr>

        <div class="row">

            <div class="col-md-6">
                <label for="" class="mb-3">Select dates: </label>
                <div id="afl_datepicker">
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

            <div class="col-md-6">
                <x-ui.form.input label="Credits as of :" type="date" name="caf" />
            </div>

            <div class="col-md-6">
                <table class="table table-bordered table-sm mt-3" x-data="leave_credits()">
                    <thead>
                        <tr>
                            <td>Vacation</td>
                            <td>Sick</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="number" min="0" name="v1" class="form-control" x-model.number="v1"></td>
                            <td><input type="number" min="0" name="s1" class="form-control" x-model.number="s1"></td>
                            <td x-text="v1 + s1"></td>
                        </tr>
                        <tr>
                            <td><input type="number" value="0" min="0" name="v2" class="form-control" x-model.number="v2"></td>
                            <td><input type="number" value="0" min="0" name="s2" class="form-control" x-model.number="s2"></td>
                            <td x-text="v2 + s2"></td>
                        </tr>
                        <tr>
                            <td x-text="v1 - v2"></td>
                            <td x-text="s1 - s2"></td>
                            <td x-text="(v1 + s1) - (v2 + s2)"></td>
                        </tr>
                    </tbody>
                </table>
            </div>



        </div>

        <h5>Signatories</h5>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.select2 label="Approval" name="approval" required>
                    <?php $approvals = $employees->where('division_id', auth_division()); ?>
                    @foreach($approvals as $approval)
                        <option value="{{ $approval->id }}">{{ name_helper($approval->name) }}</option>
                    @endforeach
                </x-ui.form.select2>
            </div>

            <div class="col-md-6">
                <x-ui.form.select2 label="HR Officer" name="hr" required>
                    <?php $hrs = $employees->where('division_id', config('constants.office.HRMO')) ?>
                    @foreach($hrs as $hr)
                        <option value="{{ $hr->id }}">{{ name_helper($hr->name) }}</option>
                    @endforeach
                </x-ui.form.select2>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <x-ui.form.select2 label="Liaison Officer" name="liaison" required>
                    <?php $liaisons = $employees->where('division_id', auth_division())->where('liaison', true); ?>
                    @foreach($liaisons as $liaison)
                        <option value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                    @endforeach
                </x-ui.form.select2>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3" name="submitButton">Submit</button>

    </form>
</x-ui.card>
@endsection


@section('css-vendor')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('css-custom')
@endsection

@section('js-vendor')
<!-- AlpineJS -->
<script src="{{ asset('adminlte/plugins/alpine/alpine.min.js') }}"></script>

<!-- DatePicker -->
<script src="{{ asset('adminlte/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js-custom')
<script>
    function leave_credits() {
    return {
        v1: 0,
        v2: 0,
        s1: 0,
        s2: 0
    }
}
</script>

<script src="{{ asset('js/Modules/FileManagement/pages/forms/afl/create.js') }}"></script>
@endsection


