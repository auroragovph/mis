<x-ui.card title="Employment Information" class="tab-pane fade" id="employmentTab" role="tabpanel" aria-labelledby="employmentTab-tab">
    <form class="form" id="kt_form_employment" method="POST" action="{{ route('hrm.employee.update', authenticated()->employee->id) }}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input
                    name="division" 
                    label="Office / Division" 
                    value="{{ office_helper(authenticated()->employee->division) ?? '' }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input
                    name="position" 
                    label="Position" 
                    value="{{ authenticated()->employee->position->position ?? ''  }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input
                    name="appointment" 
                    label="Status of Appointment" 
                    value="{{ authenticated()->employee->employment['type']   }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input
                    name="appointment" 
                    label="ID Card" 
                    value="{{ authenticated()->employee->card }}" 
                    disabled  
                />
            </div>
            <!--end::Group-->
        </div>

        <!--begin::Group-->
        <div class="form-group">
            <div class="checkbox-inline">
                <label class="checkbox">
                <input name="liaison" type="checkbox" value="true" @if(authenticated()->employee->liaison == true) checked @endif disabled /> Liaison Officer
                <span></span></label>
            </div>
        </div>
        <!--end::Group-->

        {{-- <div class="separator separator-dashed"></div>
        <button type="submit" class="mt-5 btn btn-success" name="submitButton">Save Changes</button> --}}

    </form>
</x-ui.card>