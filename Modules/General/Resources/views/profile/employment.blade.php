<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b tab-pane fade" id="employmentTab" role="tabpanel" aria-labelledby="employmentTab-tab">
    <!--begin::Header-->
    <div class="card-header py-3">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Employment Details</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">Update your employment details</span>
        </h3>
       
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form_employment" method="POST" action="{{ route('hrm.employee.update', authenticated()->employee->id) }}">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Office / Division</label>
                        <input type="text" class="form-control" value="{{ office_helper(authenticated()->employee->division) ?? '' }}" disabled>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" class="form-control" disabled value="{{ authenticated()->employee->position->position ?? '' }}">
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Status of Appointment</label>
                        <input type="text" class="form-control" value="{{ authenticated()->employee->employment['type'] }}" disabled>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>ID Card</label>
                        <input type="text" class="form-control" value="{{ authenticated()->employee->card }}" placeholder="Eg. PGA-P-12345" disabled/>
                    </div>
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

            <button type="submit" class="btn btn-success mt-5" name="submitButton">Save Changes</button> --}}

        </form>
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->