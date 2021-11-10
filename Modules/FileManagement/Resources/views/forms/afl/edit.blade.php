@extends('layouts.master')


@section('page-title')
Application For Leave Form
@endsection

@section('toolbar')

@endsection

@section('content')
<x-ui.card title="AFL Update Form">
    <form action="{{ route('fms.afl.update', $afl->id) }}" method="POST">
        @method('PATCH')
        @csrf

        <h5>Employee Details</h5>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Employee" disabled value="{{ name_helper($afl->employee->name) }}" name="" />
            </div>
            <div class="col-md-6">
                <x-ui.form.input label="Position & Salary" disabled value="" name="" />
            </div>
        </div>

        <h5 class="mt-3">Leave Details ({{ strtoupper($afl->properties['type']) }})</h5>
        <hr>

        @switch($afl->properties['type'])
            @case('Vacation')
                <div class="row" x-data="{

                    @if($afl->properties['details']['reason'] == 'tse')
                        vac1: 'vac-tse', 
                    @else
                        vac1: 'vac-oth', 
                    @endif

                    @if($afl->properties['details']['place'] == 'ph')
                        vac2: 'vac-ph'
                    @else
                        vac2: 'vac-abr', 
                    @endif

                }">

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
                                <input type="text" class="form-control" name="vac-oth" 
                                    @if($afl->properties['details']['reason'] != 'tse') 
                                        value="{{ $afl->properties['details']['reason'] }}" 
                                    @endif />
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
                                <input type="text" class="form-control" name="vac-abr" 
                                    @if($afl->properties['details']['place'] != 'ph') 
                                        value="{{ $afl->properties['details']['place'] }}" 
                                    @endif />
                            </div>
                        </template>

                        
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

        <h5>Inclusive dates</h5>
        <hr>

        <div class="row">

            <div class="col-md-6">
                <label for="" class="mb-3">Select dates: </label>
                <div id="afl_datepicker">
                    @php
                        $raw_dates = collect($afl->inclusives);
                        $dates = $raw_dates->map(function($item){
                            return Carbon\Carbon::parse($item)->format('m/d/Y');
                        })->implode(',');
                    @endphp
                    <input type="hidden" name="inclusive" value="{{ $dates }}" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label for="">Commutation</label>

                    <div class="icheck-primary">
                    <input type="radio" id="com-req" name="commutation" value="1" @if($afl->properties['commutation']) checked @endif>
                    <label for="com-req">Requested</label>
                    </div>
                    <div class="icheck-primary">
                        <input type="radio" id="com-nreq" name="commutation" value="0" @if(!$afl->properties['commutation']) checked @endif>
                        <label for="com-nreq">Not Requested</label>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="mt-3">Leave Credits</h5>
        <hr>

        <div class="row">

            <div class="col-md-6">
                <x-ui.form.input label="Credits as of :" type="date" name="caf" value="{{ $afl->credits['as-of'] }}" />
            </div>

            <div class="col-md-6">
                <table class="table table-bordered table-sm mt-3" x-data="{
                    credits: {
                        v1: {{ $afl->credits['vacation'][0] }},
                        v2: {{ $afl->credits['vacation'][1] }},
                        s1: {{ $afl->credits['sick'][0] }},
                        s2: {{ $afl->credits['sick'][1] }}
                    }
                }">
                    <thead>
                        <tr>
                            <td>Vacation</td>
                            <td>Sick</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input value="{{ $afl->credits['vacation'][0] }}" type="number" min="0" name="v1" class="form-control" x-model.number="credits.v1"></td>
                            <td><input value="{{ $afl->credits['sick'][0] }}" type="number" min="0" name="s1" class="form-control" x-model.number="credits.s1"></td>
                            <td x-text="credits.v1 + credits.s1"></td>
                        </tr>
                        <tr>
                            <td><input value="{{ $afl->credits['vacation'][1] }}" type="number" value="0" min="0" name="v2" class="form-control" x-model.number="credits.v2"></td>
                            <td><input value="{{ $afl->credits['sick'][1] }}" type="number" value="0" min="0" name="s2" class="form-control" x-model.number="credits.s2"></td>
                            <td x-text="credits.v2 + credits.s2"></td>
                        </tr>
                        <tr>
                            <td x-text="credits.v1 - credits.v2"></td>
                            <td x-text="credits.s1 - credits.s2"></td>
                            <td x-text="(credits.v1 + credits.s1) - (credits.v2 + credits.s2)"></td>
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
                        <option {{ sh($approval->id, $afl->approval_id) }}  value="{{ $approval->id }}">{{ name_helper($approval->name) }}</option>
                    @endforeach
                </x-ui.form.select2>
            </div>

            <div class="col-md-6">
                <x-ui.form.select2 label="HR Officer" name="hr" required>
                    <?php $hrs = $employees->where('division_id', config('constants.office.HRMO')) ?>
                    @foreach($hrs as $hr)
                        <option {{ sh($hr->id, $afl->hr_id) }} value="{{ $hr->id }}">{{ name_helper($hr->name) }}</option>
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
                        <option {{ sh($liaison->id, $afl->document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
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

