
<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b tab-pane fade show active" id="informationTab" role="tabpanel" aria-labelledby="informationTab-tab">
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form_information" method="POST" action="{{ route('hrm.employee.update', authenticated()->employee->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>First Name</label>
                        <input disabled type="text" class="form-control" value="{{ authenticated()->employee->name['fname'] }}" placeholder="Enter your name" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" disabled class="form-control" value="{{ authenticated()->employee->name['lname'] }}" placeholder="Enter your lastname" required/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" disabled value="{{ authenticated()->employee->name['mname'] }}" placeholder="Enter your middle name"/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Suffix</label>
                        <input type="text" class="form-control" disabled value="{{ authenticated()->employee->name['sname'] }}" placeholder="Eg. Jr"/>
                    </div>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" disabled value="{{ authenticated()->employee->name['title'] }}" placeholder="Eg. Atty"/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-4">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Birthdate</label>
                        <input type="text" class="form-control kt_datepicker" value="{{ authenticated()->employee->info['birthday'] }}" disabled required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ authenticated()->employee->info['address'] }}" placeholder="Enter your address"/ required>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-4">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Civil Status</label>
                        <select class="form-control selectpicker" name="civil" required>
                            <option value="">---SELECT---</option>
                            @foreach(config('static-lists.civilStatus') as $cs)
                                <option {{ sh($cs, authenticated()->employee->info['civilStatus']) }}>{{ $cs }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sex</label>
                        <input type="text" class="form-control" disabled value="{{ authenticated()->employee->info['gender'] }}">
                    </div>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ authenticated()->employee->info['phoneNumber'] }}" placeholder="Enter your phone"/>

                    </div>
                </div>
                <!--end::Group-->

            </div>
            
            <div class="separator separator-dashed"></div>

            <button type="submit" class="btn btn-success mt-5" name="submitButton">Save Changes</button>

        </form>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->
