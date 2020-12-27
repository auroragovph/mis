
<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b tab-pane fade @if($refferer == 'sys.account.index') show active @endif" id="aclTab" role="tabpanel" aria-labelledby="aclTab-tab">
    <!--begin::Header-->
    <div class="card-header py-3">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Access Control Level (ACL)</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">Update your account credentials</span>
        </h3>
        
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form_acl" method="POST" action="{{ route('sys.account.acl.update', $employee->account->id) }}">
            @csrf

            <!--begin::Group-->
             <div class="form-group">
                <label>Role</label>
                <select id="kt_select2_role" class="form-control" name="role" data-api="{{ route('sys.acl.role.lists') }}" style="width: 100%;" required>
                   @foreach($employee->account->getRoleNames() as $role)
                    <option selected>{{ $role }}</option>
                   @endforeach
                </select>
                    
            </div>
            <!--end::Group-->

            <!--begin::Group-->
            <div class="form-group">
                <label>Permissions</label>
                <select id="kt_select2_permissions" class="form-control" multiple name="permissions[]" data-api="{{ route('sys.acl.permission.lists') }}" style="width: 100%;" required>
                    
                    @foreach($employee->account->getAllPermissions()->pluck('name') as $permission)
                        <option selected>{{ $permission }}</option>
                    @endforeach
                </select>
            </div>
            <!--end::Group-->

          

            <div class="separator separator-dashed"></div>

            <button type="submit" class="btn btn-success mt-5" name="submitButton">Save Changes</button>

        </form>
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->