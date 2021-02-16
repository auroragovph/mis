<!--begin::Wizard Step 2-->
<div class="my-5 step" data-wizard-type="step-content">
    <h5 class="text-dark font-weight-bold mb-10 mt-5">Employment Details</h5>

    <div class="row">
        <div class="col-md-6">
            <!--begin::Group-->
            <div class="form-group">
                <label>Office / Division</label>
                <select id="kt_select2_division" class="form-control" name="division" data-api="{{ route('sys.office.division.index') }}" style="width: 100%;" required>
                </select>
            </div>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <div class="form-group">
                <label>Position</label>
                <select id="kt_select2_position" class="form-control" name="position" data-api="{{ route('hrm.plantilla.position.index') }}" style="width: 100%;" required>
                    <option value="{{ auth()->user()->employee->position_id }}" selected>{{ auth()->user()->employee->position->position ?? '' }}</option>
                </select>
            </div>
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-6">
            <!--begin::Group-->
            <div class="form-group">
                <label>Status of Appointment</label>
                <select x-model="formData.appointment" name="appointment" class="form-control selectpicker" required>
                    <option value="">---SELECT---</option>
                    @foreach(config('static-lists.statusOfAppointment') as $soas)
                        <option {{ sh($soas, auth()->user()->employee->employment['type']) }}>{{ $soas }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <div class="form-group">
                <label>ID Card</label>
                <input x-model="formData.card" type="text" class="form-control" name="card" value="{{ auth()->user()->employee->card }}" placeholder="Eg. PGA-P-12345" required/>
            </div>
        </div>
        <!--end::Group-->
    </div>

    <!--begin::Group-->
    <div class="form-group">
        <div class="checkbox-inline">
            <label class="checkbox">
            <input x-model="formData.liaison" name="liaison" type="checkbox" value="true" @if(auth()->user()->employee->liaison == true) checked @endif /> Liaison Officer
            <span></span></label>
        </div>
    </div>
    <!--end::Group-->
    
    
</div>
<!--end::Wizard Step 2-->