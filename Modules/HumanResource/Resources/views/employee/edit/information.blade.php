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
        <form class="form" id="kt_form_information" method="POST" action="{{ route('hrm.employee.update', $employee->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="firstname" value="{{ $employee->name['fname'] }}" placeholder="Eneter your name" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lastname" value="{{ $employee->name['lname'] }}" placeholder="Enter your lastname" required/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="middlename" value="{{ $employee->name['mname'] }}" placeholder="Enter your middle name"/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Suffix</label>
                        <input type="text" class="form-control" name="namesuffix" value="{{ $employee->name['sname'] }}" placeholder="Eg. Jr"/>
                    </div>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="nametitle" value="{{ $employee->name['title'] }}" placeholder="Eg. Atty"/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-4">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Birthdate</label>
                        <input type="text" name="birthday" class="form-control kt_datepicker" value="{{ date('m/d/Y') }}" readonly required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $employee->info['address'] }}" placeholder="Enter your address"/ required>
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
                                <option {{ sh($cs, $employee->info['civilStatus']) }}>{{ $cs }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Sex</label>
                        <select class="form-control selectpicker" name="sex" required>
                            <option value="">---SELECT---</option>
                            <option {{ sh($employee->info['gender'], 'Male') }}>Male</option>
                            <option {{ sh($employee->info['gender'], 'Female') }}>Female</option>
                        </select>
                    </div>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ $employee->info['phoneNumber'] }}" placeholder="Enter your phone"/>

                    </div>
                </div>
                <!--end::Group-->

            </div>

            <div class="form-group">
                <label for="">Avatar</label> <br>
                <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url(@if($employee->info['image'] == null) {{ asset('media/users/blank.png') }} @else {{ asset('storage/employees/profile/'.$employee->info['image']) }} @endif)">
                    <div class="image-input-wrapper"></div>
                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                        <i class="fa fa-pen icon-sm text-muted"></i>
                        <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="profile_avatar_remove" />
                    </label>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>
                </div>
            </div>

            <div class="separator separator-dashed"></div>

            <button type="submit" class="btn btn-success mt-5" name="submitButton">Save Changes</button>

        </form>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->
