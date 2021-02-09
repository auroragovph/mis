<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Create New Role</h3>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" method="POST" action="{{ route('sys.acl.role.store') }}">
            @csrf
            <div class="form-group">
                <label for="">Name</label>
                <input name="name" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="">Permissions</label>
                <select name="permissions[]" class="form-control select2" multiple required>
                    @foreach($permissions as $permission)
                        <option>{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="separator separator-dashed mb-5"></div>
            <button type="submit" class="btn btn-primary mt-5" name="submitButton">Submit</button>
        </form>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->
