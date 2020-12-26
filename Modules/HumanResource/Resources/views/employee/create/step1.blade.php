<!--begin::Wizard Step 1-->
<div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
    <h5 class="text-dark font-weight-bold mb-10">Employee Details:</h5>
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label text-left">Avatar</label>
        <div class="col-lg-9 col-xl-9">
            <div class="image-input image-input-outline" id="kt_user_add_avatar">
                <div class="image-input-wrapper" style="background-image: url({{ asset('media/users/blank.png') }})"></div>
                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="profile_avatar_remove" />
                </label>
                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                </span>
            </div>
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
        <div class="col-lg-9 col-xl-9">
            <input class="form-control form-control-solid form-control-lg" name="firstname" type="text"  x-model="formData.firstName" />
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">Middle Name</label>
        <div class="col-lg-9 col-xl-9">
            <input class="form-control form-control-solid form-control-lg" name="middlename" type="text" x-model="formData.middleName" />
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
        <div class="col-lg-9 col-xl-9">
            <input class="form-control form-control-solid form-control-lg" name="lastname" type="text" x-model="formData.lastName" />
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
        <div class="col-lg-9 col-xl-9">
            <div class="input-group input-group-solid input-group-lg">
                <div class="input-group-append">
                    <span class="input-group-text">+639</span>
                </div>
                <input type="text" class="form-control form-control-solid form-control-lg" name="phone" placeholder="Phone" x-model="formData.phone"/>
            </div>
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
        <div class="col-lg-9 col-xl-9">
            <input class="form-control form-control-solid form-control-lg" name="address" type="text" value="" x-model="formData.address"/>
        </div>
    </div>
    <!--end::Group-->
    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">Civil Status</label>
        <div class="col-lg-9 col-xl-9">
            <div class="input-group input-group-solid input-group-lg">
                <select name="civil" class="form-control form-control-solid form-control-lg" @change="formData.civil = $event.target.value">
                    <option value="">---Select---</option>
                    <option>Single</option>
                    <option>Married</option>
                    <option>Widowed</option>
                    <option>Anulled</option>
                    <option>Separated</option>
                </select>
            </div>
        </div>
    </div>
    <!--end::Group-->

    <!--begin::Group-->
    <div class="form-group row">
        <label class="col-xl-3 col-lg-3 col-form-label">Birth Date</label>
        <div class="col-lg-4 col-xl-4">
            <div class="input-group input-group-solid input-group-lg">
                <input class="form-control form-control-solid form-control-lg" name="birthday" type="date" value="" x-model="formData.birthday"/>
            
            </div>
        </div>

        <label class="col-xl-1 col-lg-1 col-form-label">Sex</label>
        <div class="col-lg-4 col-xl-4">
            <div class="input-group input-group-solid input-group-lg">
                <select name="sex" class="form-control form-control-solid form-control-lg" @change="formData.sex = $event.target.value">
                    <option value="">---Select---</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
        </div>
    </div>
    <!--end::Group-->

</div>
<!--end::Wizard Step 1-->