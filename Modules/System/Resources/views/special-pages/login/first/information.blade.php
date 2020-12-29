<!--begin::Wizard Step 1-->
<div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
    <h5 class="text-dark font-weight-bold mb-10">Employee Details:</h5>


    <div class="row">
        <div class="col-md-6">
            <!--begin::Group-->
            <div class="form-group">
                <label>First Name</label>
                <input x-model="formData.firstName" type="text" class="form-control" name="firstname" placeholder="Enter your name" required/>
            </div>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <div class="form-group">
                <label>Last Name</label>
                <input x-model="formData.lastName" type="text" class="form-control" name="lastname" value="{{ auth()->user()->employee->name['lname'] }}" placeholder="Enter your lastname" required/>
            </div>
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-6">
            <!--begin::Group-->
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" name="middlename" value="{{ auth()->user()->employee->name['mname'] }}" placeholder="Enter your middle name"/>
            </div>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-3">
            <div class="form-group">
                <label>Suffix</label>
                <input type="text" class="form-control" name="namesuffix" value="{{ auth()->user()->employee->name['sname'] }}" placeholder="Eg. Jr"/>
            </div>
        </div>
        <!--end::Group-->

        <!--begin::Group-->
        <div class="col-md-3">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="nametitle" value="{{ auth()->user()->employee->name['title'] }}" placeholder="Eg. Atty"/>
            </div>
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-4">
            <!--begin::Group-->
            <div class="form-group">
                <label>Birthdate</label>
                <input type="date" name="birthday" class="form-control" value="{{ date('Y-m-d') }}" required/>
            </div>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-8">
            <div class="form-group">
                <label>Address</label>
                <input x-model="formData.address" type="text" class="form-control" name="address" value="{{ auth()->user()->employee->info['address'] }}" placeholder="Enter your address"/ required>
            </div>
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-4">
            <!--begin::Group-->
            <div class="form-group">
                <label>Civil Status</label>
                <select x-model="formData.civil" class="form-control selectpicker" name="civil" required>
                    <option value="">---SELECT---</option>
                    @foreach(config('static-lists.civilStatus') as $cs)
                        <option {{ sh($cs, auth()->user()->employee->info['civilStatus']) }}>{{ $cs }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--end::Group-->

        <!--begin::Group-->
        <div class="col-md-4">
            <div class="form-group">
                <label>Sex</label>
                <select x-model="formData.sex" class="form-control selectpicker" name="sex" required>
                    <option value="">---SELECT---</option>
                    <option {{ sh(auth()->user()->employee->info['gender'], 'Male') }}>Male</option>
                    <option {{ sh(auth()->user()->employee->info['gender'], 'Female') }}>Female</option>
                </select>
            </div>
        </div>
        <!--end::Group-->

        <!--begin::Group-->
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone</label>
                <input x-model="formData.phone" type="text" class="form-control" name="phone" value="{{ auth()->user()->employee->info['phoneNumber'] }}" placeholder="Enter your phone"/>

            </div>
        </div>
        <!--end::Group-->

    </div>

    <div class="form-group">
        <label for="">Avatar</label> <br>
        <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url(@if(auth()->user()->employee->info['image'] == null) {{ asset('media/users/blank.png') }} @else {{ asset('storage/employees/profile/'.auth()->user()->employee->info['image']) }} @endif)">
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

    

    
    

</div>
<!--end::Wizard Step 1-->