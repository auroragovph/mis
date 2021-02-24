<div class="tab-pane fade" id="credentialsTab" role="tabpanel" aria-labelledby="credentialsTab-tab">
    <!--begin::Advance Table: Widget 7-->
    <div class="card card-custom gutter-b" >
        <!--begin::Header-->
        <div class="card-header py-3">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Credentials</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Update your account credentials</span>
            </h3>
            
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
            <form class="form" id="kt_form_credentials" method="POST" action="{{ route('general.profile.credentials') }}">
                @csrf
                @method('PATCH')

                <!--begin::Group-->
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="{{ authenticated()->employee->account->username ?? '' }}" disabled>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" class="form-control" name="password_old" required>
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
                
                <div class="separator separator-dashed"></div>

                <button type="submit" class="btn btn-success mt-5" name="submitButton">Save Changes</button>

            </form>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Advance Table Widget 7-->

    {{-- <!--begin::Advance Table: Widget 7-->
    <div class="card card-custom gutter-b" >
        <!--begin::Header-->
        <div class="card-header py-3">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Access Control List</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Roles and Permissions</span>
            </h3>
            
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">

            <!--begin::Group-->
            <div class="form-group">
                <label>Role</label>
                <input type="text" class="form-control" name="username" value="{{ authenticated()->employee->account->username ?? '' }}">
            </div>
            <!--end::Group-->

            <!--begin::Group-->
            <div class="form-group">
                <label>Permissions</label>
                <input type="text" class="form-control" name="username" value="{{ authenticated()->employee->account->username ?? '' }}">
            </div>
            <!--end::Group-->

        </div>
        <!--end::Body-->
    </div>
    <!--end::Advance Table Widget 7--> --}}
</div>