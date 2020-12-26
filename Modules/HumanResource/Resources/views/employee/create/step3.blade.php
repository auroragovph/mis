 <!--begin::Wizard Step 3-->
 <div class="my-5 step" data-wizard-type="step-content">
    <h5 class="mb-10 font-weight-bold text-dark">Setup Account</h5>

    <!--begin::Group-->
    <div class="form-group">
        <label>Creation:</label>
        <div class="row">
            <div class="col-lg-6">
                <label class="option option-plain">
                    <span class="option-control">
                        <span class="radio">
                            <input x-model="formData.account" type="radio" name="account" value="default" checked/>
                            <span></span>
                        </span>
                    </span>
                    <span class="option-label">
                        <span class="option-head">
                            <span class="option-title">
                                Default
                            </span>
                        </span>
                        <span class="option-body">
                            Username will based on name and password will be the ID Card. User can change it after they login in the first time
                        </span>
                    </span>
                </label>
            </div>
            <div class="col-lg-6">
                <label class="option option option-plain">
                    <span class="option-control">
                        <span class="radio">
                            <input type="radio" name="account" value="manual" x-model="formData.account" />
                            <span></span>
                        </span>
                    </span>
                    <span class="option-label">
                        <span class="option-head">
                            <span class="option-title">
                                Manual
                            </span>
                        </span>
                        <span class="option-body">
                            You can choose username and password for the account.
                        </span>
                    </span>
                </label>
            </div>
        </div>
    </div>
    <!--end::Group-->

    <template x-if="formData.account == 'manual'">
        <div>
            <!--begin::Group-->
            <div class="form-group">
                <label>Username</label>
                <input x-model="formData.username" type="text" class="form-control form-control-solid form-control-lg" name="username" />
            </div>
            <!--end::Group-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control form-control-solid form-control-lg" name="password" />
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control form-control-solid form-control-lg" name="password_confirmation" />
                    </div>
                </div>
                <!--end::Group-->
            </div>
        </div>
    </template>


    
</div>
<!--end::Wizard Step 3-->