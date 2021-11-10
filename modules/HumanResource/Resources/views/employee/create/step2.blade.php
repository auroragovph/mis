<!--begin::Wizard Step 2-->
<div class="my-5 step" data-wizard-type="step-content">
    <h5 class="text-dark font-weight-bold mb-10 mt-5">Employment Details</h5>
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-form-label col-xl-3 col-lg-3">Office / Division</label>
        <div class="col-xl-9 col-lg-9">


            <select x-ref="selectDivision" id="kt_select2_1" class="form-control form-control-lg form-control-solid" name="division" style="width:100%;">
                <option value=""></option>
                @foreach($divisions as $division)
                    <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-form-label col-xl-3 col-lg-3">Position</label>
        <div class="col-xl-9 col-lg-9">
            <select id="kt_select2_2" class="form-control form-control-lg form-control-solid" name="position" data-api="{{ route('hrm.plantilla.position.lists') }}"  style="width:100%;" @change="formData.position = $event.target.innerText"></select>
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-form-label col-xl-3 col-lg-3">Status of Appointment</label>
        <div class="col-xl-9 col-lg-9">
            <select class="form-control form-control-lg form-control-solid" name="appointment" @change="formData.appointment = $event.target.value">
                <option value="">---SELECT---</option>
                <option>Job Order</option>
                <option>Casual</option>
                <option>Permanent</option>
            </select>
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-form-label col-xl-3 col-lg-3">ID Card</label>
        <div class="col-xl-9 col-lg-9">
            <input class="form-control form-control-solid form-control-lg" name="card" type="text" value="" x-model="formData.card" />
           
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-form-label col-xl-3 col-lg-3"></label>
        <div class="col-xl-9 col-lg-9">
            <div class="checkbox-inline">
                <label class="checkbox">
                <input name="liaison" type="checkbox" value="true" x-model="formData.liaison" /> Liaison Officer
                <span></span></label>
               
            </div>
        </div>
    </div>
    <!--end::Group-->
    
</div>
<!--end::Wizard Step 2-->