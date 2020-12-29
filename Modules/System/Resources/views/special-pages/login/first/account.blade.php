 <!--begin::Wizard Step 3-->
 <div class="my-5 step" data-wizard-type="step-content">
    <h5 class="mb-10 font-weight-bold text-dark">Credentials</h5>

   <!--begin::Group-->
   <div class="form-group">
    <label>Username</label>
    <input x-model="formData.username" type="text" class="form-control" name="username" value="{{ auth()->user()->employee->account->username ?? '' }}">
    </div>
    <!--end::Group-->
    
    <div class="row">
        <div class="col-md-6">
            <!--begin::Group-->
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="password"/>
            </div>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation"/>
            </div>
        </div>
        <!--end::Group-->
    </div>



    
</div>
<!--end::Wizard Step 3-->